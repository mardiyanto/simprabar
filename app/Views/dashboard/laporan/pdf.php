<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Tiket</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px 4px; text-align: left; }
        th { background: #eee; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Tiket</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Tiket</th>
                <th>Ruangan</th>
                <th>Barang</th>
                <th>Deskripsi Kerusakan</th>
                <th>Status</th>
                <th>Hasil</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tiket)): ?>
                <?php $no = 1; foreach ($tiket as $t): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($t['nomor_tiket']) ?></td>
                        <td><?= esc($t['nama_ruangan']) ?></td>
                        <td><?= esc($t['nama_barang']) ?></td>
                        <td><?= esc($t['deskripsi_kerusakan']) ?></td>
                        <td><?= esc($t['status']) ?></td>
                        <td><?= esc($t['hasil_perbaikan']) ?></td>
                        <td><?= esc($t['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">Tidak ada data tiket.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html> 