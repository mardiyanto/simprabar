<?php
namespace App\Controllers;
use App\Models\RuanganModel;

class Ruangan extends BaseController
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
        $model = new RuanganModel();
        $ruangan = $model->findAll();
        return view('dashboard/ruangan/index', ['ruangan' => $ruangan]);
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
        $model = new RuanganModel();
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ];
        $model->insert($data);
        return redirect()->to('/ruangan')->with('success', 'Ruangan berhasil ditambahkan.');
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
        $model = new RuanganModel();
        $ruangan = $model->find($id);
        return $this->response->setJSON($ruangan);
    }

    public function update($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/login' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        $model = new RuanganModel();
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ];
        $model->update($id, $data);
        return redirect()->to('/ruangan')->with('success', 'Ruangan berhasil diupdate.');
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
        $model = new RuanganModel();
        $model->delete($id);
        return redirect()->to('/ruangan')->with('success', 'Ruangan berhasil dihapus.');
    }
} 