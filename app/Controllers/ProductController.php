<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('products/index', ['title' => 'Products', 'products' => $this->productModel->orderBy('id', 'DESC')->findAll()]);
    }

    public function create()
    {
        return view('products/create', ['title' => 'Add Product']);
    }

    public function store()
    {
        $rules = ['name' => 'required|min_length[2]|max_length[100]', 'price' => 'required|decimal|greater_than_equal_to[0]', 'stock_quantity' => 'required|integer|greater_than_equal_to[0]', 'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]'];
        if (!$this->validate($rules)) return view('products/create', ['title' => 'Add Product', 'validation' => $this->validator]);
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/products', $imageName);
        $this->productModel->insert(['name' => trim($this->request->getPost('name')), 'price' => $this->request->getPost('price'), 'stock_quantity' => $this->request->getPost('stock_quantity'), 'image' => $imageName, 'created_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('/products')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('/products')->with('error', 'Product not found.');
        return view('products/edit', ['title' => 'Edit Product', 'product' => $product]);
    }

    public function update($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('/products')->with('error', 'Product not found.');
        $rules = ['name' => 'required|min_length[2]|max_length[100]', 'price' => 'required|decimal|greater_than_equal_to[0]', 'stock_quantity' => 'required|integer|greater_than_equal_to[0]', 'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]'];
        if (!$this->validate($rules)) return view('products/edit', ['title' => 'Edit Product', 'product' => $product, 'validation' => $this->validator]);
        $data = ['name' => trim($this->request->getPost('name')), 'price' => $this->request->getPost('price'), 'stock_quantity' => $this->request->getPost('stock_quantity')];
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);
            if (!empty($product['image']) && is_file(FCPATH . 'uploads/products/' . $product['image'])) unlink(FCPATH . 'uploads/products/' . $product['image']);
            $data['image'] = $imageName;
        }
        $this->productModel->update($id, $data);
        return redirect()->to('/products')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('/products')->with('error', 'Product not found.');
        try { $this->productModel->delete($id); } catch (\Throwable $e) { return redirect()->to('/products')->with('error', 'This product cannot be deleted because it has sales history.'); }
        if (!empty($product['image']) && is_file(FCPATH . 'uploads/products/' . $product['image'])) unlink(FCPATH . 'uploads/products/' . $product['image']);
        return redirect()->to('/products')->with('success', 'Product deleted successfully.');
    }
}
