<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/pages/auth.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css">

  <!-- JQuery -->
  <script src="<?= base_url() ?>/assets/js/jquery-3.6.3.js"></script>
</head>

<body>
  <div id="auth">
    <div class="row h-100">
      <div class="col-lg-5 col-12">
        <div id="auth-left">
          <div class="auth-logo">
            <a href="/auth"><img src="<?= base_url() ?>/assets/images/logo/logouniralandscape.jpg" alt="Logo"></a>
          </div>
          <h1 class="auth-title">Login.</h1>
          <p class="auth-subtitle mb-5">Selamat datang di Sistem Informasi Manajemen Aset
            <?= form_open('auth/login', ['class' => 'formLogin']) ?>
            <?= csrf_field() ?>
          <div class="form-group position-relative mb-4">
            <div class="input-group has-validation">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" id="email" aria-describedby="inputGroupPrepend" required>
              <div class="invalid-feedback erremail"></div>
            </div>
          </div>
          <div class="form-group position-relative mb-4">
            <div class="input-group has-validation">
              <span class="input-group-text">
                <i class="bi bi-shield-lock"></i>
              </span>
              <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" id="password">
              <div class="invalid-feedback errpassword"></div>

            </div>
          </div>

          <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" type="checkbox" id="show-password" class="m-1">
            <label class="form-check-label text-gray-600" for="show-password"> Show password </label>
            <!-- <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label text-gray-600" for="flexCheckDefault">
              Keep me logged in
            </label> -->
          </div>
          <button class="btn btn-success btn-block btn-lg shadow-lg mt-5 btnlogin" type="submit">Log in</button>
          <!-- </form> -->
          <?= form_close(); ?>
          <!-- <div class="text-center mt-5 text-lg fs-4">
            <p class="text-gray-600">Don't have an account? <a href="/mazer/applications/auth/register" class="font-bold">Sign
                up</a>.</p>
            <p><a class="font-bold" href="mazer/applications/auth/forgot-password">Forgot password?</a>.</p>
          </div> -->
        </div>
      </div>
      <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
      </div>
    </div>
  </div>
</body>
<script>
  $(document).ready(function() {

    $('#show-password').click(function() {
      if ($(this).is(':checked')) {
        $('#password').attr('type', 'text');
      } else {
        $('#password').attr('type', 'password');
      }
    });

    // console.log($('.formLogin').attr('action'));

    $('.formLogin').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnlogin').prop('disabled', true);
          $('.btnlogin').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnlogin').prop('disabled', false);
          $('.btnlogin').html('Login');
        },
        success: function(response) {
          if (response.error) {
            if (response.error.email) {
              $('#email').addClass('is-invalid');
              $('.erremail').html(response.error.email);
            } else {
              $('#email').removeClass('is-invalid');
              $('.erremail').html('');
            }

            if (response.error.password) {
              $('#password').addClass('is-invalid');
              $('.errpass').html(response.error.password);
            } else {
              $('#password').removeClass('is-invalid');
              $('.errpass').html('');
            }
          }
          if (response.sukses) {
            window.location = response.sukses.link;
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    })
  });
</script>

</html>