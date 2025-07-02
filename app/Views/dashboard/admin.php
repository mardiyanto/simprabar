<?= $this->include('dashboard/headeradmin') ?>
  <div class="main-content">
    <!-- Navbar -->
   <?= $this->include('dashboard/menuatasadmin') ?>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah User</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_user ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Ruangan</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_ruangan ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-door-open"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Barang</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_barang ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-box"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Card status tiket -->
          <div class="row mt-4">
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Tiket Menunggu</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_menunggu ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                        <i class="fas fa-hourglass-half"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Tiket Diproses</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_diproses ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <i class="fas fa-sync-alt"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Tiket Selesai</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_selesai ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-check"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Card hasil perbaikan -->
          <div class="row mt-4">
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Diperbaiki</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_diperbaiki ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-tools"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Service Center</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_service ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-truck"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Rusak Total</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_rusak ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-times-circle"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Grafik Tiket per Bulan -->
          
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
          <div class="card bg-gradient-default shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                  <h2 class="text-white mb-0">Grafik Tiket per Bulan</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-orders" class="chart-canvas"></canvas>
              </div>
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
<script>
$(function() {
  if (window.Chart && $('#chart-orders').length) {
    var chart = $('#chart-orders').data('chart');
    if (chart) {
      chart.data.labels = <?= $grafik_labels ?>;
      chart.data.datasets[0].data = <?= $grafik_data ?>;
      chart.data.datasets[0].label = 'Jumlah Tiket';
      chart.update();
    } else {
      var ctx = document.getElementById('chart-orders').getContext('2d');
      var ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?= $grafik_labels ?>,
          datasets: [{
            label: 'Jumlah Tiket',
            data: <?= $grafik_data ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [{
              gridLines: { lineWidth: 1, color: '#dfe2e6', zeroLineColor: '#dfe2e6' },
              ticks: { callback: function(value) { if (!(value % 10)) { return value } } }
            }]
          },
          tooltips: {
            callbacks: {
              label: function(item, data) {
                var label = data.datasets[item.datasetIndex].label || '';
                var yLabel = item.yLabel;
                var content = '';
                if (data.datasets.length > 1) {
                  content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                }
                content += '<span class="popover-body-value">' + yLabel + '</span>';
                return content;
              }
            }
          }
        }
      });
      $('#chart-orders').data('chart', ordersChart);
    }
  }
});
</script>