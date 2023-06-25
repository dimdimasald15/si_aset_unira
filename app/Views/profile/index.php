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
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mystyle/mystyle.css">
    <link href="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- fontawesome -->
    <link href="<?= base_url() ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?= base_url() ?>assets/vendors/fontawesome/all.min.css" rel="stylesheet" type="text/css"> -->
    <script src="<?= base_url() ?>assets/vendors/jquery/jquery.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="dashboard"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="dashboard">
                <img src="<?= base_url() ?>assets/images/logo/logouniralandscape.jpg" style="width:200px; height: auto;">
            </a>
        </div>
    </nav>

    <div class="container px-5 mt-5">
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
        <div class="viewform" style="display:none"></div>
        <div class="card shadow mb-3" id="tampilgantifoto" style="display:none">
            <div class="card-header shadow-sm">
                <div class="row">
                    <h4 class="card-title">Ganti Foto</h4>
                </div>
            </div>
            <div class="card-body mt-3">
                <form class="form form-vertical" id="formGantiFoto" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-body">
                        <input type="hidden" value="<?= $petugas->id; ?>" name="id" id="id">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mb-1">
                                    <label for="foto">Foto</label>
                                </div>
                                <div class="row mb-1">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-image"></i></span>
                                        <input type="file" class="form-control image-preview-filepond" name="foto" id="foto">
                                        <div class="invalid-feedback errfoto"></div>
                                    </div>
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

        <div class="card shadow mb-3" id="tampilubahpassword" style="display:none">
            <div class="card-header shadow-sm">
                <div class="row">
                    <h4 class="card-title">Ubah Password</h4>
                </div>
            </div>
            <div class="card-body mt-3">
                <form class="form form-vertical" id="formUbahPassword">
                    <?= csrf_field() ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row mb-1">
                                    <label for="password_lama">Password Lama</label>
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
                                    <label for="password_baru">Password Baru</label>
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

        <div class="card shadow mb-3">
            <div class="card-header shadow-sm mb-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-9">
                        <h4 class="card-title">My Profile</h4>
                    </div>
                    <div class="col-md d-flex  flex-row mx-2 justify-content-end">
                        <div class="col-md-auto">
                            <button type="button" class="btn btn-warning" id="btn-gantifoto">
                                <i class="fa fa-camera"></i> Ganti Foto
                            </button>
                            <button type="button" class="btn btn-success" id="btn-ubahpassword"><i class="fa fa-lock"></i> Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body mt-3">
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col-md-4 text-center">
                        <label class="profile-picture-label">
                            <?php if ($petugas->foto) { ?>
                                <img id="profile-image" src="<?= base_url(); ?>/uploads/<?= $petugas->foto; ?>" class="img-thumbnail rounded-circle mb-3 profile-picture-preview" alt="Profile Picture">
                            <?php } else { ?>
                                <img id="profile-image" src="<?= base_url(); ?>/uploads/default.jpg" class="img-thumbnail rounded-circle mb-3 profile-picture-preview" alt="Profile Picture">
                            <?php }  ?>
                        </label>
                        <h3 class="card-title mb-2"><?= $petugas->username ?></h3>
                        <h6 class="card-subtitle mb-3 text-muted"><?= $petugas->role ?></h6>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="d-inline">
                                    <h4 class="card-title d-inline mb-3">Personal Information</h4>
                                </div>
                                <div class="d-inline p-2">
                                    <button class="btn btn-warning btn-sm py-0 px-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ubah profile" data-bs-trigger="hover focus" onclick="ubahprofil(<?= $petugas->nip ?>)"><i class="fa fa-edit"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <form class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>NIP</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="nip" value="<?= $petugas->nip; ?>" readonly />
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
                                                    <input type="email" class="form-control" id="email" value="<?= $petugas->email ?>" readonly />
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
                                                    <input type="text" class="form-control" value="<?= $petugas->username ?>" readonly />
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
                                                    <input type="text" class="form-control" value="<?= $petugas->role; ?>" readonly />
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
        </div>
        <footer>
            <div class="footer clearfix my-5 text-muted">
                <div class="float-start">
                    <p>&copy;<?= date('Y'); ?> <a href="https://www.instagram.com/dimdimasald15/" target="_blank">Dimas Aldi Sallam</a></p>
                </div>
                <div class="float-end">
                    <p>Created with <span class="text-danger"><i class="bi bi-heart"></i></span> using Mazer by <a href="http://ahmadsaugi.com" target="_blank">A. Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
</body>
<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Initialize the tooltip -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<script>
    let formubahpassword = $('#tampilubahpassword');
    let formgantifoto = $('#tampilgantifoto');

    $(document).ready(function() {
        $('.viewform').hide();
        $('#show-password').on('click', function() {
            if ($(this).is(':checked')) {
                $('#password_lama').attr('type', 'text');
                $('#password_baru').attr('type', 'text');
            } else {
                $('#password_lama').attr('type', 'password');
                $('#password_baru').attr('type', 'password');
            }
        });


        $('#foto').change(function() {
            $('#foto').removeClass('is-invalid');
            $('.errfoto').html('');
            let file = this.files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').attr('src', e.target.result);
                $('#image-preview').show(500);
            }
            reader.readAsDataURL(file);
        });

        $('#btn-gantifoto').on('click', function(e) {
            e.preventDefault();
            clear_is_invalid();
            clearForm();
            formgantifoto.show(500);
            formubahpassword.hide(500);
            $('.viewform').hide(500);
        })

        $('.batal-form-foto').on('click', function(e) {
            e.preventDefault();
            clear_is_invalid();
            formgantifoto.hide(500);
        });

        $('#btn-ubahpassword').on('click', function(e) {
            e.preventDefault();
            clear_is_invalid();
            clearForm();
            formubahpassword.show(500);
            formgantifoto.hide(500);
            $('.viewform').hide();
        })

        $('.batal-form').on('click', function(e) {
            e.preventDefault();
            clear_is_invalid();
            formubahpassword.hide(500);
        });

        $('#formUbahPassword').submit(function(e) {
            e.preventDefault();

            // Kirim data form menggunakan jQuery Ajax
            $.ajax({
                type: "POST",
                url: "profile/ubahpassword",
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
                url: 'profile/gantifoto',
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

    function ubahprofil(nip) {
        $.ajax({
            type: "post",
            url: "profile/tampilformeditprofil",
            data: {
                nip: nip
            },
            dataType: "json",
            success: function(response) {
                $('.viewform').show(500).html(response.data);
                formgantifoto.hide(500);
                formubahpassword.hide(500);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>

</html>