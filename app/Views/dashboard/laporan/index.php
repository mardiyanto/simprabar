<?= $this->include('dashboard/headeradmin') ?>
<div class="main-content">
  <?= $this->include('dashboard/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body"></div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <div class="row">
      <div class="col-xl-12">
        <div class="card shadow">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Laporan Tiket</h3>
          </div>
          <div class="card-body">
            <form class="form-inline mb-3" method="get" action="<?= base_url('laporan') ?>">
              <div class="form-group mr-2">
                <label for="status" class="mr-2">Status</label>
                <select name="status" id="status" class="form-control">
                  <option value="">Semua</option>
                  <option value="Menunggu" <?= $status=='Menunggu'?'selected':'' ?>>Menunggu</option>
                  <option value="Diproses" <?= $status=='Diproses'?'selected':'' ?>>Diproses</option>
                  <option value="Selesai" <?= $status=='Selesai'?'selected':'' ?>>Selesai</option>
                </select>
              </div>
              <div class="form-group mr-2">
                <label for="hasil_perbaikan" class="mr-2">Hasil</label>
                <select name="hasil_perbaikan" id="hasil_perbaikan" class="form-control">
                  <option value="">Semua</option>
                  <option value="Diperbaiki" <?= $hasil_perbaikan=='Diperbaiki'?'selected':'' ?>>Diperbaiki</option>
                  <option value="Service Center" <?= $hasil_perbaikan=='Service Center'?'selected':'' ?>>Service Center</option>
                  <option value="Rusak Total" <?= $hasil_perbaikan=='Rusak Total'?'selected':'' ?>>Rusak Total</option>
                </select>
              </div>
              <div class="form-group mr-2">
                <label for="tanggal_mulai" class="mr-2">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= esc($tanggal_mulai) ?>">
              </div>
              <div class="form-group mr-2">
                <label for="tanggal_akhir" class="mr-2">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= esc($tanggal_akhir) ?>">
              </div>
              <button type="submit" class="btn btn-primary mr-2">Filter</button>
              <a href="<?= base_url('laporan/exportExcel').'?status='.(esc($status)).'&hasil_perbaikan='.(esc($hasil_perbaikan)).'&tanggal_mulai='.(esc($tanggal_mulai)).'&tanggal_akhir='.(esc($tanggal_akhir)) ?>" class="btn btn-success mr-2">Export Excel</a>
              <a href="<?= base_url('laporan/exportPdf').'?status='.(esc($status)).'&hasil_perbaikan='.(esc($hasil_perbaikan)).'&tanggal_mulai='.(esc($tanggal_mulai)).'&tanggal_akhir='.(esc($tanggal_akhir)) ?>" class="btn btn-danger" target="_blank">Export PDF</a>
            </form>
            <!-- Statistik -->
            <div class="row mb-4">
              <div class="col-md-2">
                <div class="card card-stats mb-2">
                  <div class="card-body p-2 text-center">
                    <div class="icon icon-shape bg-secondary text-white rounded-circle mb-2"><i class="fas fa-hourglass-half"></i></div>
                    <span class="h5">Menunggu</span><br><span class="h2 font-weight-bold mb-0"><?= $stat['menunggu'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card card-stats mb-2">
                  <div class="card-body p-2 text-center">
                    <div class="icon icon-shape bg-primary text-white rounded-circle mb-2"><i class="fas fa-sync-alt"></i></div>
                    <span class="h5">Diproses</span><br><span class="h2 font-weight-bold mb-0"><?= $stat['diproses'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card card-stats mb-2">
                  <div class="card-body p-2 text-center">
                    <div class="icon icon-shape bg-success text-white rounded-circle mb-2"><i class="fas fa-check"></i></div>
                    <span class="h5">Selesai</span><br><span class="h2 font-weight-bold mb-0"><?= $stat['selesai'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card card-stats mb-2">
                  <div class="card-body p-2 text-center">
                    <div class="icon icon-shape bg-info text-white rounded-circle mb-2"><i class="fas fa-tools"></i></div>
                    <span class="h5">Diperbaiki</span><br><span class="h2 font-weight-bold mb-0"><?= $stat['diperbaiki'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card card-stats mb-2">
                  <div class="card-body p-2 text-center">
                    <div class="icon icon-shape bg-warning text-white rounded-circle mb-2"><i class="fas fa-truck"></i></div>
                    <span class="h5">Service Center</span><br><span class="h2 font-weight-bold mb-0"><?= $stat['service'] ?></span>
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="card card-stats mb-2">
                  <div class="card-body p-2 text-center">
                    <div class="icon icon-shape bg-danger text-white rounded-circle mb-2"><i class="fas fa-times-circle"></i></div>
                    <span class="h5">Rusak Total</span><br><span class="h2 font-weight-bold mb-0"><?= $stat['rusak'] ?></span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Tabel tiket -->
            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-laporan">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Nomor Tiket</th>
                    <th>Ruangan</th>
                    <th>Barang</th>
                    <th>Deskripsi Kerusakan</th>
                    <th>Status</th>
                    <th>Hasil</th>
                    <th>Waktu Dibuat</th>
                    <th>Waktu Selesai</th>
                    <th>Durasi Penanganan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($tiket)): ?>
                    <?php $no = 1; foreach ($tiket as $t): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($t['nomor_tiket']) ?></td>
                        <td><?= esc($t['nama_ruangan']) ?></td>
                        <td><?= esc($t['nama_barang']) ?></td>
                        <td><?= esc($t['deskripsi_kerusakan']) ?></td>
                        <td><?= esc($t['status']) ?></td>
                        <td><?= esc($t['hasil_perbaikan']) ?></td>
                        <td><?= esc($t['created_at']) ?></td>
                        <td><?= esc($t['updated_at'] ?: '-') ?></td>
                        <td><?= esc($t['durasi']) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="10" class="text-center">Tidak ada data tiket.</td></tr>
                  <?php endif; ?>
                </tbody>
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
<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.css') ?>">
<!-- DataTables JS -->
<script src="<?= base_url('argon/assets/js/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
$(document).ready(function() {
  $('#tabel-laporan').DataTable({
    stateSave: true,
    responsive: true,
    autoWidth: false,
    scrollX: true,
    scrollY: 300,
    scrollCollapse: true,
    paging: true,
    info: true,
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    ordering: true,
    searching: true,
    language: {
      paginate: {
        previous: "<i class='fas fa-angle-left'></i>",
        next: "<i class='fas fa-angle-right'></i>"
      }
    }
  });
});
</script> 