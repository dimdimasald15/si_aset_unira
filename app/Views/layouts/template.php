<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Manajemen Aset UNIRA MALANG">
  <meta name="author" content="DimasAldiSallam">
  <title><?= $title; ?> | SI-ASET UNIRA MALANG</title>

  <!--  Social tags      -->
  <meta name="keywords" content="sistem informasi, manajemen aset, labelling assets, qr code, perguruan tinggi, UNIRA, malang, universitas">
  <meta name="description" content="Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Tracer Study">
  <meta itemprop="description" content="Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang">
  <meta itemprop="image" content="<?= base_url('assets/images/unira.png') ?>">
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/images/logo/logounira.jpg') ?>" type="image/png">

  <link rel="preconnect" href="https://fonts.gstatic.com">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css">
  <?= $this->renderSection('styles') ?>
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/iconly/bold.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.css">
  <!-- sweetalert2 -->
  <link href="<?= base_url() ?>/assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

  <!-- fontawesome -->
  <link href="<?= base_url() ?>/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="<?= base_url() ?>/assets/vendors/jquery/jquery.min.js"></script>
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!-- <script src="https://unpkg.com/feather-icons"></script> -->

</head>

<body>
  <div id="app">
    <?= $this->include('layouts/sidebar') ?>
    <div id="main" class='layout-navbar'>
      <header class='mb-3'>
        <nav class="navbar navbar-expand navbar-light ">
          <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
              <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown me-1">
                  <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                      <h6 class="dropdown-header">Mail</h6>
                    </li>
                    <li><a class="dropdown-item" href="#">No new mail</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown me-3">
                  <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                      <h6 class="dropdown-header">Notifications</h6>
                    </li>
                    <li><a class="dropdown-item">No notification available</a></li>
                  </ul>
                </li>
              </ul>
              <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <div class="user-menu d-flex">
                    <div class="user-name text-end me-3">
                      <h6 class="mb-0 text-gray-600"><?= $_SESSION['username'] ?></h6>
                      <p class="mb-0 text-sm text-gray-600"><?= $_SESSION['role'] ?></p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                      <div class="avatar avatar-md">
                        <img src="<?= base_url() ?>/assets/images/faces/2.jpg">
                      </div>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li>
                    <h6 class="dropdown-header">Hello, <?= $_SESSION['username'] ?></h6>
                  </li>
                  <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                      Profile</a></li>
                  <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                      Settings</a></li>
                  <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-wallet me-2"></i>
                      Wallet</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </header>
      <div id="main-content">
        <?= $this->renderSection('content') ?>

        <?= $this->include('layouts/footer') ?>
      </div>
    </div>
  </div>
  <!-- Core -->
  <script src="<?= base_url() ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/main.js"></script>

  <!-- Optional Js -->
  <script src="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendors/DataTables/DataTables-1.13.3/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
  <?= $this->renderSection('javascript') ?>
  <!-- <script>
    feather.replace()
  </script> -->
</body>

</html>