<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class User extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();
        return view('dashboard/user/index', ['users' => $users]);
    }

    public function store()
    {
        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $userModel->insert($data);
        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        return $this->response->setJSON($user);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $userModel->update($id, $data);
        return redirect()->to('/user')->with('success', 'User berhasil diupdate.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/user')->with('success', 'User berhasil dihapus.');
    }
} 