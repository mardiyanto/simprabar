<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Argon Dashboard - Free Dashboard for Bootstrap 4 by Creative Tim
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?= base_url('argon/assets/js/plugins/nucleo/css/nucleo.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('argon/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?= base_url('argon/assets/css/argon-dashboard.css?v=1.1.2') ?>" rel="stylesheet" />
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="<?= base_url('dashboard/admin') ?>">
        <img src="<?= base_url('argon/assets/img/brand/blue.png') ?>" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="<?= base_url('argon/assets/img/theme/team-1-800x800.jpg') ?>">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <!-- <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Activity</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a> -->
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('login/logout') ?>" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="<?= base_url('dashboard/admin') ?>">
                <img src="<?= base_url('argon/assets/img/brand/blue.png') ?>">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item <?= (current_url() == base_url('dashboard/admin')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('dashboard/admin')) ? 'active' : '' ?>" href="<?= base_url('dashboard/admin') ?>">
              <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <?php if (session('role') === 'admin'): ?>
          <li class="nav-item <?= (current_url() == base_url('ruangan')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('ruangan')) ? 'active' : '' ?>" href="<?= base_url('ruangan') ?>">
              <i class="ni ni-planet text-blue"></i> Ruangan
            </a>
          </li>
          <li class="nav-item <?= (current_url() == base_url('barang')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('barang')) ? 'active' : '' ?>" href="<?= base_url('barang') ?>">
              <i class="ni ni-pin-3 text-orange"></i> Barang
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item <?= (current_url() == base_url('tiket')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('tiket')) ? 'active' : '' ?>" href="<?= base_url('tiket') ?>">
              <i class="ni ni-key-25 text-info ni"></i> Tiket
            </a>
          </li>
          <?php if (session('role') === 'admin'): ?>
          <li class="nav-item <?= (current_url() == base_url('laporan')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('laporan')) ? 'active' : '' ?>" href="<?= base_url('laporan') ?>">
              <i class="fas fa-box"></i> Laporan
            </a>
          </li>
          <li class="nav-item <?= (current_url() == base_url('user')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('user')) ? 'active' : '' ?>" href="<?= base_url('user') ?>">
              <i class="ni ni-single-02 text-yellow"></i> User
            </a>
          </li>
          <?php endif; ?>
        </ul>
        <!-- Divider -->
       
      </div>
    </div>
  </nav>
  