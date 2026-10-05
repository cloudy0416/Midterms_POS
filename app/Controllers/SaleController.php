<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\SaleModel;

class SaleController extends BaseController
{
    protected $productModel;
    protected $customerModel;
    protected $saleModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
        $this->saleModel = new SaleModel();
    }

    /*
    |--------------------------------------------------------------------------
    | Point of Sale
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $data = [
            'title' => 'Point of Sale',
            'products' => $this->productModel->findAll(),
            'customers' => $this->customerModel->findAll()
        ];

        return view('sales/index', $data);
    }


    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        $cart = $this->request->getPost('cart');
        $customerId = $this->request->getPost('customer_id');
        $payment = (float) $this->request->getPost('payment');


        /*
        |--------------------------------------------------------------------------
        | Validate Cart
        |--------------------------------------------------------------------------
        */

        if (empty($cart)) {
            return redirect()->back()
                ->with('error', 'Cart is empty.');
        }

        $cart = json_decode($cart, true);

        if (!is_array($cart) || empty($cart)) {
            return redirect()->back()
                ->with('error', 'Invalid cart data.');
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Total
        |--------------------------------------------------------------------------
        */

        $cartTotal = 0;

        foreach ($cart as $item) {

            if (
                !isset($item['id']) ||
                !isset($item['quantity'])
            ) {
                return redirect()->back()
                    ->with('error', 'Invalid cart item.');
            }

            $product = $this->productModel->find($item['id']);

            if (!$product) {
                return redirect()->back()
                    ->with('error', 'Product not found.');
            }

            $quantity = (int) $item['quantity'];

            if ($quantity <= 0) {
                return redirect()->back()
                    ->with('error', 'Invalid quantity.');
            }

            if ($quantity > $product['stock_quantity']) {
                return redirect()->back()
                    ->with(
                        'error',
                        'Not enough stock for ' . $product['name'] . '.'
                    );
            }

            $cartTotal +=
                $product['price'] * $quantity;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Payment
        |--------------------------------------------------------------------------
        */

        if ($payment <= 0) {
            return redirect()->back()
                ->with('error', 'Please enter a valid payment amount.');
        }

        if ($payment < $cartTotal) {
            return redirect()->back()
                ->with('error', 'Payment is not enough.');
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Change
        |--------------------------------------------------------------------------
        */

        $change = $payment - $cartTotal;


        /*
        |--------------------------------------------------------------------------
        | Start Database Transaction
        |--------------------------------------------------------------------------
        */

        $db = \Config\Database::connect();

        $db->transStart();

        $firstSaleId = null;


        /*
        |--------------------------------------------------------------------------
        | Save Each Sale
        |--------------------------------------------------------------------------
        */

        foreach ($cart as $item) {

            $product = $this->productModel->find($item['id']);

            if (!$product) {

                $db->transRollback();

                return redirect()->back()
                    ->with('error', 'Product not found.');
            }

            $quantity = (int) $item['quantity'];


            /*
            |--------------------------------------------------------------------------
            | Double Check Stock
            |--------------------------------------------------------------------------
            */

            if ($quantity > $product['stock_quantity']) {

                $db->transRollback();

                return redirect()->back()
                    ->with(
                        'error',
                        'Not enough stock for ' . $product['name'] . '.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Calculate Item Total
            |--------------------------------------------------------------------------
            */

            $totalPrice =
                $product['price'] * $quantity;


            /*
            |--------------------------------------------------------------------------
            | Insert Sale
            |--------------------------------------------------------------------------
            */

            $this->saleModel->insert([
                'product_id' => $product['id'],
                'customer_id' => !empty($customerId)
                    ? $customerId
                    : null,
                'sold_by' => session()->get('user_id'),
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => date('Y-m-d H:i:s')
            ]);


            /*
            |--------------------------------------------------------------------------
            | Get First Sale ID
            |--------------------------------------------------------------------------
            */

            if ($firstSaleId === null) {
                $firstSaleId =
                    $this->saleModel->getInsertID();
            }


            /*
            |--------------------------------------------------------------------------
            | Update Stock
            |--------------------------------------------------------------------------
            */

            $newStock =
                $product['stock_quantity'] - $quantity;

            $this->productModel->update(
                $product['id'],
                [
                    'stock_quantity' => $newStock
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Complete Transaction
        |--------------------------------------------------------------------------
        */

        $db->transComplete();


        if ($db->transStatus() === false) {

            return redirect()->back()
                ->with(
                    'error',
                    'Something went wrong while processing the sale.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Store Payment and Change in Session
        |--------------------------------------------------------------------------
        */

        session()->set([
            'receipt_payment' => $payment,
            'receipt_change' => $change
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect to Receipt
        |--------------------------------------------------------------------------
        */

        return redirect()->to(
            '/sales/receipt/' . $firstSaleId
        )->with(
            'success',
            'Sale completed successfully!'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Sales History
    |--------------------------------------------------------------------------
    */

    public function history()
    {
        $db = \Config\Database::connect();

        $sales = $db->table('sales')
            ->select('
                sales.id,
                products.name AS product_name,
                customers.full_name AS customer_name,
                users.full_name AS staff_name,
                sales.quantity,
                sales.total_price,
                sales.created_at
            ')
            ->join(
                'products',
                'products.id = sales.product_id'
            )
            ->join(
                'customers',
                'customers.id = sales.customer_id',
                'left'
            )
            ->join(
                'users',
                'users.id = sales.sold_by'
            )
            ->orderBy(
                'sales.id',
                'DESC'
            )
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Sales History',
            'sales' => $sales
        ];

        return view(
            'sales/history',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    public function receipt($saleId)
    {
        $db = \Config\Database::connect();

        $sale = $db->table('sales')
            ->select('
                sales.id,
                sales.product_id,
                sales.customer_id,
                sales.sold_by,
                sales.quantity,
                sales.total_price,
                sales.created_at,

                products.name AS product_name,
                products.price AS product_price,

                customers.full_name AS customer_name,

                users.full_name AS staff_name
            ')
            ->join(
                'products',
                'products.id = sales.product_id'
            )
            ->join(
                'customers',
                'customers.id = sales.customer_id',
                'left'
            )
            ->join(
                'users',
                'users.id = sales.sold_by'
            )
            ->where(
                'sales.id',
                $saleId
            )
            ->get()
            ->getRowArray();


        /*
        |--------------------------------------------------------------------------
        | Receipt Not Found
        |--------------------------------------------------------------------------
        */

        if (!$sale) {

            return redirect()->to('/sales')
                ->with(
                    'error',
                    'Receipt not found.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Receipt Data
        |--------------------------------------------------------------------------
        */

        $data = [
            'title' => 'Receipt',
            'sale' => $sale
        ];


        return view(
            'sales/receipt',
            $data
        );
    }
}
