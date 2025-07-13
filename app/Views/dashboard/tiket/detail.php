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
        <div id="print-area">
        <div class="card shadow mb-4">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Detail Tiket</h3>
            <div>
              <button onclick="cetakDetail()" class="btn btn-primary mr-2 no-print">
                <i class="fas fa-print"></i> Cetak
              </button>
              <a href="<?= base_url('tiket') ?>" class="btn btn-secondary no-print">Kembali</a>
            </div>
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
              <tr><th>Durasi Penanganan</th><td><?= esc($tiket['durasi']) ?></td></tr>
            </table>
          </div>
        </div>
        </div>
      </div>
    </div>
    <?= $this->include('dashboard/footeradmin') ?>
  </div>
</div>
<?= $this->include('dashboard/jsadmin') ?>
<style>
@media print {
  body * { visibility: hidden !important; }
  #print-area, #print-area * { visibility: visible !important; }
  #print-area { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; }
  .no-print { display: none !important; }
  .main-content, .container-fluid, .row, .col-xl-8 { padding: 0 !important; margin: 0 !important; }
  table.table { width: 100% !important; font-size: 12px; }
}
</style>
<script>
function cetakDetail() {
  window.print();
}
</script> 