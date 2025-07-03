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
        <div class="card shadow">
          <div class="card-header border-0">
            <h3 class="mb-0">Edit Data Tiket</h3>
          </div>
          <div class="card-body">
            <form method="post" action="<?= base_url('tiket/updateData/'.$tiket['id']) ?>">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Ruangan</label>
                <select name="ruangan_id" class="form-control" required <?= ($role==='ruangan')?'readonly disabled':'' ?>>
                  <?php foreach ($ruangan as $r): ?>
                    <option value="<?= $r['id'] ?>" <?= $tiket['ruangan_id']==$r['id']?'selected':'' ?>><?= esc($r['nama_ruangan']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Barang</label>
                <select name="barang_id" class="form-control" required>
                  <?php foreach ($barang as $b): ?>
                    <option value="<?= $b['id'] ?>" <?= $tiket['barang_id']==$b['id']?'selected':'' ?>><?= esc($b['nama_barang']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Deskripsi Kerusakan</label>
                <textarea name="deskripsi_kerusakan" class="form-control" required><?= esc($tiket['deskripsi_kerusakan']) ?></textarea>
              </div>
              <div class="text-right">
                <a href="<?= base_url('tiket') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?= $this->include('dashboard/footeradmin') ?>
  </div>
</div>
<?= $this->include('dashboard/jsadmin') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

// Update barang saat ruangan dipilih (form edit)
$('select[name=ruangan_id]').on('change', function() {
  var ruanganId = $(this).val();
  var barangSelect = $('select[name=barang_id]');
  barangSelect.html('<option value="">Memuat...</option>');
  if(ruanganId) {
    $.get('<?= base_url('tiket/getBarangByRuangan') ?>/' + ruanganId, function(data) {
      var html = '<option value="">Pilih Barang</option>';
      if(data.length > 0) {
        data.forEach(function(b) {
          var selected = (b.id == '<?= $tiket['barang_id'] ?>') ? 'selected' : '';
          html += '<option value="'+b.id+'" '+selected+'>'+b.nama_barang+'</option>';
        });
      }
      barangSelect.html(html);
    });
  } else {
    barangSelect.html('<option value="">Pilih Barang</option>');
  }
});
</script> 