<?= $this->include('dashboard/headeradmin') ?>
<div class="main-content">
  <?= $this->include('dashboard/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8 d-flex align-items-center" style="min-height: 300px; background-image: url('<?= base_url('argon/assets/img/theme/profile-cover.jpg') ?>'); background-size: cover; background-position: center top;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid d-flex align-items-center">
      <div class="row">
        <div class="col-lg-7 col-md-10">
          <h1 class="display-2 text-white">Halo, <?= esc($user['nama']) ?></h1>
          <p class="text-white mt-0 mb-5">Ini adalah halaman profil Anda. Silakan edit data jika perlu.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <div class="row">
      <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
        <div class="card card-profile shadow">
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <img src="<?= base_url('argon/assets/img/theme/team-4-800x800.jpg') ?>" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
              </div>
            </div>
          </div>
          <div class="card-body pt-0 pt-md-4">
            <div class="text-center mt-5">
              <h3><?= esc($user['nama']) ?></h3>
              <div class="h5 font-weight-300">
                <i class="ni ni-single-02 mr-2"></i><?= esc($user['username']) ?>
              </div>
              <div class="h5 mt-4">
                <i class="ni ni-badge mr-2"></i><?= esc($user['role']) ?>
              </div>
              <?php if ($user['role'] == 'ruangan'): ?>
                <div><i class="ni ni-building mr-2"></i>Ruangan ID: <?= esc($user['ruangan_id']) ?></div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-8 order-xl-1">
        <div class="card bg-secondary shadow">
          <div class="card-header bg-white border-0">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">Edit Profil</h3>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form method="post" action="<?= base_url('profile/update') ?>">
              <?= csrf_field() ?>
              <div class="pl-lg-4">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">Username</label>
                      <input type="text" id="input-username" name="username" class="form-control form-control-alternative" value="<?= esc($user['username']) ?>" required>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-nama">Nama</label>
                      <input type="text" id="input-nama" name="nama" class="form-control form-control-alternative" value="<?= esc($user['nama']) ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-password">Password Baru <small>(opsional)</small></label>
                      <input type="password" id="input-password" name="password" class="form-control form-control-alternative" placeholder="Isi jika ingin ganti password">
                      <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="text-right">
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
</script> 