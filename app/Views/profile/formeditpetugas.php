<div class="card shadow mb-3" id="tampilupdatepetugas">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Form Edit <?= $title ?></h4>
    </div>
  </div>
  <div class="card-body mt-3">
    <form class="form form-vertical" id="formupdatepetugas">
      <?= csrf_field() ?>
      <div class="form-body">
        <input type="hidden" name="id" id="id">
        <div class="col-md-12">
          <div class="row g-2 mb-1">
            <div class="col-md-6">
              <div class="row mb-1">
                <label for="nip">NIP</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                  <input type="text" class="form-control" name="nip" id="nip">
                  <div class="invalid-feedback errnip"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row mb-2">
                <label for="username">Username</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-badge-fill"></i></span>
                  <input type="text" name="username" class="form-control" id="username"></input>
                  <div class="invalid-feedback errusername"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row g-2 mb-1">
            <div class="col-md-6">
              <div class="row mb-1">
                <label for="email">Email</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope-fill"></i></span>
                  <input type="email" class="form-control" name="email" id="email">
                  <div class="invalid-feedback erremail"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row mb-2">
                <label for="role">Role</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-shield-fill"></i></span>
                  <select name="role" class="form-select" id="role">
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Petugas">Petugas</option>
                  </select>
                  <div class="invalid-feedback errrole"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
          <button type="submit" class="btn btn-warning my-4 btnsimpan">Ubah</button>
        </div>
      </div>
  </div>
  </form>
</div>

<script>
  $(document).ready(function() {
    $('.batal-form').on('click', function(e) {
      e.preventDefault();
      $('#tampilupdatepetugas').hide(500);
      $('.viewform').hide(500);
    });

    $.ajax({
      type: "get",
      url: "<?= base_url('profilecontroller/getprofilebynip') ?>",
      data: {
        nip: "<?= $nip ?>"
      },
      dataType: "json",
      success: function(response) {
        isiForm(response);
      }
    });

    $('#nip').on('input', function(e) {
      e.preventDefault();
      $('#nip').removeClass('is-invalid');
      $('.errnip').html();
    })
    $('#username').on('input', function(e) {
      e.preventDefault();
      $('#username').removeClass('is-invalid');
      $('.errusername').html();
    })
    $('#email').on('input', function(e) {
      e.preventDefault();
      $('#email').removeClass('is-invalid');
      $('.erremail').html();
    })
    $('#role').on('change', function(e) {
      e.preventDefault();
      $('#role').removeClass('is-invalid');
      $('.errrole').html();
    })

    $('#formupdatepetugas').submit(function(e) {
      e.preventDefault();
      var id = $('#id').val();
      var formdata = $(this).serialize();

      $.ajax({
        type: "post",
        url: "<?= base_url('profilecontroller/updatedata') ?>" + `/${id}`,
        data: formdata,
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Simpan');
        },
        success: function(response) {
          if (response.error) {
            if (response.error.transaction) {
              Swal.fire(
                'Error!',
                response.error.transaction,
                'error'
              )
            }
            var nip = response.error.nip;
            var username = response.error.username;
            var email = response.error.email;
            var role = response.error.role;
            if (nip) {
              $('#nip').addClass('is-invalid');
              $('.errnip').html(nip);
            } else {
              $('#nip').removeClass('is-invalid');
              $('.errnip').html();
            }
            if (email) {
              $('#email').addClass('is-invalid');
              $('.erremail').html(email);
            } else {
              $('#email').removeClass('is-invalid');
              $('.erremail').html();
            }
            if (username) {
              $('#username').addClass('is-invalid');
              $('.errusername').html(username);
            } else {
              $('#username').removeClass('is-invalid');
              $('.errusername').html();
            }
            if (role) {
              $('#role').addClass('is-invalid');
              $('.errrole').html(role);
            } else {
              $('#role').removeClass('is-invalid');
              $('.errrole').html();
            }
          } else {
            $('#tampilupdatepetugas').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              location.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;

    })
  });

  function isiForm({
    id,
    nip,
    email,
    username,
    role
  }) {
    $('#id').val(id);
    $('#nip').val(nip);
    $('#username').val(username);
    $('#email').val(email);
    $('#formupdatepetugas').find("select[name='role']").val(role);
  }
</script>