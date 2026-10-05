<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct() { $this->userModel = new UserModel(); }

    public function index() { return view('users/index', ['title' => 'Users', 'users' => $this->userModel->orderBy('id', 'DESC')->findAll()]); }

    public function create() { return view('users/create', ['title' => 'Add User']); }

    public function store()
    {
        $rules = ['username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]', 'full_name' => 'required|min_length[2]|max_length[100]', 'password' => 'required|min_length[8]|max_length[255]', 'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]'];
        if (!$this->validate($rules)) return view('users/create', ['title' => 'Add User', 'validation' => $this->validator]);
        $avatarName = null;
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) { $avatarName = $avatar->getRandomName(); $avatar->move(FCPATH . 'uploads/avatars', $avatarName); }
        $this->userModel->insert(['username' => trim($this->request->getPost('username')), 'full_name' => trim($this->request->getPost('full_name')), 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), 'avatar' => $avatarName, 'created_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('/users')->with('success', 'User added successfully.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to('/users')->with('error', 'User not found.');
        return view('users/edit', ['title' => 'Edit User', 'user' => $user]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to('/users')->with('error', 'User not found.');
        $rules = ['username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username,id,' . $id . ']', 'full_name' => 'required|min_length[2]|max_length[100]', 'password' => 'permit_empty|min_length[8]|max_length[255]', 'avatar' => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]'];
        if (!$this->validate($rules)) return view('users/edit', ['title' => 'Edit User', 'user' => $user, 'validation' => $this->validator]);
        $data = ['username' => trim($this->request->getPost('username')), 'full_name' => trim($this->request->getPost('full_name'))];
        $password = $this->request->getPost('password');
        if ($password !== null && $password !== '') $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->isValid() && !$avatar->hasMoved()) { $avatarName = $avatar->getRandomName(); $avatar->move(FCPATH . 'uploads/avatars', $avatarName); if (!empty($user['avatar']) && is_file(FCPATH . 'uploads/avatars/' . $user['avatar'])) unlink(FCPATH . 'uploads/avatars/' . $user['avatar']); $data['avatar'] = $avatarName; }
        $this->userModel->update($id, $data);
        if ((int) session()->get('user_id') === (int) $id) session()->set(['username' => $data['username'], 'full_name' => $data['full_name']]);
        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        if ((int) session()->get('user_id') === (int) $id) return redirect()->to('/users')->with('error', 'You cannot delete the account currently in use.');
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to('/users')->with('error', 'User not found.');
        try { $this->userModel->delete($id); } catch (\Throwable $e) { return redirect()->to('/users')->with('error', 'This staff account cannot be deleted because it has sales history.'); }
        if (!empty($user['avatar']) && is_file(FCPATH . 'uploads/avatars/' . $user['avatar'])) unlink(FCPATH . 'uploads/avatars/' . $user['avatar']);
        return redirect()->to('/users')->with('success', 'User deleted successfully.');
    }
}
