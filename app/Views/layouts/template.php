<?php
helper('converter_helper');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Manajemen Aset UNIRA MALANG">
  <meta name="author" content="Dimas Aldi Sallam">
  <title><?= $title; ?> | SI-ASET UNIRA MALANG</title>

  <!--  Social tags      -->
  <meta name="keywords" content="sistem informasi, manajemen aset, labelling assets, qr code, perguruan tinggi, UNIRA, malang, universitas">
  <meta name="description" content="Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Sistem Informasi Manajemen Aset">
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
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/custom.css">
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
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css"> -->

  <!-- Cropper.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- HTML2Canvasjs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

  <!-- pdfmake -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha512-a9NgEEK7tsCvABL7KqtUTQjl69z7091EVPpw5KxPlZ93T141ffe1woLtbXTX+r2/8TtTvRX/v4zTL2UlMUPgwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- QrCode.JS -->
  <script src="<?= base_url() ?>/assets/vendors/davidshimjs-qrcodejs/qrcode.min.js"></script>

  <!-- chartjs -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/chartjs/Chart.min.css">
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
                  <div class="col-lg-4 theme-toggle d-flex gap-2 align-items-center me-3" style="margin-top:15px;">
                    <i class="fa fa-sun-o text-secondary fs-5"></i>
                    <div class="form-check form-switch fs-6">
                      <input class="form-check-input me-0" type="checkbox" id="lightSwitch">
                      <label class="form-check-label"></label>
                    </div>
                    <i class="fa fa-moon-o text-secondary fs-5"></i>
                  </div>
                </li>
                <li class="nav-item dropdown me-1">
                  <a class="nav-link active dropdown-toggle count" data-bs-toggle="button" id="pelaporanmasuk" aria-expanded="false">
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" id="showpelaporan" aria-labelledby="pelaporanmasuk"></ul>
                </li>
                <li class=" nav-item dropdown me-3">
                  <a class="nav-link active dropdown-toggle notifpersediaan" id="notifpersediaan" href="#" data-bs-toggle="button" aria-expanded="false">
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" id="shownotif" aria-labelledby="dropdownMenuButton">
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
                      <div class="avatar avatar-md" id="avatar">
                      </div>
                    </div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li>
                    <h6 class="dropdown-header">Hello, <?= $_SESSION['username'] ?></h6>
                  </li>
                  <li><a class="dropdown-item" href="profile"><i class="icon-mid bi bi-person me-2"></i> My
                      Profile</a></li>
                  <!-- <li><a class="dropdown-item" href="settings"><i class="icon-mid bi bi-gear me-2"></i>
                      Settings</a></li> -->
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
  <script src="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>assets/js/main.js"></script>
  <script src="<?= base_url() ?>assets/js/pages/switch.js"></script>

  <!-- Optional Js -->
  <script src="<?= base_url() ?>assets/vendors/DataTables/datatables.min.js"></script>
  <!-- <script src="<?= base_url() ?>/assets/vendors/fontawesome/all.min.js"></script> -->
  <script src="<?= base_url() ?>assets/vendors/DataTables/DataTables-1.13.3/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="<?= base_url() ?>assets/vendors/chartjs/Chart.min.js"></script>

  <script>
    $(document).ready(function() {
      var username = "<?= $_SESSION['username'] ?>"
      $.ajax({
        type: "post",
        url: "<?= base_url('profilecontroller/getfotobyusername') ?>",
        data: {
          username: username,
        },
        dataType: "json",
        success: function(response) {
          $('#avatar').append(`
            ${response.foto?`<img src="<?= base_url(); ?>/uploads/${response.foto}" alt="Profile Picture">` : `<img src="<?= base_url() ?>/uploads/default.jpg">`
              }                
          `);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });

      load_unseen_pelaporan('');
      $('#pelaporanmasuk').on('click', function(e) {
        e.preventDefault();
        $('#showpelaporan').toggleClass('show');
        $('#shownotif').removeClass('show');
        load_unseen_pelaporan('view');
      });

      setInterval(function() {
        load_unseen_pelaporan('');
      }, 5000);

      load_unseen_notifpersediaan();
      $('#notifpersediaan').on('click', function(e) {
        e.preventDefault();
        $('#shownotif').toggleClass('show');
        $('#showpelaporan').removeClass('show');
        load_unseen_notifpersediaan();
      });

    });

    function load_unseen_notifpersediaan() {
      $.ajax({
        url: "<?= base_url('barangcontroller/notifikasi_persediaan') ?>",
        method: "POST",
        dataType: "json",
        success: function(data) {
          $('#shownotif').html(data.notification);
          $('#shownotif').append(`
          <hr class="dropdown-divider">
          <li><a class="dropdown-item" href="<?= site_url('admin/barang-persediaan-masuk') ?>">Lihat Selengkapnya</a></li>
          `);
          if (data.unseen_notification > 0) {
            $('#notifpersediaan').html(`
            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
              <span class="badge rounded-pill badge-sm badge-notification bg-danger" style="color:white;cursor:pointer;" id="notification_count">${data.unseen_notification}</span>
            `);
          } else {
            $('#notifpersediaan').html(`
            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
            `)
          }
        }
      });
    }

    function load_unseen_pelaporan(view) {
      $.ajax({
        url: "<?= base_url('pelaporancontroller/notifikasi_viewed') ?>",
        method: "POST",
        data: {
          view: view
        },
        dataType: "json",
        success: function(data) {
          $('#showpelaporan').html(data.notification);
          $('#showpelaporan').append(`
          <hr class="dropdown-divider">
          <li><a class="dropdown-item" href="<?= site_url('admin/notification') ?>">Lihat Semua Pelaporan</a></li>
          `);
          if (data.unseen_notification > 0) {
            $('#pelaporanmasuk').html(`
            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
              <span class="badge rounded-pill badge-sm badge-notification bg-warning" style="color:black;cursor:pointer;" id="notification_count">${data.unseen_notification}</span>
            `);
          } else {
            $('#pelaporanmasuk').html(`
            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
            `)
          }
        }
      });
    }
  </script>
  <?= $this->renderSection('javascript') ?>

</body>

</html>