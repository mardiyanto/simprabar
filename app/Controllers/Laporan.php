<?php
namespace App\Controllers;
use App\Models\TiketModel;
use App\Models\RuanganModel;
use App\Models\BarangModel;

class Laporan extends BaseController
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
        $status = $this->request->getGet('status');
        $hasil = $this->request->getGet('hasil_perbaikan');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $builder = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left');
        if ($role === 'ruangan') {
            $builder->where('tiket.ruangan_id', $session->get('ruangan_id'));
        }
        if ($status) {
            $builder->where('tiket.status', $status);
        }
        if ($hasil) {
            $builder->where('tiket.hasil_perbaikan', $hasil);
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('tiket.created_at >=', $tanggal_mulai.' 00:00:00');
            $builder->where('tiket.created_at <=', $tanggal_akhir.' 23:59:59');
        }
        $tiket = $builder->orderBy('tiket.created_at', 'DESC')->findAll();
        // Statistik
        $stat = [
            'menunggu' => $tiketModel->where('status', 'Menunggu')->countAllResults(),
            'diproses' => $tiketModel->where('status', 'Diproses')->countAllResults(),
            'selesai' => $tiketModel->where('status', 'Selesai')->countAllResults(),
            'diperbaiki' => $tiketModel->where('hasil_perbaikan', 'Diperbaiki')->countAllResults(),
            'service' => $tiketModel->where('hasil_perbaikan', 'Service Center')->countAllResults(),
            'rusak' => $tiketModel->where('hasil_perbaikan', 'Rusak Total')->countAllResults(),
        ];
        return view('dashboard/laporan/index', [
            'tiket' => $tiket,
            'stat' => $stat,
            'status' => $status,
            'hasil_perbaikan' => $hasil,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_akhir' => $tanggal_akhir
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
        $status = $this->request->getGet('status');
        $hasil = $this->request->getGet('hasil_perbaikan');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $builder = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left');
        if ($role === 'ruangan') {
            $builder->where('tiket.ruangan_id', $session->get('ruangan_id'));
        }
        if ($status) {
            $builder->where('tiket.status', $status);
        }
        if ($hasil) {
            $builder->where('tiket.hasil_perbaikan', $hasil);
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('tiket.created_at >=', $tanggal_mulai.' 00:00:00');
            $builder->where('tiket.created_at <=', $tanggal_akhir.' 23:59:59');
        }
        $tiket = $builder->orderBy('tiket.created_at', 'DESC')->findAll();
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
        $sheet->setCellValue('H1', 'Tanggal');
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
        $status = $this->request->getGet('status');
        $hasil = $this->request->getGet('hasil_perbaikan');
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $builder = $tiketModel->select('tiket.*, ruangan.nama_ruangan, barang.nama_barang')
            ->join('ruangan', 'ruangan.id = tiket.ruangan_id', 'left')
            ->join('barang', 'barang.id = tiket.barang_id', 'left');
        if ($role === 'ruangan') {
            $builder->where('tiket.ruangan_id', $session->get('ruangan_id'));
        }
        if ($status) {
            $builder->where('tiket.status', $status);
        }
        if ($hasil) {
            $builder->where('tiket.hasil_perbaikan', $hasil);
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $builder->where('tiket.created_at >=', $tanggal_mulai.' 00:00:00');
            $builder->where('tiket.created_at <=', $tanggal_akhir.' 23:59:59');
        }
        $tiket = $builder->orderBy('tiket.created_at', 'DESC')->findAll();
        // PDF
        $html = view('dashboard/laporan/pdf', ['tiket' => $tiket]);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_tiket_'.date('Ymd_His').'.pdf', ['Attachment' => true]);
        exit;
    }
} 