<?php
namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login/index');
    }

    public function doLogin()
    {
        $session = session();
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'nama' => $user['nama'],
                'logged_in' => true,
                'ruangan_id' => isset($user['ruangan_id']) ? $user['ruangan_id'] : null
            ]);
            // Redirect sesuai role
            if ($user['role'] == 'admin') {
                return redirect()->to('/dashboard/admin');
            } elseif ($user['role'] == 'ruangan') {
                return redirect()->to('/dashboard/ruangan');
            } elseif ($user['role'] == 'it') {
                return redirect()->to('/dashboard/it');
            }
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
