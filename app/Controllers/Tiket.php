<?php
namespace App\Controllers;
use App\Models\TiketModel;
use App\Models\RuanganModel;
use App\Models\BarangModel;

class Tiket extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $ruanganModel = new RuanganModel();
        $barangModel = new BarangModel();
        $role = $session->get('role');
        $user_id = $session->get('user_id');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $builder = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left');
        if ($role === 'admin' || $role === 'it') {
            // Tidak ada filter role
        } else if ($role === 'ruangan') {
            $builder->where('tiket.ruangan_id', $session->get('ruangan_id'));
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('tiket.created_at >=', $tanggal_mulai.' 00:00:00');
            $builder->where('tiket.created_at <=', $tanggal_akhir.' 23:59:59');
        }
        $tiket = $builder->orderBy('tiket.created_at', 'DESC')->findAll();
        
        // Hitung durasi untuk setiap tiket
        foreach ($tiket as &$t) {
            if ($t['updated_at'] && $t['status'] !== 'Menunggu') {
                $created = new \DateTime($t['created_at']);
                $updated = new \DateTime($t['updated_at']);
                $interval = $created->diff($updated);
                $t['durasi'] = $interval->format('%d hari %h jam %i menit');
            } else {
                $t['durasi'] = '-';
            }
        }
        
        if ($role === 'admin' || $role === 'it') {
            $ruangan = $ruanganModel->findAll();
        } else if ($role === 'ruangan') {
            $ruangan_id = $session->get('ruangan_id');
            $ruangan = $ruanganModel->where('id', $ruangan_id)->findAll();
        } else {
            $ruangan = [];
        }
        $barang = $barangModel->findAll();
        return view('dashboard/tiket/index', [
            'tiket' => $tiket,
            'ruangan' => $ruangan,
            'barang' => $barang,
            'role' => $role,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
        ]);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        // Generate nomor tiket otomatis menggunakan tanggal dan waktu per detik
        $nomor_tiket = 'TIK' . date('YmdHis'); // Format: TIK + YYYYMMDD + HHMMSS
        $data = [
            'nomor_tiket' => $nomor_tiket,
            'ruangan_id' => $this->request->getPost('ruangan_id'),
            'barang_id' => $this->request->getPost('barang_id'),
            'deskripsi_kerusakan' => $this->request->getPost('deskripsi_kerusakan'),
            'status' => 'Menunggu',
            'hasil_perbaikan' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        // Jika admin, cek input created_at_manual
        if ($session->get('role') === 'admin') {
            $created_at_manual = $this->request->getPost('created_at_manual');
            if ($created_at_manual) {
                // Format dari input: 2024-07-01T13:00
                $data['created_at'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $created_at_manual)));
            }
        }
        // Handle upload foto kerusakan
        $foto = $this->request->getFile('foto_kerusakan');
        $foto_base64 = $this->request->getPost('foto_kerusakan_camera');
        if ($foto_base64) {
            // Jika upload dari kamera (base64)
            $data['foto_kerusakan'] = $this->saveBase64Image($foto_base64);
        } else if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads', $newName);
            $data['foto_kerusakan'] = $newName;
        }
        $tiketModel->insert($data);
        return redirect()->to('/tiket')->with('success', 'Tiket berhasil dibuat.');
    }

    public function edit($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $tiket = $tiketModel->find($id);
        return $this->response->setJSON($tiket);
    }

    public function update($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $data = [
            'deskripsi_perbaikan' => $this->request->getPost('deskripsi_perbaikan'),
            'status' => $this->request->getPost('status'),
            'hasil_perbaikan' => $this->request->getPost('hasil_perbaikan'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // Jika admin, cek input updated_at_manual
        if ($session->get('role') === 'admin') {
            $updated_at_manual = $this->request->getPost('updated_at_manual');
            if ($updated_at_manual) {
                $data['updated_at'] = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $updated_at_manual)));
            }
        }
        // Handle upload foto perbaikan
        $foto = $this->request->getFile('foto_perbaikan');
        $foto_base64 = $this->request->getPost('foto_perbaikan_camera');
        if ($foto_base64) {
            $data['foto_perbaikan'] = $this->saveBase64Image($foto_base64);
        } else if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads', $newName);
            $data['foto_perbaikan'] = $newName;
        }
        $tiketModel->update($id, $data);
        return redirect()->to('/tiket')->with('success', 'Tiket berhasil diupdate.');
    }

    public function detail($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $ruanganModel = new RuanganModel();
        $barangModel = new BarangModel();
        $tiket = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left')
            ->where('tiket.id', $id)
            ->first();
            
        // Hitung durasi untuk tiket ini
        if ($tiket['updated_at'] && $tiket['status'] !== 'Menunggu') {
            $created = new \DateTime($tiket['created_at']);
            $updated = new \DateTime($tiket['updated_at']);
            $interval = $created->diff($updated);
            $tiket['durasi'] = $interval->format('%d hari %h jam %i menit');
        } else {
            $tiket['durasi'] = '-';
        }
        
        return view('dashboard/tiket/detail', [
            'tiket' => $tiket
        ]);
    }

    public function exportExcel()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $role = $session->get('role');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $builder = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left');
        if ($role === 'ruangan') {
            $builder->where('tiket.ruangan_id', $session->get('ruangan_id'));
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('tiket.created_at >=', $tanggal_mulai.' 00:00:00');
            $builder->where('tiket.created_at <=', $tanggal_akhir.' 23:59:59');
        }
        $tiket = $builder->orderBy('tiket.created_at', 'DESC')->findAll();
        
        // Hitung durasi untuk setiap tiket
        foreach ($tiket as &$t) {
            if ($t['updated_at'] && $t['status'] !== 'Menunggu') {
                $created = new \DateTime($t['created_at']);
                $updated = new \DateTime($t['updated_at']);
                $interval = $created->diff($updated);
                $t['durasi'] = $interval->format('%d hari %h jam %i menit');
            } else {
                $t['durasi'] = '-';
            }
        }
        
        // Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Tiket');
        $sheet->setCellValue('C1', 'Ruangan');
        $sheet->setCellValue('D1', 'Barang');
        $sheet->setCellValue('E1', 'Deskripsi Kerusakan');
        $sheet->setCellValue('F1', 'Status');
        $sheet->setCellValue('G1', 'Hasil');
        $sheet->setCellValue('H1', 'Waktu Dibuat');
        $sheet->setCellValue('I1', 'Waktu Selesai');
        $sheet->setCellValue('J1', 'Durasi Penanganan');
        $row = 2;
        foreach ($tiket as $i => $t) {
            $sheet->setCellValue('A'.$row, $i+1);
            $sheet->setCellValue('B'.$row, $t['nomor_tiket']);
            $sheet->setCellValue('C'.$row, $t['nama_ruangan']);
            $sheet->setCellValue('D'.$row, $t['nama_barang']);
            $sheet->setCellValue('E'.$row, $t['deskripsi_kerusakan']);
            $sheet->setCellValue('F'.$row, $t['status']);
            $sheet->setCellValue('G'.$row, $t['hasil_perbaikan']);
            $sheet->setCellValue('H'.$row, $t['created_at']);
            $sheet->setCellValue('I'.$row, $t['updated_at'] ?: '-');
            $sheet->setCellValue('J'.$row, $t['durasi']);
            $row++;
        }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'laporan_tiket_'.date('Ymd_His').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $role = $session->get('role');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $builder = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left');
        if ($role === 'ruangan') {
            $builder->where('tiket.ruangan_id', $session->get('ruangan_id'));
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('tiket.created_at >=', $tanggal_mulai.' 00:00:00');
            $builder->where('tiket.created_at <=', $tanggal_akhir.' 23:59:59');
        }
        $tiket = $builder->orderBy('tiket.created_at', 'DESC')->findAll();
        
        // Hitung durasi untuk setiap tiket
        foreach ($tiket as &$t) {
            if ($t['updated_at'] && $t['status'] !== 'Menunggu') {
                $created = new \DateTime($t['created_at']);
                $updated = new \DateTime($t['updated_at']);
                $interval = $created->diff($updated);
                $t['durasi'] = $interval->format('%d hari %h jam %i menit');
            } else {
                $t['durasi'] = '-';
            }
        }
        
        // PDF
        $html = view('dashboard/tiket/pdf', ['tiket' => $tiket]);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_tiket_'.date('Ymd_His').'.pdf', ['Attachment' => true]);
        exit;
    }

    // Tambahkan fungsi helper untuk simpan base64 image
    private function saveBase64Image($base64)
    {
        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
        $data = base64_decode($base64);
        $filename = uniqid('img_') . '.png';
        $filepath = FCPATH . 'uploads/' . $filename;
        file_put_contents($filepath, $data);
        return $filename;
    }

    public function delete($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $tiket = $tiketModel->find($id);
        $role = $session->get('role');
        // Hanya admin/it/ruangan pemilik tiket yang boleh hapus
        if ($role === 'admin' || $role === 'it' || ($role === 'ruangan' && $tiket['ruangan_id'] == $session->get('ruangan_id'))) {
            $tiketModel->delete($id);
            return redirect()->to('/tiket')->with('success', 'Tiket berhasil dihapus.');
        } else {
            return redirect()->to('/tiket')->with('error', 'Tidak diizinkan menghapus tiket ini.');
        }
    }

    // Form edit data tiket (bukan update status)
    public function editData($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $ruanganModel = new RuanganModel();
        $barangModel = new BarangModel();
        $tiket = $tiketModel->find($id);
        $role = $session->get('role');
        // Hanya admin/it/ruangan pemilik tiket yang boleh edit jika status masih Menunggu
        if (($role === 'admin' || $role === 'it' || ($role === 'ruangan' && $tiket['ruangan_id'] == $session->get('ruangan_id'))) && $tiket['status'] === 'Menunggu') {
            $ruangan = ($role === 'admin' || $role === 'it') ? $ruanganModel->findAll() : $ruanganModel->where('id', $session->get('ruangan_id'))->findAll();
            $barang = $barangModel->findAll();
            return view('dashboard/tiket/edit', [
                'tiket' => $tiket,
                'ruangan' => $ruangan,
                'barang' => $barang,
                'role' => $role
            ]);
        } else {
            return redirect()->to('/tiket')->with('error', 'Tidak diizinkan mengedit tiket ini.');
        }
    }

    // Update data tiket (bukan status)
    public function updateData($id)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $tiketModel = new TiketModel();
        $tiket = $tiketModel->find($id);
        $role = $session->get('role');
        if (($role === 'admin' || $role === 'it' || ($role === 'ruangan' && $tiket['ruangan_id'] == $session->get('ruangan_id'))) && $tiket['status'] === 'Menunggu') {
            $data = [
                'ruangan_id' => $this->request->getPost('ruangan_id'),
                'barang_id' => $this->request->getPost('barang_id'),
                'deskripsi_kerusakan' => $this->request->getPost('deskripsi_kerusakan'),
            ];
            $tiketModel->update($id, $data);
            return redirect()->to('/tiket')->with('success', 'Data tiket berhasil diupdate.');
        } else {
            return redirect()->to('/tiket')->with('error', 'Tidak diizinkan mengedit tiket ini.');
        }
    }

    public function getBarangByRuangan($ruangan_id)
    {
        $barangModel = new BarangModel();
        $barang = $barangModel->where('ruangan_id', $ruangan_id)->findAll();
        return $this->response->setJSON($barang);
    }
} 