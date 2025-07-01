<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        return view('dashboard/admin');
    }

    public function ruangan()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'ruangan') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        return view('dashboard/ruangan');
    }

    public function it()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'it') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        return view('dashboard/it');
    }
} 