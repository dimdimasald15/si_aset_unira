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
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mystyle/mystyle.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mystyle/custom.css">
    <?= $this->renderSection('styles') ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/DataTables/DataTables-1.13.3/css/dataTables.jqueryui.css">
    <!-- sweetalert2 -->
    <link href="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <!-- Selectize.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" integrity="sha512-pZE3NzBgokXUM9YLBGQIw99omcxiRdkMhZkz0o7g0VjC0tCFlBUqbcLKUuX8+jfsZgiZNIWFiLuZpLxXoxi53w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- fontawesome -->
    <link href="<?= base_url() ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="<?= base_url() ?>assets/vendors/jquery/jquery.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        const BASE_URL = "<?= base_url() ?>";
        let nav = "<?= $nav ?>";
        let title = "<?= $title ?>";
        let isLogin = "<?= $_SESSION["isLoggedIn"] ?>";
    </script>
    <!-- module js -->
    <script type="module" src="<?= base_url() ?>assets/js/myscript/app.js" defer></script>
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- HTML2Canvasjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <!-- pdfmake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha512-a9NgEEK7tsCvABL7KqtUTQjl69z7091EVPpw5KxPlZ93T141ffe1woLtbXTX+r2/8TtTvRX/v4zTL2UlMUPgwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- qrCodejS -->
    <script src="<?= base_url() ?>assets/vendors/davidshimjs-qrcodejs/qrcode.min.js"></script>
    <!-- chartjs -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/chartjs/Chart.min.css">
    <!-- Pusherjs -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>
    <div id="app">
        <?= $this->include('layouts/sidebar') ?>
        <div id="main" class='layout-navbar'>
            <?= $this->include('layouts/header') ?>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-8 order-md-1 order-last">
                                <h3><?= $title === "Laporan" ? "$title Aset" : ($title === "Notifikasi Kerusakan Aset" || $title === "Dashboard" ? "$title" : "Daftar $title") ?></h3>
                                <p class="text-subtitle text-muted">Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang</p>
                            </div>
                            <div class="col-12 col-md-4 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item"><a href="dashboard"><i class="fa fa-home"></i></a></li>
                                        <?php foreach ($breadcrumb as $crumb) : ?>
                                            <?php if (end($breadcrumb) == $crumb) : ?>
                                                <li class="breadcrumb-item"><?= $crumb['name'] ?></li>
                                            <?php else : ?>
                                                <li class="breadcrumb-item active" aria-current="page"><a href="#"><?= $crumb['name'] ?></a></li>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="<?= base_url() ?>assets/vendors/DataTables/DataTables-1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.js" integrity="sha512-TCP0r/hsoR3XYFxxMqmxeCZSmHWkjdBiAGy+0xcQ+JU0hOBZMHho7O0x/bXZUf3DH6kcbGhuZFxONYXxMzd7EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>assets/vendors/chartjs/Chart.min.js"></script>
    <script src="<?= base_url() ?>assets/js/myscript/helperscript.js"></script>

    <script>
        $(document).ready(function() {
            notif.getNotification();
        });
    </script>
    <?= $this->renderSection('javascript') ?>

</body>

</html>