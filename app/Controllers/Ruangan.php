<?php
namespace App\Controllers;
use App\Models\RuanganModel;

class Ruangan extends BaseController
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
        $model = new RuanganModel();
        $ruangan = $model->findAll();
        return view('dashboard/ruangan/index', ['ruangan' => $ruangan]);
    }

    public function store()
    {
        $model = new RuanganModel();
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ];
        $model->insert($data);
        return redirect()->to('/ruangan')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $model = new RuanganModel();
        $ruangan = $model->find($id);
        return $this->response->setJSON($ruangan);
    }

    public function update($id)
    {
        $model = new RuanganModel();
        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
        ];
        $model->update($id, $data);
        return redirect()->to('/ruangan')->with('success', 'Ruangan berhasil diupdate.');
    }

    public function delete($id)
    {
        $model = new RuanganModel();
        $model->delete($id);
        return redirect()->to('/ruangan')->with('success', 'Ruangan berhasil dihapus.');
    }
} 