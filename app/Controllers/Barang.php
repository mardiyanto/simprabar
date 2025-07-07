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

    public function storeBulk()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }
        $ruangan_id = $this->request->getPost('ruangan_id');
        $nama_barang = $this->request->getPost('nama_barang');
        $deskripsi_barang = $this->request->getPost('deskripsi_barang');
        // Validasi
        if (!$ruangan_id || !is_array($nama_barang) || !is_array($deskripsi_barang)) {
            return redirect()->to('/barang')->with('error', 'Data tidak lengkap.');
        }
        $barangModel = new \App\Models\BarangModel();
        $dataInsert = [];
        foreach ($nama_barang as $i => $nama) {
            $nama = trim($nama);
            $deskripsi = isset($deskripsi_barang[$i]) ? trim($deskripsi_barang[$i]) : '';
            if ($nama === '' || $deskripsi === '') {
                return redirect()->to('/barang')->with('error', 'Semua field harus diisi.');
            }
            $dataInsert[] = [
                'nama_barang' => $nama,
                'deskripsi_barang' => $deskripsi,
                'ruangan_id' => $ruangan_id
            ];
        }
        // Insert semua data
        foreach ($dataInsert as $row) {
            $barangModel->insert($row);
        }
        return redirect()->to('/barang')->with('success', 'Semua barang berhasil ditambahkan.');
    }
} 