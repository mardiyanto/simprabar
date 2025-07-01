<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Permintaan Perbaikan</title>
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?= base_url('argon/assets/css/argon-dashboard.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('argon/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>">
    <link rel="icon" href="<?= base_url('argon/assets/img/brand/favicon.png') ?>">
</head>
<body class="bg-default">
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Selamat Datang!</h1>
                            <p class="text-lead text-light">Silakan login untuk mengakses sistem permintaan perbaikan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <small>Login ke akun Anda</small>
                            </div>
                            <?php if (session('error')): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= session('error') ?>
                                </div>
                            <?php endif; ?>
                            <form role="form" method="post" action="<?= base_url('login/doLogin') ?>">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Username" type="text" name="username" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Password" type="password" name="password" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="#" class="text-light"><small>&copy; <?= date('Y') ?> Permintaan Perbaikan</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Argon JS -->
    <script src="<?= base_url('argon/assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('argon/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('argon/assets/js/argon-dashboard.min.js') ?>"></script>
</body>
</html> 