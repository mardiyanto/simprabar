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
              <a href="#" class="btn btn-primary btn-tambah-user">Tambah User</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered align-items-center table-flush">
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
                            <a href="#" class="btn btn-sm btn-warning btn-edit-user" data-id="<?= $user['id'] ?>">Edit</a>
                            <a href="<?= base_url('dashboard/user/delete') ?>/<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('dashboard/user/store') ?>">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
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
              <option value="ruangan">Ruangan</option>
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

<script>
// Tampilkan modal tambah user
$(document).on('click', '.btn-tambah-user', function() {
  $('#modalTambahUser').modal('show');
});
// Tampilkan modal edit user dan isi data
$(document).on('click', '.btn-edit-user', function() {
  var id = $(this).data('id');
  $.get('<?= base_url('dashboard/user/edit') ?>/' + id, function(data) {
    $('#edit_id').val(data.id);
    $('#edit_username').val(data.username);
    $('#edit_nama').val(data.nama);
    $('#edit_role').val(data.role);
    $('#formEditUser').attr('action', '<?= base_url('dashboard/user/update') ?>/' + data.id);
    $('#modalEditUser').modal('show');
  });
});
</script>