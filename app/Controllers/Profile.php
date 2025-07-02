<?php
namespace App\Controllers;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $session = session();
        $user_id = $session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }
        $userModel = new UserModel();
        $user = $userModel->find($user_id);
        return view('dashboard/profile/index', [
            'user' => $user
        ]);
    }

    public function update()
    {
        $session = session();
        $user_id = $session->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login');
        }
        $userModel = new UserModel();
        $user = $userModel->find($user_id);
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            if (strlen($password) < 6) {
                return redirect()->back()->with('error', 'Password minimal 6 karakter');
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        // Cek username unik (kecuali username lama)
        $cek = $userModel->where('username', $data['username'])->where('id !=', $user_id)->first();
        if ($cek) {
            return redirect()->back()->with('error', 'Username sudah digunakan user lain');
        }
        $userModel->update($user_id, $data);
        // Update session jika nama/username berubah
        $session->set('username', $data['username']);
        $session->set('nama', $data['nama']);
        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui');
    }
} 