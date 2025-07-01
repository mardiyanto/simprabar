<?php
namespace App\Controllers;
use App\Models\BarangModel;
use App\Models\RuanganModel;

class Barang extends BaseController
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
        $barangModel = new BarangModel();
        $ruanganModel = new RuanganModel();
        $barang = $barangModel->select('barang.*, ruangan.nama_ruangan')
            ->join('ruangan', 'ruangan.id = barang.ruangan_id', 'left')
            ->findAll();
        $ruangan = $ruanganModel->findAll();
        return view('dashboard/barang/index', ['barang' => $barang, 'ruangan' => $ruangan]);
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
        $barangModel = new BarangModel();
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'deskripsi_barang' => $this->request->getPost('deskripsi_barang'),
            'ruangan_id' => $this->request->getPost('ruangan_id'),
        ];
        $barangModel->insert($data);
        return redirect()->to('/barang')->with('success', 'Barang berhasil ditambahkan.');
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
        $barangModel = new BarangModel();
        $barang = $barangModel->find($id);
        return $this->response->setJSON($barang);
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
        $barangModel = new BarangModel();
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'deskripsi_barang' => $this->request->getPost('deskripsi_barang'),
            'ruangan_id' => $this->request->getPost('ruangan_id'),
        ];
        $barangModel->update($id, $data);
        return redirect()->to('/barang')->with('success', 'Barang berhasil diupdate.');
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
        $barangModel = new BarangModel();
        $barangModel->delete($id);
        return redirect()->to('/barang')->with('success', 'Barang berhasil dihapus.');
    }
} 