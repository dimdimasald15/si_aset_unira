<?= helper('converter_helper') ?>
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
  <meta itemprop="name" content="Sistem Informasi Manajemen Aset">
  <meta itemprop="description" content="Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang">
  <meta itemprop="image" content="<?= base_url('assets/images/unira.png') ?>">
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/images/logo/logounira.jpg') ?>" type="image/png">

  <link rel="preconnect" href="https://fonts.gstatic.com">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Page plugins -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css">
  <style>
    a:hover {
      color: #b9b9b9 !important;
    }
  </style>
  <?= $this->renderSection('styles') ?>
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/iconly/bold.css">
  <!-- sweetalert2 -->
  <link href="<?= base_url() ?>/assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

  <!-- fontawesome -->
  <link href="<?= base_url() ?>/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="<?= base_url() ?>/assets/vendors/jquery/jquery.min.js"></script>
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <!-- Cropper.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- HTML2Canvasjs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

  <!-- HTML2PDFJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link src="<?= base_url() ?>assets/vendors/jquery/jquery.imagesloader.css">

  <?= $this->renderSection('styles') ?>

</head>

<body class="bg-success mt-3">
  <div class="main-content">
    <div class="header bg-success pt-4 pb-5 py-lg-4">
      <div class="container">
        <div class="header-body text-center mb-3">
          <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-8 px-5">
              <div class="text-center mb-3">
                <img src="<?= base_url('assets/images/logo/logounira.jpg') ?>" style="max-width: 60px;border:2px solid white;" alt="logo-unira">
              </div>
              <p class="text-lead text-white">Sistem Informasi Manajemen Aset UNIRA Malang</p>
            </div>
          </div>
        </div>
        <?= $this->renderSection('content') ?>
        <footer class="row justify-content-center my-3 text-white">
          <div class="col-lg-9 col-md-9 col-sm-12 clearfix mb-0">
            <div class="text-center">
              <p>©2023 <a href="https://uniramalang.ac.id/" target="_blank" class="text-white">
                  Universitas Islam Raden Rahmat Malang
                </a>
              </p>
            </div>
          </div>
        </footer>
      </div>
    </div>
  </div>
  </div>
  </div>

</body>
<!-- Core -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<!-- Optional Js -->
<script src="<?= base_url('assets/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<script>
  const BASE_URL = "<?= base_url() ?>";
  let nav = "<?= $nav ?>";
  let title = "<?= $title ?>";
</script>
<script type="module" src="<?= base_url('assets/js/report-breakdown-assets/report-assets.js') ?>"></script>
<script src=" https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url() ?>assets/vendors/jquery/jquery.imagesloader-1.0.1.js"></script>
<?= $this->renderSection('javascript') ?>
</body>

</html>