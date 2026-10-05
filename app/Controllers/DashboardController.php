<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use App\Models\SaleModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();
        $userModel = new UserModel();
        $saleModel = new SaleModel();

        $db = \Config\Database::connect();

        // Total sales amount
        $totalSales = $saleModel
            ->selectSum('total_price')
            ->get()
            ->getRow()
            ->total_price ?? 0;

        // Today's sales amount
        $todaySales = $saleModel
            ->selectSum('total_price')
            ->where(
                'DATE(created_at)',
                date('Y-m-d'),
                false
            )
            ->get()
            ->getRow()
            ->total_price ?? 0;

        // Low stock products
        $lowStockProducts = $productModel
            ->where('stock_quantity <=', 5)
            ->orderBy('stock_quantity', 'ASC')
            ->findAll();

        // Recent sales
        $recentSales = $db->table('sales')
            ->select('
                sales.id,
                products.name AS product_name,
                customers.full_name AS customer_name,
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
            ->orderBy('sales.id', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Dashboard',

            'productCount' =>
                $productModel->countAll(),

            'customerCount' =>
                $customerModel->countAll(),

            'userCount' =>
                $userModel->countAll(),

            'saleCount' =>
                $saleModel->countAll(),

            'totalSales' =>
                $totalSales,

            'todaySales' =>
                $todaySales,

            'lowStockProducts' =>
                $lowStockProducts,

            'recentSales' =>
                $recentSales
        ];

        return view('dashboard/index', $data);
    }
}