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
        $userModel = new \App\Models\UserModel();
        $ruanganModel = new \App\Models\RuanganModel();
        $barangModel = new \App\Models\BarangModel();
        $tiketModel = new \App\Models\TiketModel();
        $jumlah_user = $userModel->countAllResults();
        $jumlah_ruangan = $ruanganModel->countAllResults();
        $jumlah_barang = $barangModel->countAllResults();
        // Grafik tiket per bulan
        $grafik = $tiketModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
        $labels = [];
        $data = [];
        foreach ($grafik as $g) {
            $labels[] = $g['bulan'];
            $data[] = $g['jumlah'];
        }
        // Statistik status tiket
        $jumlah_menunggu = $tiketModel->where('status', 'Menunggu')->countAllResults();
        $jumlah_diproses = $tiketModel->where('status', 'Diproses')->countAllResults();
        $jumlah_selesai = $tiketModel->where('status', 'Selesai')->countAllResults();
        // Statistik hasil perbaikan
        $jumlah_diperbaiki = $tiketModel->where('hasil_perbaikan', 'Diperbaiki')->countAllResults();
        $jumlah_service = $tiketModel->where('hasil_perbaikan', 'Service Center')->countAllResults();
        $jumlah_rusak = $tiketModel->where('hasil_perbaikan', 'Rusak Total')->countAllResults();
        return view('dashboard/admin', [
            'jumlah_user' => $jumlah_user,
            'jumlah_ruangan' => $jumlah_ruangan,
            'jumlah_barang' => $jumlah_barang,
            'grafik_labels' => json_encode($labels),
            'grafik_data' => json_encode($data),
            'jumlah_menunggu' => $jumlah_menunggu,
            'jumlah_diproses' => $jumlah_diproses,
            'jumlah_selesai' => $jumlah_selesai,
            'jumlah_diperbaiki' => $jumlah_diperbaiki,
            'jumlah_service' => $jumlah_service,
            'jumlah_rusak' => $jumlah_rusak
        ]);
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
        $ruangan_id = $session->get('ruangan_id');
        $userModel = new \App\Models\UserModel();
        $ruanganModel = new \App\Models\RuanganModel();
        $barangModel = new \App\Models\BarangModel();
        $tiketModel = new \App\Models\TiketModel();
        $jumlah_ruangan = $ruanganModel->countAllResults();
        $nama_ruangan = $ruanganModel->find($ruangan_id)['nama_ruangan'] ?? '-';
        $jumlah_barang = $barangModel->where('ruangan_id', $ruangan_id)->countAllResults();
        $jumlah_tiket = $tiketModel->where('ruangan_id', $ruangan_id)->countAllResults();
        $jumlah_user = $userModel->countAllResults();
        // Grafik tiket per bulan (khusus ruangan ini)
        $grafik = $tiketModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->where('ruangan_id', $ruangan_id)
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
        $labels = [];
        $data = [];
        foreach ($grafik as $g) {
            $labels[] = $g['bulan'];
            $data[] = $g['jumlah'];
        }
         // Statistik status tiket
         $jumlah_menunggu = $tiketModel->where('status', 'Menunggu')->countAllResults();
         $jumlah_diproses = $tiketModel->where('status', 'Diproses')->countAllResults();
         $jumlah_selesai = $tiketModel->where('status', 'Selesai')->countAllResults();
         // Statistik hasil perbaikan
         $jumlah_diperbaiki = $tiketModel->where('hasil_perbaikan', 'Diperbaiki')->countAllResults();
         $jumlah_service = $tiketModel->where('hasil_perbaikan', 'Service Center')->countAllResults();
         $jumlah_rusak = $tiketModel->where('hasil_perbaikan', 'Rusak Total')->countAllResults();
        return view('dashboard/ruangan', [
            'jumlah_user' => $jumlah_user,
            'jumlah_ruangan' => $jumlah_ruangan,
            'jumlah_barang' => $jumlah_barang,
            'grafik_labels' => json_encode($labels),
            'grafik_data' => json_encode($data),
            'jumlah_menunggu' => $jumlah_menunggu,
            'jumlah_diproses' => $jumlah_diproses,
            'jumlah_selesai' => $jumlah_selesai,
            'jumlah_diperbaiki' => $jumlah_diperbaiki,
            'jumlah_service' => $jumlah_service,
            'jumlah_rusak' => $jumlah_rusak
        ]);
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
        $userModel = new \App\Models\UserModel();
        $ruanganModel = new \App\Models\RuanganModel();
        $barangModel = new \App\Models\BarangModel();
        $tiketModel = new \App\Models\TiketModel();
        $jumlah_user = $userModel->countAllResults();
        $jumlah_ruangan = $ruanganModel->countAllResults();
        $jumlah_barang = $barangModel->countAllResults();
        // Grafik tiket per bulan
        $grafik = $tiketModel->select("COUNT(*) as jumlah, DATE_FORMAT(created_at, '%Y-%m') as bulan")
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
        $labels = [];
        $data = [];
        foreach ($grafik as $g) {
            $labels[] = $g['bulan'];
            $data[] = $g['jumlah'];
        }
         // Statistik status tiket
         $jumlah_menunggu = $tiketModel->where('status', 'Menunggu')->countAllResults();
         $jumlah_diproses = $tiketModel->where('status', 'Diproses')->countAllResults();
         $jumlah_selesai = $tiketModel->where('status', 'Selesai')->countAllResults();
         // Statistik hasil perbaikan
         $jumlah_diperbaiki = $tiketModel->where('hasil_perbaikan', 'Diperbaiki')->countAllResults();
         $jumlah_service = $tiketModel->where('hasil_perbaikan', 'Service Center')->countAllResults();
         $jumlah_rusak = $tiketModel->where('hasil_perbaikan', 'Rusak Total')->countAllResults();
        return view('dashboard/it', [
            'jumlah_user' => $jumlah_user,
            'jumlah_ruangan' => $jumlah_ruangan,
            'jumlah_barang' => $jumlah_barang,
            'grafik_labels' => json_encode($labels),
            'grafik_data' => json_encode($data),
            'jumlah_menunggu' => $jumlah_menunggu,
            'jumlah_diproses' => $jumlah_diproses,
            'jumlah_selesai' => $jumlah_selesai,
            'jumlah_diperbaiki' => $jumlah_diperbaiki,
            'jumlah_service' => $jumlah_service,
            'jumlah_rusak' => $jumlah_rusak
        ]);
    }
} 