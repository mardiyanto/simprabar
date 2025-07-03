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
        $roleFilter = $this->request->getGet('role') ?: 'admin';
        $userModel = new UserModel();
        $users = $userModel->where('role', $roleFilter)->findAll();
        // Ambil data ruangan untuk select
        $ruanganModel = new \App\Models\RuanganModel();
        $ruangan = $ruanganModel->findAll();
        return view('dashboard/user/index', ['users' => $users, 'ruangan' => $ruangan, 'roleFilter' => $roleFilter]);
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
        if ($data['role'] === 'ruangan') {
            $data['ruangan_id'] = $this->request->getPost('ruangan_id');
        }
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
        if ($data['role'] === 'ruangan') {
            $data['ruangan_id'] = $this->request->getPost('ruangan_id');
        } else {
            $data['ruangan_id'] = null;
        }
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