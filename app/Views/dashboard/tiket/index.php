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
            <h3 class="mb-0">Daftar Tiket</h3>
            <?php if ($role === 'ruangan' || $role === 'admin' || $role === 'it'): ?>
              <a href="#" class="btn btn-primary btn-tambah-tiket">Buat Tiket</a>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <form class="form-inline mb-3" method="get" action="<?= base_url('tiket') ?>">
              <div class="form-group mr-2">
                <label for="tanggal_mulai" class="mr-2">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= esc($tanggal_mulai) ?>">
              </div>
              <div class="form-group mr-2">
                <label for="tanggal_akhir" class="mr-2">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= esc($tanggal_akhir) ?>">
              </div>
              <button type="submit" class="btn btn-primary mr-2">Filter</button>
              <a href="<?= base_url('tiket/exportExcel').'?tanggal_mulai='.(esc($tanggal_mulai)).'&tanggal_akhir='.(esc($tanggal_akhir)) ?>" class="btn btn-success mr-2">Export Excel</a>
              <a href="<?= base_url('tiket/exportPdf').'?tanggal_mulai='.(esc($tanggal_mulai)).'&tanggal_akhir='.(esc($tanggal_akhir)) ?>" class="btn btn-danger" target="_blank">Export PDF</a>
            </form>
            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-tiket">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Nomor Tiket</th>
                    <th>Ruangan</th>
                    <th>Barang</th>
                    <th>Deskripsi Kerusakan</th>
                    <th>Status</th>
                    <th>Hasil</th>
                    <th>Aksi</th>
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
                        <td>
                          <a href="<?= base_url('tiket/detail/'.$t['id']) ?>" class="btn btn-info btn-sm">Detail</a>
                          <?php if ($role === 'it' || $role === 'admin'): ?>
                            <a href="#" class="btn btn-warning btn-sm btn-edit-tiket" data-id="<?= $t['id'] ?>">Update Status</a>
                          <?php endif; ?>
                          <?php if ((($role === 'admin' || $role === 'it') || ($role === 'ruangan' && $t['ruangan_id'] == session('ruangan_id'))) && $t['status'] === 'Menunggu'): ?>
                            <a href="<?= base_url('tiket/editData/'.$t['id']) ?>" class="btn btn-success btn-sm" target="_blank">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm btn-hapus-tiket" data-url="<?= base_url('tiket/delete/'.$t['id']) ?>">Hapus</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="8" class="text-center">Tidak ada data tiket.</td></tr>
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


<!-- Modal Tambah Tiket -->
<div class="modal fade" id="modalTambahTiket" tabindex="-1" role="dialog" aria-labelledby="modalTambahTiketLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('tiket/store') ?>" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahTiketLabel">Buat Tiket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
            <label>Barang</label>
            <select name="barang_id" class="form-control" required>
              <option value="">Pilih Barang</option>
              <?php foreach ($barang as $b): ?>
                <option value="<?= $b['id'] ?>"><?= esc($b['nama_barang']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Deskripsi Kerusakan</label>
            <textarea name="deskripsi_kerusakan" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Foto Kerusakan</label>
            <select id="pilih_foto_kerusakan" class="form-control mb-2">
              <option value="upload">Upload dari Komputer</option>
              <option value="kamera">Ambil dari Kamera</option>
            </select>
            <div id="dropzone-foto-kerusakan" class="dropzone-artikel" style="border:2px dashed #ccc;padding:20px;text-align:center;cursor:pointer;display:block;">
              <span id="dropzone-text-foto">Seret gambar ke sini atau klik untuk memilih file</span>
              <input type="file" name="foto_kerusakan" id="foto_kerusakan" class="form-control-file" accept="image/*" style="display:none;">
              <div id="preview-foto-kerusakan" style="margin-top:10px;"></div>
            </div>
            <div id="kamera_container" style="display:none;">
              <video id="video_kerusakan" width="320" height="240" autoplay style="border:1px solid #ccc;"></video>
              <button type="button" class="btn btn-sm btn-primary mt-2" id="ambil_foto_kerusakan">Ambil Foto</button>
              <canvas id="canvas_kerusakan" width="320" height="240" style="display:none;"></canvas>
              <img id="preview_foto_kerusakan_camera" src="#" alt="Preview Foto" style="display:none;max-width:200px;max-height:200px;margin-top:10px;"/>
              <input type="hidden" name="foto_kerusakan_camera" id="foto_kerusakan_camera">
            </div>
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

<!-- Modal Edit Tiket (Update Status/Perbaikan) -->
<div class="modal fade" id="modalEditTiket" tabindex="-1" role="dialog" aria-labelledby="modalEditTiketLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" id="formEditTiket" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditTiketLabel">Update Status Tiket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>Status</label>
            <select name="status" id="edit_status" class="form-control" required>
              <option value="Menunggu">Menunggu</option>
              <option value="Diproses">Diproses</option>
              <option value="Selesai">Selesai</option>
            </select>
          </div>
          <div class="form-group">
            <label>Hasil Pemeriksaan</label>
            <select name="hasil_perbaikan" id="edit_hasil_perbaikan" class="form-control">
              <option value="">-</option>
              <option value="Diperbaiki">Diperbaiki</option>
              <option value="Service Center">Service Center</option>
              <option value="Rusak Total">Rusak Total</option>
            </select>
          </div>
          <div class="form-group">
            <label>Deskripsi Perbaikan</label>
            <textarea name="deskripsi_perbaikan" id="edit_deskripsi_perbaikan" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>Foto Perbaikan</label>
            <select id="pilih_foto_perbaikan" class="form-control mb-2">
              <option value="upload">Upload dari Komputer</option>
              <option value="kamera">Ambil dari Kamera</option>
            </select>
            <div id="dropzone-foto-perbaikan" class="dropzone-artikel" style="border:2px dashed #ccc;padding:20px;text-align:center;cursor:pointer;display:block;">
              <span id="dropzone-text-foto-perbaikan">Seret gambar ke sini atau klik untuk memilih file</span>
              <input type="file" name="foto_perbaikan" id="foto_perbaikan" class="form-control-file" accept="image/*" style="display:none;">
              <div id="preview-foto-perbaikan" style="margin-top:10px;"></div>
            </div>
            <div id="kamera_container_perbaikan" style="display:none;">
              <video id="video_perbaikan" width="320" height="240" autoplay style="border:1px solid #ccc;"></video>
              <button type="button" class="btn btn-sm btn-primary mt-2" id="ambil_foto_perbaikan">Ambil Foto</button>
              <canvas id="canvas_perbaikan" width="320" height="240" style="display:none;"></canvas>
              <img id="preview_foto_perbaikan_camera" src="#" alt="Preview Foto" style="display:none;max-width:200px;max-height:200px;margin-top:10px;"/>
              <input type="hidden" name="foto_perbaikan_camera" id="foto_perbaikan_camera">
            </div>
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
// Tampilkan modal tambah tiket
$(document).on('click', '.btn-tambah-tiket', function() {
  $('#modalTambahTiket').modal('show');
});
// Tampilkan modal edit tiket dan isi data
$(document).on('click', '.btn-edit-tiket', function() {
  var id = $(this).data('id');
  $.get('<?= base_url('tiket/edit') ?>/' + id, function(data) {
    $('#edit_id').val(data.id);
    $('#edit_status').val(data.status);
    $('#edit_hasil_perbaikan').val(data.hasil_perbaikan);
    $('#edit_deskripsi_perbaikan').val(data.deskripsi_perbaikan);
    $('#formEditTiket').attr('action', '<?= base_url('tiket/update') ?>/' + data.id);
    $('#modalEditTiket').modal('show');
  });
});
// Dropzone logic
var dropzone = $('#dropzone-foto-kerusakan');
var input = $('#foto_kerusakan');
var preview = $('#preview-foto-kerusakan');
var dropText = $('#dropzone-text-foto');
// Klik area dropzone = klik input file
dropzone.on('click', function(e){
  if(e.target.id !== 'foto_kerusakan') input.trigger('click');
});
// Drag over
dropzone.on('dragover', function(e){
  e.preventDefault();
  e.stopPropagation();
  dropzone.css('background','#f0f8ff');
});
dropzone.on('dragleave', function(e){
  e.preventDefault();
  e.stopPropagation();
  dropzone.css('background','');
});
// Drop file
dropzone.on('drop', function(e){
  e.preventDefault();
  e.stopPropagation();
  dropzone.css('background','');
  var files = e.originalEvent.dataTransfer.files;
  if(files.length > 0){
    input[0].files = files;
    showPreviewFotoKerusakan(files[0]);
  }
});
// Change input file
input.on('change', function(){
  if(this.files && this.files[0]){
    showPreviewFotoKerusakan(this.files[0]);
  }
});
function showPreviewFotoKerusakan(file){
  if(!file.type.match('image.*')){
    preview.html('<span class="text-danger">File bukan gambar!</span>');
    return;
  }
  var reader = new FileReader();
  reader.onload = function(e){
    preview.html('<img src="'+e.target.result+'" alt="Preview" width="120">');
  }
  reader.readAsDataURL(file);
}
// Integrasi dengan dropdown kamera/upload
$('#pilih_foto_kerusakan').on('change', function() {
  if ($(this).val() === 'kamera') {
    $('#dropzone-foto-kerusakan').hide();
    $('#kamera_container').show();
    // Start webcam
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        $('#video_kerusakan')[0].srcObject = stream;
        $('#video_kerusakan')[0].play();
      });
    }
  } else {
    $('#dropzone-foto-kerusakan').show();
    $('#kamera_container').hide();
    // Stop webcam
    let video = $('#video_kerusakan')[0];
    if (video && video.srcObject) {
      let tracks = video.srcObject.getTracks();
      tracks.forEach(track => track.stop());
      video.srcObject = null;
    }
    $('#preview_foto_kerusakan_camera').hide();
    $('#canvas_kerusakan').hide();
    $('#foto_kerusakan_camera').val('');
  }
});
// Ambil foto dari kamera
$('#ambil_foto_kerusakan').on('click', function() {
  let video = $('#video_kerusakan')[0];
  let canvas = $('#canvas_kerusakan')[0];
  let context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  let dataURL = canvas.toDataURL('image/png');
  $('#preview_foto_kerusakan_camera').attr('src', dataURL).show();
  $('#canvas_kerusakan').hide();
  $('#foto_kerusakan_camera').val(dataURL);
});
// Saat submit form, jika pakai kamera, pastikan sudah ambil foto
$('form[action$="tiket/store"]').on('submit', function(e) {
  if ($('#pilih_foto_kerusakan').val() === 'kamera' && !$('#foto_kerusakan_camera').val()) {
    e.preventDefault();
    Swal.fire({icon:'error',title:'Gagal',text:'Ambil foto dari kamera dulu!'});
    return false;
  }
});
// Dropzone logic untuk foto perbaikan
var dropzonePerbaikan = $('#dropzone-foto-perbaikan');
var inputPerbaikan = $('#foto_perbaikan');
var previewPerbaikan = $('#preview-foto-perbaikan');
var dropTextPerbaikan = $('#dropzone-text-foto-perbaikan');
dropzonePerbaikan.on('click', function(e){
  if(e.target.id !== 'foto_perbaikan') inputPerbaikan.trigger('click');
});
dropzonePerbaikan.on('dragover', function(e){
  e.preventDefault();
  e.stopPropagation();
  dropzonePerbaikan.css('background','#f0f8ff');
});
dropzonePerbaikan.on('dragleave', function(e){
  e.preventDefault();
  e.stopPropagation();
  dropzonePerbaikan.css('background','');
});
dropzonePerbaikan.on('drop', function(e){
  e.preventDefault();
  e.stopPropagation();
  dropzonePerbaikan.css('background','');
  var files = e.originalEvent.dataTransfer.files;
  if(files.length > 0){
    inputPerbaikan[0].files = files;
    showPreviewFotoPerbaikan(files[0]);
  }
});
inputPerbaikan.on('change', function(){
  if(this.files && this.files[0]){
    showPreviewFotoPerbaikan(this.files[0]);
  }
});
function showPreviewFotoPerbaikan(file){
  if(!file.type.match('image.*')){
    previewPerbaikan.html('<span class="text-danger">File bukan gambar!</span>');
    return;
  }
  var reader = new FileReader();
  reader.onload = function(e){
    previewPerbaikan.html('<img src="'+e.target.result+'" alt="Preview" width="120">');
  }
  reader.readAsDataURL(file);
}
$('#pilih_foto_perbaikan').on('change', function() {
  if ($(this).val() === 'kamera') {
    $('#dropzone-foto-perbaikan').hide();
    $('#kamera_container_perbaikan').show();
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        $('#video_perbaikan')[0].srcObject = stream;
        $('#video_perbaikan')[0].play();
      });
    }
  } else {
    $('#dropzone-foto-perbaikan').show();
    $('#kamera_container_perbaikan').hide();
    let video = $('#video_perbaikan')[0];
    if (video && video.srcObject) {
      let tracks = video.srcObject.getTracks();
      tracks.forEach(track => track.stop());
      video.srcObject = null;
    }
    $('#preview_foto_perbaikan_camera').hide();
    $('#canvas_perbaikan').hide();
    $('#foto_perbaikan_camera').val('');
  }
});
$('#ambil_foto_perbaikan').on('click', function() {
  let video = $('#video_perbaikan')[0];
  let canvas = $('#canvas_perbaikan')[0];
  let context = canvas.getContext('2d');
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  let dataURL = canvas.toDataURL('image/png');
  $('#preview_foto_perbaikan_camera').attr('src', dataURL).show();
  $('#canvas_perbaikan').hide();
  $('#foto_perbaikan_camera').val(dataURL);
});
$('form#formEditTiket').on('submit', function(e) {
  if ($('#pilih_foto_perbaikan').val() === 'kamera' && !$('#foto_perbaikan_camera').val()) {
    e.preventDefault();
    Swal.fire({icon:'error',title:'Gagal',text:'Ambil foto dari kamera dulu!'});
    return false;
  }
});
$(document).ready(function() {
  $('#tabel-tiket').DataTable({
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
// Tambahkan JS konfirmasi hapus tiket
$(document).on('click', '.btn-hapus-tiket', function(e) {
  e.preventDefault();
  var url = $(this).data('url');
  Swal.fire({
    title: 'Yakin hapus tiket ini?',
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
// Update barang saat ruangan dipilih (modal tambah tiket)
$('#modalTambahTiket').on('change', 'select[name=ruangan_id]', function() {
  var ruanganId = $(this).val();
  var barangSelect = $('#modalTambahTiket select[name=barang_id]');
  barangSelect.html('<option value="">Memuat...</option>');
  if(ruanganId) {
    $.get('<?= base_url('tiket/getBarangByRuangan') ?>/' + ruanganId, function(data) {
      var html = '<option value="">Pilih Barang</option>';
      if(data.length > 0) {
        data.forEach(function(b) {
          html += '<option value="'+b.id+'">'+b.nama_barang+'</option>';
        });
      }
      barangSelect.html(html);
    });
  } else {
    barangSelect.html('<option value="">Pilih Barang</option>');
  }
});
</script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.css') ?>">
<!-- DataTables JS -->
<script src="<?= base_url('argon/assets/js/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') ?>"></script>