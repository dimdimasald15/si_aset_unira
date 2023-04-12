<?= $this->extend('/layouts/template') ?>
<?= $this->section('content') ?>

<style>
    .profile-picture-label {
        display: inline-block;
        position: relative;
    }

    .profile-picture-preview {
        width: 160px;
        height: 160px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    .profile-picture-upload-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
        color: #007bff;
        text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
    }

    .basic-filepond {
        visibility: hidden;
        position: absolute;
        top: 0;
        left: 0;
    }

    .visually-hidden {
        position: absolute !important;
        clip: rect(1px, 1px, 1px, 1px);
        padding: 0 !important;
        border: 0 !important;
        height: 1px !important;
        width: 1px !important;
        overflow: hidden;
    }

    #image-preview {
        display: block;
        margin: auto;
        width: 180px;
        height: 180px;
    }
</style>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>My Profile</h3>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <?php foreach ($breadcrumb as $crumb) : ?>
                            <?php if (end($breadcrumb) == $crumb) : ?>
                                <div class="breadcrumb-item"><?= $crumb['name'] ?></div>
                            <?php else : ?>
                                <div class="breadcrumb-item active"><a href="#"><?= $crumb['name'] ?></a></div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


<section class="section">
    <div class="card mb-3" id="tampilgantifoto" style="display:none">
        <div class="card-header">
            <div class="row">
                <h4 class="card-title">Ganti Foto</h4>
            </div>
        </div>
        <div class="card-body">
            <form class="form form-vertical" id="formGantiFoto" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-body">
                    <input type="hidden" value="<?= $id; ?>" name="id" id="id">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="foto">Foto</label>
                            </div>
                            <div class="row mb-1">
                                <input type="file" class="image-preview-filepond" name="foto" id="foto" />
                                <div class="invalid-feedback errfoto"></div>
                                <img id="image-preview" src="" alt="Preview" style="display:none;">
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-white my-4 batal-form-foto">Batal</button>
                            <button type="submit" class="btn btn-warning my-4 btnsimpanfoto">Ubah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section">
    <div class="card mb-3" id="tampilubahpassword" style="display:none">
        <div class="card-header">
            <div class="row">
                <h4 class="card-title">Ubah Password</h4>
            </div>
        </div>
        <div class="card-body">
            <form class="form form-vertical" id="formUbahPassword">
                <?= csrf_field() ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="password">Password Lama</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control" placeholder="Password Lama" id="password_lama" name="password_lama">
                                    <div class="invalid-feedback errpasslama"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="password">Password Baru</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" placeholder="Password Baru" id="password_baru" name="password_baru">
                                    <div class="invalid-feedback errpassbaru"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <input type="checkbox" id="show-password" class="m-1">
                                    <label for="show-password"> Show password </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
                            <button type="submit" class="btn btn-success my-4 btnsimpan">Ubah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section">
    <div class="card-header">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-9">
                <h4 class="card-title">My Profile</h4>
            </div>
            <div class="col-md d-flex  flex-row mx-2 justify-content-end">
                <div class="col-md-auto">
                    <button type="button" class="btn btn-outline-warning" id="btn-gantifoto">
                        <i class="bi bi-camera-fill"></i>
                        Ganti Foto
                    </button>
                    <button type="button" class="btn btn-outline-success" id="btn-ubahpassword">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                        </svg>
                        Ubah Password
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <label for="profile-picture-upload" class="profile-picture-label">
                        <img id="profile-image" src="<?= base_url(); ?>/uploads/<?= $foto; ?>" class="img-thumbnail rounded-circle mb-3 profile-picture-preview" alt="Profile Picture">
                    </label>
                    <h3 class="card-title mb-2"><?= $_SESSION['username']; ?></h3>
                    <h6 class="card-subtitle mb-3 text-muted"><?= $_SESSION['role']; ?></h6>
                </div>
                <div class="col-md-8">
                    <h4 class="card-title mb-3">Personal Information</h4>
                    <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>NIP</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" class="form-control" id="first-name-icon" value="<?= $_SESSION['nip']; ?>" readonly />
                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="email" class="form-control" id="first-name-icon" value="<?= $_SESSION['email'] ?>" readonly />
                                            <div class="form-control-icon">
                                                <i class="bi bi-envelope"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>Username</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" class="form-control" value="<?= $_SESSION['username']; ?>" readonly />
                                            <div class="form-control-icon">
                                                <i class="bi bi-phone"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>Role</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                            <input type="text" class="form-control" value="<?= $_SESSION['role']; ?>" readonly />
                                            <div class="form-control-icon">
                                                <i class="bi bi-lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</section>


<?= $this->endSection() ?>
<?= $this->section('javascript') ?>

<script>
    $(document).ready(function() {

        $('#show-password').click(function() {
            if ($(this).is(':checked')) {
                $('#password_lama').attr('type', 'text');
                $('#password_baru').attr('type', 'text');
            } else {
                $('#password_lama').attr('type', 'password');
                $('#password_baru').attr('type', 'password');
            }
        });


        $('#foto').change(function() {
            let file = this.files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview').show();
            }
            reader.readAsDataURL(file);
        });

        $('#btn-gantifoto').click(function(e) {
            e.preventDefault();
            clear_is_invalid();
            clearForm();
            formgantifoto.show(500);
            formubahpassword.hide(500);
        })

        $('.batal-form-foto').click(function(e) {
            e.preventDefault();
            clear_is_invalid();
            formgantifoto.hide(500);
        });

        $('#btn-ubahpassword').click(function(e) {
            e.preventDefault();
            clear_is_invalid();
            clearForm();
            formubahpassword.show(500);
            formgantifoto.hide(500);
        })

        $('.batal-form').click(function(e) {
            e.preventDefault();
            clear_is_invalid();
            formubahpassword.hide(500);
        });

        $('#formUbahPassword').submit(function(e) {
            e.preventDefault();

            // Kirim data form menggunakan jQuery Ajax
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/profile/ubahpassword'); ?>",
                dataType: "json",
                data: $(this).serialize(),
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disabled');
                    $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable');
                    $('.btnsimpan').html('Simpan');
                    $('.form-control-icon').css("transform", "translate(0,-27px)");
                },
                success: function(response) {
                    if (response.success) {
                        formubahpassword.hide(500)
                        // Jika berhasil mengubah password, tampilkan sweetalert berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        });
                        $('#profile-image').attr('src', '<?= base_url('uploads/') ?>' + response.fileName);
                    } else {
                        // Jika gagal, tampilkan sweetalert error sesuai dengan jenis error yang terjadi
                        if (response.errors.password_lama) {
                            $('#password_lama').addClass('is-invalid');
                            $('.errpasslama').html(response.errors.password_lama);
                        } else {
                            $('#password_lama').removeClass('is-invalid');
                            $('.errpasslama').html('');
                        }
                        if (response.errors.password_baru) {
                            $('#password_baru').addClass('is-invalid');
                            $('.errpassbaru').html(response.errors.password_baru);
                        } else {
                            $('#password_baru').removeClass('is-invalid');
                            $('.errpassbaru').html('');
                        }
                    }
                },

            });
        });


        $('.btnsimpanfoto').on('click', function(e) {
            e.preventDefault();

            let formupload = $('#formGantiFoto')[0];
            var formData = new FormData(formupload);

            $.ajax({
                type: 'POST',
                url: '<?= site_url('admin/profile/gantifoto') ?>',
                data: formData,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.btnsimpanfoto').attr('disable', 'disabled');
                    $('.btnsimpanfoto').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsimpanfoto').removeAttr('disable');
                    $('.btnsimpanfoto').html('Ubah');
                    $('.form-control-icon').css("transform", "translate(0,-27px)");
                },
                success: function(response) {
                    console.log(response);
                    if (response.error) {
                        if (response.error.foto) {
                            $('#foto').addClass('is-invalid');
                            $('.errfoto').html(response.error.foto);
                        } else {
                            $('#foto').removeClass('is-invalid');
                            $('.errfoto').html('');
                        }
                    } else {
                        // alert(response)
                        formgantifoto.hide(500)
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            location.reload();
                        });

                    }
                }
            });
        });

    });

    let formubahpassword = $('#tampilubahpassword');
    let formgantifoto = $('#tampilgantifoto');

    function clearForm() {
        formubahpassword.find("input").val("")
        $('#foto').removeClass('is-invalid');
        $('#image-preview').removeAttr('src').hide();
        $("#show-password").prop('checked', false);
    }

    function clear_is_invalid() {
        if (formubahpassword.find('input').hasClass('is-invalid') || formubahpassword.find('select').hasClass('is-invalid')) {
            formubahpassword.find('input').removeClass('is-invalid');
            formubahpassword.find('select').removeClass('is-invalid');
            $('.form-control-icon').css("transform", "translate(0,-15px)");
        }
    }
</script>

<?= $this->endSection() ?>