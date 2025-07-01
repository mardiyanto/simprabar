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
            <h3 class="mb-0">Daftar Barang</h3>
            <?php if (session('role') === 'admin'): ?>
              <a href="#" class="btn btn-primary btn-tambah-barang">Tambah Barang</a>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($barang)): ?>
                    <?php $no = 1; foreach ($barang as $b): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($b['nama_barang']) ?></td>
                        <td><?= esc($b['nama_ruangan']) ?></td>
                        <td>
                          <?php if (session('role') === 'admin'): ?>
                            <a href="#" class="btn btn-sm btn-warning btn-edit-barang" data-id="<?= $b['id'] ?>">Edit</a>
                            <a href="<?= base_url('barang/delete') ?>/<?= $b['id'] ?>" class="btn btn-sm btn-danger btn-hapus-barang">Hapus</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="4" class="text-center">Tidak ada data barang.</td></tr>
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
// Tampilkan modal tambah barang
$(document).on('click', '.btn-tambah-barang', function() {
  $('#modalTambahBarang').modal('show');
});
// Tampilkan modal edit barang dan isi data
$(document).on('click', '.btn-edit-barang', function() {
  var id = $(this).data('id');
  $.get('<?= base_url('barang/edit') ?>/' + id, function(data) {
    $('#edit_id').val(data.id);
    $('#edit_nama_barang').val(data.nama_barang);
    $('#edit_ruangan_id').val(data.ruangan_id);
    $('#edit_deskripsi_barang').val(data.deskripsi_barang);
    $('#formEditBarang').attr('action', '<?= base_url('barang/update') ?>/' + data.id);
    $('#modalEditBarang').modal('show');
  });
});
// SweetAlert2 konfirmasi hapus barang
$(document).on('click', '.btn-hapus-barang', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Yakin hapus barang ini?',
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

<!-- Modal Tambah Barang -->
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="modalTambahBarangLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('barang/store') ?>">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
          </div>
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
            <label>Deskripsi Barang</label>
            <textarea name="deskripsi_barang" class="form-control" required></textarea>
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

<!-- Modal Edit Barang -->
<div class="modal fade" id="modalEditBarang" tabindex="-1" role="dialog" aria-labelledby="modalEditBarangLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" id="formEditBarang">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditBarangLabel">Edit Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" id="edit_nama_barang" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Ruangan</label>
            <select name="ruangan_id" id="edit_ruangan_id" class="form-control" required>
              <option value="">Pilih Ruangan</option>
              <?php foreach ($ruangan as $r): ?>
                <option value="<?= $r['id'] ?>"><?= esc($r['nama_ruangan']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Deskripsi Barang</label>
            <textarea name="deskripsi_barang" id="edit_deskripsi_barang" class="form-control" required></textarea>
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