<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Customers',
            'customers' => $this->customerModel->findAll()
        ];

        return view('customers/index', $data);
    }

    public function create()
    {
        return view('customers/create', [
            'title' => 'Add Customer'
        ]);
    }

    public function store()
    {
        $rules = ['full_name' => 'required|min_length[2]|max_length[100]', 'email' => 'required|valid_email|max_length[100]', 'phone' => 'permit_empty|max_length[20]'];
        if (!$this->validate($rules)) return view('customers/create', ['title' => 'Add Customer', 'validation' => $this->validator]);
        $this->customerModel->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/customers')
            ->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customers')
                ->with('error', 'Customer not found.');
        }

        return view('customers/edit', [
            'title' => 'Edit Customer',
            'customer' => $customer
        ]);
    }

    public function update($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customers')
                ->with('error', 'Customer not found.');
        }

        $rules = ['full_name' => 'required|min_length[2]|max_length[100]', 'email' => 'required|valid_email|max_length[100]', 'phone' => 'permit_empty|max_length[20]'];
        if (!$this->validate($rules)) return view('customers/edit', ['title' => 'Edit Customer', 'customer' => $customer, 'validation' => $this->validator]);
        $this->customerModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ]);

        return redirect()->to('/customers')
            ->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customers')
                ->with('error', 'Customer not found.');
        }

        try {
            $this->customerModel->delete($id);
        } catch (\Throwable $e) {
            return redirect()->to('/customers')->with('error', 'This customer cannot be deleted because they have sales history.');
        }

        return redirect()->to('/customers')
            ->with('success', 'Customer deleted successfully.');
    }
}
