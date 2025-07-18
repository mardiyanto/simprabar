<?= $this->include('dashboard/headeradmin') ?>
  <div class="main-content">
    <!-- Navbar -->
   <?= $this->include('dashboard/menuatasadmin') ?>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Bisa tambahkan info/konten lain di sini jika perlu -->
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0 d-flex justify-content-between align-items-center">
              <h3 class="mb-0">Daftar User</h3>
              <?php if (session('role') === 'admin'): ?>
                <div>
                  <a href="#" class="btn btn-primary btn-tambah-user-adminit mr-2">Tambah User Admin/IT</a>
                  <a href="#" class="btn btn-success btn-tambah-user-ruangan">Tambah User Ruangan</a>
                </div>
              <?php endif; ?>
            </div>
            <ul class="nav nav-tabs mb-3">
              <li class="nav-item">
                <a class="nav-link <?= $roleFilter=='admin'?'active':'' ?>" href="?role=admin">Admin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= $roleFilter=='it'?'active':'' ?>" href="?role=it">IT</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= $roleFilter=='ruangan'?'active':'' ?>" href="?role=ruangan">Ruangan</a>
              </li>
            </ul>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered align-items-center table-flush" id="tabel-user">
                  <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php $no = 1; foreach ($users as $user): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['nama']) ?></td>
                        <td><?= esc($user['role']) ?></td>
                        <td>
                            <?php if (session('role') === 'admin'): ?>
                              <a href="#" class="btn btn-sm btn-warning btn-edit-user" data-id="<?= $user['id'] ?>">Edit</a>
                              <a href="<?= base_url('dashboard/user/delete') ?>/<?= $user['id'] ?>" class="btn btn-sm btn-danger btn-hapus-user">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">Tidak ada data user.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
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

// Tampilkan modal tambah user admin/it
$(document).on('click', '.btn-tambah-user-adminit', function() {
  $('#modalTambahUserAdminIT').modal('show');
});
// Tampilkan modal tambah user ruangan
$(document).on('click', '.btn-tambah-user-ruangan', function() {
  $('#modalTambahUserRuangan').modal('show');
});
// Tampilkan modal edit user dan isi data
$(document).on('click', '.btn-edit-user', function() {
  var id = $(this).data('id');
  $.get('<?= base_url('dashboard/user/edit') ?>/' + id, function(data) {
    $('#edit_id').val(data.id);
    $('#edit_username').val(data.username);
    $('#edit_nama').val(data.nama);
    $('#edit_role').val(data.role).trigger('change');
    if (data.role === 'ruangan') {
      $('#edit_ruangan_id').val(data.ruangan_id);
      $('#form_ruangan_edit').show();
    } else {
      $('#form_ruangan_edit').hide();
    }
    $('#formEditUser').attr('action', '<?= base_url('dashboard/user/update') ?>/' + data.id);
    $('#modalEditUser').modal('show');
  });
});

// SweetAlert2 konfirmasi hapus user
$(document).on('click', '.btn-hapus-user', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Yakin hapus user ini?',
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

// Show/hide select ruangan di edit user
$('#edit_role').on('change', function() {
  if ($(this).val() === 'ruangan') {
    $('#form_ruangan_edit').show();
  } else {
    $('#form_ruangan_edit').hide();
  }
});
</script>

<!-- Modal Tambah User Admin/IT -->
<div class="modal fade" id="modalTambahUserAdminIT" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserAdminITLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('dashboard/user/store') ?>">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahUserAdminITLabel">Tambah User Admin/IT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="">Pilih Role</option>
              <option value="admin">Admin</option>
              <option value="it">IT</option>
            </select>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
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

<!-- Modal Tambah User Ruangan -->
<div class="modal fade" id="modalTambahUserRuangan" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserRuanganLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('dashboard/user/store') ?>">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahUserRuanganLabel">Tambah User Ruangan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <input type="hidden" name="role" value="ruangan">
          <div class="form-group">
            <label>Ruangan</label>
            <select name="ruangan_id" class="form-control" required>
              <option value="">Pilih Ruangan</option>
              <?php foreach ($ruangan as $r): ?>
                <option value="<?= $r['id'] ?>"><?= esc($r['nama_ruangan']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" id="formEditUser">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" id="edit_username" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" id="edit_nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" id="edit_role" class="form-control" required>
              <option value="">Pilih Role</option>
              <option value="admin">Admin</option>
              <option value="ruangan">Ruangan</option>
              <option value="it">IT</option>
            </select>
          </div>
          <div class="form-group" id="form_ruangan_edit" style="display:none;">
            <label>Ruangan</label>
            <select name="ruangan_id" id="edit_ruangan_id" class="form-control">
              <option value="">Pilih Ruangan</option>
              <?php foreach ($ruangan as $r): ?>
                <option value="<?= $r['id'] ?>"><?= esc($r['nama_ruangan']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Password (kosongkan jika tidak ingin ganti)</label>
            <input type="password" name="password" class="form-control">
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
  $('#tabel-user').DataTable({
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