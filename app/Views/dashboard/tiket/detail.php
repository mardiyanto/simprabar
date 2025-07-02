<?= $this->include('dashboard/headeradmin') ?>
<div class="main-content">
  <?= $this->include('dashboard/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body"></div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <div class="row justify-content-center">
      <div class="col-xl-8">
        <div class="card shadow mb-4">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Detail Tiket</h3>
            <a href="<?= base_url('tiket') ?>" class="btn btn-secondary">Kembali</a>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <tr><th>Nomor Tiket</th><td><?= esc($tiket['nomor_tiket']) ?></td></tr>
              <tr><th>Ruangan</th><td><?= esc($tiket['nama_ruangan']) ?></td></tr>
              <tr><th>Barang</th><td><?= esc($tiket['nama_barang']) ?></td></tr>
              <tr><th>Deskripsi Kerusakan</th><td><?= esc($tiket['deskripsi_kerusakan']) ?></td></tr>
              <tr><th>Foto Kerusakan</th><td><?php if (!empty($tiket['foto_kerusakan'])): ?><img src="<?= base_url('uploads/'.$tiket['foto_kerusakan']) ?>" alt="Foto Kerusakan" style="max-width:200px;max-height:200px;"/><?php else: ?>-<?php endif; ?></td></tr>
              <tr><th>Status</th><td><?= esc($tiket['status']) ?></td></tr>
              <tr><th>Hasil Pemeriksaan</th><td><?= esc($tiket['hasil_perbaikan']) ?></td></tr>
              <tr><th>Deskripsi Perbaikan</th><td><?= esc($tiket['deskripsi_perbaikan']) ?></td></tr>
              <tr><th>Foto Perbaikan</th><td><?php if (!empty($tiket['foto_perbaikan'])): ?><img src="<?= base_url('uploads/'.$tiket['foto_perbaikan']) ?>" alt="Foto Perbaikan" style="max-width:200px;max-height:200px;"/><?php else: ?>-<?php endif; ?></td></tr>
              <tr><th>Tanggal Dibuat</th><td><?= esc($tiket['created_at']) ?></td></tr>
              <tr><th>Terakhir Update</th><td><?= esc($tiket['updated_at']) ?></td></tr>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?= $this->include('dashboard/footeradmin') ?>
  </div>
</div>
<?= $this->include('dashboard/jsadmin') ?> 