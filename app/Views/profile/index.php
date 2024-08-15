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
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/mystyle/profile-pict.css">
    <link href="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

    <!-- fontawesome -->
    <link href="<?= base_url() ?>assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="<?= base_url() ?>assets/vendors/fontawesome/all.min.css" rel="stylesheet" type="text/css"> -->
    <script src="<?= base_url() ?>assets/vendors/jquery/jquery.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        const BASE_URL = "<?= base_url() ?>";
        let nav = "<?= $nav ?>";
        let title = "<?= $title ?>";
        let isLogin = "<?= $_SESSION["isLoggedIn"] ?>";
	let token = "<?= $_SESSION["token"] ?>";
    </script>
    </style>
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="dashboard"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="dashboard">
                <img src="<?= base_url() ?>assets/images/logo/logouniralandscape.png" style="width:200px; height: auto;">
            </a>
        </div>
    </nav>

    <div class="container px-5 mt-3">
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
        <div class="col-12 col-md-12 viewdata shadow-sm-sm" style="display:none;"></div>
        <div class="card shadow mb-3">
            <div class="card-header shadow-sm mb-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-9">
                        <h4 class="card-title">My Profile</h4>
                    </div>
                    <div class="col-md d-flex flex-row mx-2 justify-content-end">
                        <div class="col-md-auto">
                            <button type="button" class="btn btn-success" id="btn-ubahpassword" onclick="util.getForm('update',<?= $petugas->id ?>)"><i class="fa fa-lock"></i> Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-0">
                <div class="row mt-3 d-flex justify-content-center">
                    <div class="col-md-4 row mb-5 text-center">
                        <div class="user-info">
                            <div class="profile-pic">
                                <?php if ($petugas->foto) { ?>
                                    <img id="profileImage" src="<?= base_url(); ?>/uploads/<?= $petugas->foto; ?>" class="img-thumbnail rounded-circle mb-3 profile-picture-preview" alt="Profile Picture">
                                <?php } else { ?>
                                    <img id="profileImage" src="<?= base_url(); ?>/uploads/default.jpg" class="img-thumbnail rounded-circle mb-3 profile-picture-preview" alt="Profile Picture">
                                <?php }  ?>
                                <div class="layer">
                                    <div class="loader"></div>
                                </div>
                                <a class="image-wrapper" href="#">
                                    <form id="profilePictureForm" action="#">
                                        <input class="hidden-input" id="changePicture" type="file" name="foto" />
                                        <label class="edit bi bi-camera text-white" for="changePicture" title="Change picture"></label>
                                    </form>
                                </a>
                            </div>
                            <div class="username">
                                <div class="name"><span class="verified"></span><?= $petugas->username ?></div>
                                <div class="about"><?= $petugas->role ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 row">
                        <div class="row d-flex justify-content-between mb-2">
                            <div class="col-lg-7 col-sm-8">
                                <h4>Personal Information</h4>
                            </div>
                            <div class="col-lg-5 col-sm-4">
                                <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ubah profile" data-bs-trigger="hover focus" onclick="profile.handleEditBtn('form-profile')">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <form class="form form-horizontal" id="form-profile" action="<?= $nav . '/updatedata/' . $petugas->id ?>" onsubmit="profile.submit(this, event)">
                                <div class="col-md-auto">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-3 col-md-3">
                                            <label class="col-form-label" for="nip">NIP</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="number" class="form-control" name="nip" id="nip" value="<?= $petugas->nip; ?>" readonly />
                                                    <div class="invalid-feedback errnip"></div>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-phone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-3 col-md-3">
                                            <label class="col-form-label" for="username">Username</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="username" id="username" value="<?= $petugas->username; ?>" readonly />
                                                    <div class="invalid-feedback errusername"></div>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-3 col-md-3">
                                            <label class="col-form-label" for="email">Email</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <input type="email" class="form-control" name="email" id="email" value="<?= $petugas->email ?>" style="display:none" />
                                                    <input type="email" class="form-control" name="email2" id="email2" value="<?= obfuscateEmail($petugas->email) ?>" readonly />
                                                    <div class="invalid-feedback erremail"></div>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-3 col-md-3">
                                            <label class="col-form-label" for="role">Role</label>
                                        </div>
                                        <div class="col-lg-9 col-md-9">
                                            <div class="form-group has-icon-left">
                                                <div class="position-relative">
                                                    <select name="role" class="form-select" id="role" disabled>
                                                        <option value="">Pilih Role</option>
                                                        <option value="Administrator" <?= $petugas->role == 'Administrator' ? 'selected' : '' ?>>Administrator</option>
                                                        <option value="Petugas" <?= $petugas->role == 'Petugas' ? 'selected' : '' ?>>Petugas</option>
                                                    </select>
                                                    <div class="invalid-feedback errrole"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end buttonAction d-none">
                                    <button type="button" class="btn btn-white my-2" onclick="profile.handleCancelBtn('form-profile')">&laquo; Batal</button>
                                    <button type="submit" class="btn btn-success my-2 btnsimpan">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer clearfix text-muted">
                <div class="float-start">
                    <p>&copy;2023 <a href="https://uniramalang.ac.id/" target="_blank">Universitas Islam Raden Rahmat Malang</a></p>
                </div>
                <div class="float-end">
                    <p>Created with <span class="text-danger"><i class="bi bi-heart"></i></span> using Mazer by <a href="http://ahmadsaugi.com" target="_blank">A. Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
</body>
<script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script type="module" src="<?= base_url() ?>assets/js/admin-page/app-profile.js"></script>
<script src="<?= base_url() ?>assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Initialize the tooltip -->
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

</html>