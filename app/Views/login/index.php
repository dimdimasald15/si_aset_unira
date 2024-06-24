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
    
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/pages/auth.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- sweetalert2 -->
    <link href="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <script src="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
      const BASE_URL = "<?= base_url() ?>";
    </script>
    <!-- JQuery -->
    <script src="<?= base_url() ?>/assets/js/jquery-3.6.3.js"></script>
    <script type="module" src="<?= base_url() ?>/assets/js/myscript/main.js"></script>
  </head>

  <body>
    <div id="auth">
      <div class="row">
        <div class="col-lg-5 col-12">
          <div id="auth-left">
            <div class="auth-logo">
              <a href="/auth"><img src="<?= base_url() ?>/assets/images/logo/logouniralandscape.jpg" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Login.</h1>
            <p class="auth-subtitle mb-5">Selamat datang di Sistem Informasi Manajemen Aset
            <form method="post" action="auth/login" class="formLogin" onSubmit="auth.login(this, event)">
              <?= csrf_field() ?>
              <div class="form-group position-relative mb-4">
                  <div class="input-group has-validation">
                      <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                      <input onInput="util.rmIsInvalid('email')" type="email" class="form-control form-control-xl" placeholder="Email" name="email" id="email" aria-describedby="inputGroupPrepend">
                      <div class="invalid-feedback erremail"></div>
                  </div>
              </div>
              <div class="form-group position-relative mb-4">
                  <div class="input-group has-validation">
                      <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                      <input onInput="util.rmIsInvalid('password')" type="password" class="form-control form-control-xl" placeholder="Password" name="password" id="password">
                      <div class="invalid-feedback errpassword"></div>
                  </div>
              </div>
              <div class="form-check form-check-lg d-flex align-items-end">
                  <input class="form-check-input me-2" type="checkbox" onClick="util.showPassword()" class="m-1">
                  <label class="form-check-label text-gray-600" for="show-password"> Show password </label>
              </div>
              <button class="btn btn-success btn-block btn-lg shadow-lg mt-3 btnlogin" type="submit">Log in</button>
          </form>

          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right">
          </div>
        </div>
      </div>
    </div>
  </body>
</html>