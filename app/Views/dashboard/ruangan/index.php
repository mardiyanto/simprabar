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
            <h3 class="mb-0">Daftar Ruangan</h3>
            <?php if (session('role') === 'admin'): ?>
              <a href="#" class="btn btn-primary btn-tambah-ruangan">Tambah Ruangan</a>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-ruangan">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Nama Ruangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($ruangan)): ?>
                    <?php $no = 1; foreach ($ruangan as $r): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($r['nama_ruangan']) ?></td>
                        <td>
                          <?php if (session('role') === 'admin'): ?>
                            <a href="#" class="btn btn-sm btn-warning btn-edit-ruangan" data-id="<?= $r['id'] ?>">Edit</a>
                            <a href="<?= base_url('ruangan/delete') ?>/<?= $r['id'] ?>" class="btn btn-sm btn-danger btn-hapus-ruangan">Hapus</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="3" class="text-center">Tidak ada data ruangan.</td></tr>
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Notifikasi SweetAlert2 dari flashdata
<?php if (session()->getFlashdata('success')): ?>
Swal.fire({
  icon: 'success',
  title: 'Sukses',
  text: '<?= session('success') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
Swal.fire({
  icon: 'error',
  title: 'Gagal',
  text: '<?= session('error') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
// Tampilkan modal tambah ruangan
$(document).on('click', '.btn-tambah-ruangan', function() {
  $('#modalTambahRuangan').modal('show');
});
// Tampilkan modal edit ruangan dan isi data
$(document).on('click', '.btn-edit-ruangan', function() {
  var id = $(this).data('id');
  $.get('<?= base_url('ruangan/edit') ?>/' + id, function(data) {
    $('#edit_id').val(data.id);
    $('#edit_nama_ruangan').val(data.nama_ruangan);
    $('#formEditRuangan').attr('action', '<?= base_url('ruangan/update') ?>/' + data.id);
    $('#modalEditRuangan').modal('show');
  });
});
// SweetAlert2 konfirmasi hapus ruangan
$(document).on('click', '.btn-hapus-ruangan', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Yakin hapus ruangan ini?',
    text: 'Aksi ini tidak bisa dibatalkan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
});
</script>

<!-- Modal Tambah Ruangan -->
<div class="modal fade" id="modalTambahRuangan" tabindex="-1" role="dialog" aria-labelledby="modalTambahRuanganLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('ruangan/store') ?>">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahRuanganLabel">Tambah Ruangan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Ruangan</label>
            <input type="text" name="nama_ruangan" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Ruangan -->
<div class="modal fade" id="modalEditRuangan" tabindex="-1" role="dialog" aria-labelledby="modalEditRuanganLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" id="formEditRuangan">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditRuanganLabel">Edit Ruangan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>Nama Ruangan</label>
            <input type="text" name="nama_ruangan" id="edit_nama_ruangan" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.css') ?>">
<!-- DataTables JS -->
<script src="<?= base_url('argon/assets/js/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script>
$(document).ready(function() {
  $('#tabel-ruangan').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
    },
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    ordering: true,
    searching: true,
    stateSave: true, // Menyimpan kondisi filter/sort/pagination
    responsive: true,
    autoWidth: false,
    scrollX: true,
    scrollY: 300,
    scrollCollapse: true,
    paging: true,
    info: true,
    language: {
      paginate: {
        previous: "<i class='fas fa-angle-left'></i>",
        next: "<i class='fas fa-angle-right'></i>"
      }
    }
  });
});
</script> 