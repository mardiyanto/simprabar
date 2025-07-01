<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class User extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        // if ($session->get('role') !== 'admin') {
        //     return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        // }
        $userModel = new UserModel();
        $users = $userModel->findAll();
        return view('dashboard/user/index', ['users' => $users]);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
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
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        $userModel = new UserModel();
        $user = $userModel->find($id);
        return $this->response->setJSON($user);
    }

    public function update($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
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
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        $userModel = new UserModel();
        $userModel->delete($id);
        return redirect()->to('/user')->with('success', 'User berhasil dihapus.');
    }
} 