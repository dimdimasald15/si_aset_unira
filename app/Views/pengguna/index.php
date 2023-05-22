<?= $this->extend('/layouts/template'); ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Daftar Pengguna</h3>
                <p class="text-subtitle text-muted">Kelola menu pengguna di Universitas Islam Raden Rahmat Malang</p>
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
<section class="section">
    <div class="card shadow mb-3" id="tampilformtambahpengguna" style="display:none">
        <div class="card-header shadow-sm">
            <div class="row">
                <h4 class="card-title">Tambah Data Pengguna</h4>
            </div>
        </div>
        <div class="card-body">
            <form class="form form-vertical" id="formTambahPengguna">
                <?= csrf_field() ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="id" id="id">
                            <div class="row mb-1">
                                <label for="nip">NIP</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control" placeholder="NIP" id="nip" name="nip">
                                    <div class="invalid-feedback errnip"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="email">Email</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                                    <div class="invalid-feedback erremail"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="username">Username</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                    <input type="username" class="form-control" placeholder="Username" id="username" name="username">
                                    <div class="invalid-feedback errusername"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="password">Password</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-lock"></i></span>
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                                    <div class="invalid-feedback errpassword"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="role">Role</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                                    <select name="role" class="form-select" id="role" placeholder="Role">
                                        <option value="" selected> -- Pilih Role --</option>
                                        <option value="Administrator">Admin</option>
                                        <option value="petugas">Petugas</option>
                                    </select>
                                    <div class="invalid-feedback errrole"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
                            <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="section">
    <div class="card shadow mb-3 datalist-pengguna">
        <div class="card-header shadow-sm">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-9">
                    <h4 class="card-title">Data Pengguna</h4>
                </div>
                <div class="col-lg-3 d-flex flex-row-reverse">
                    <button type="button" class="btn btn-success" id="btn-tambahpengguna">
                        <i class="bi bi-building"></i>
                        Tambah Pengguna
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-flush" id="table-pengguna" width="100%">
                    <thead class=" thead-light">
                        <tr>
                            <th>No.</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    $(document).ready(function() {
        var datapengguna = $('#table-pengguna').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'pengguna/listdatapengguna',
            },
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'nip'
                },
                {
                    data: 'email'
                },
                {
                    data: 'username'
                },
                {
                    data: 'role'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'created_by'
                },
                {
                    data: 'action',
                    orderable: false
                },
            ]
        });

        $('#btn-tambahpengguna').click(function(e) {
            e.preventDefault();
            clear_is_invalid();
            defaultform();
            clearForm();
            formtambah.show(500);
            saveMethod = "add";
        })

        $('.batal-form').click(function(e) {
            e.preventDefault();
            clear_is_invalid();
            formtambah.hide(500);
        });

        $('#formTambahPengguna').submit(function(e) {
            e.preventDefault();
            // console.log('test');
            e.preventDefault();
            let url = "";
            if (saveMethod == "update") {
                url = "pengguna/update/" + globalId;
            } else if (saveMethod == "add") {
                url = "pengguna/simpan";
            }
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize(),
                dataType: "json",
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
                    console.log(response);
                    if (response.error) {
                        if (response.error.nip) {
                            $('#nip').addClass('is-invalid');
                            $('.errnip').html(response.error.nip);
                        } else {
                            $('#nip').removeClass('is-invalid');
                            $('.errnip').html('');
                        }
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.erremail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.erremail').html('');
                        }
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errusername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errusername').html('');
                        }
                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errpassword').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.errpassword').html('');
                        }
                        if (response.error.role) {
                            $('#role').addClass('is-invalid');
                            $('.errrole').html(response.error.role);
                        } else {
                            $('#role').removeClass('is-invalid');
                            $('.errrole').html('');
                        }
                    } else {
                        formtambah.hide(500);
                        Swal.fire(
                            'Berhasil!',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            datapengguna.ajax.reload();
                            $('.form-control-icon').css("transform", "translate(0,-15px)");
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

    function edit(id) {
        console.log('edit :' + id);
        clear_is_invalid();
        formtambah.show(500);
        saveMethod = "update";
        globalId = id;

        formtambah.find('.card-title').html('Edit Data Pengguna');
        formtambah.find("button[type='submit']").html('Perbarui');
        $("#password").parent().parent().parent().remove();

        $.ajax({
            type: "get",
            url: "<?= site_url('penggunacontroller/get_pengguna_by_id/') ?>" + id,
            dataType: "json",
            success: function(response) {
                console.log(response);
                isiForm(response);
            }
        });
    }

    function isiForm({
        id,
        nip,
        email,
        username,
        role
    }) {
        formtambah.find("input[name='nip']").val(nip)
        formtambah.find("input[name='email']").val(email)
        formtambah.find("input[name='username']").val(username)
        // formtambah.find("select[name*='kat_id']").val(kat_id)
        formtambah.find("select[name*='role']").html('<option value = "' + role + '" selected >' + role + '</option>');
    }


    function hapus(id, email) {
        console.log(id + " & " + email);
        Swal.fire({
            title: `Apakah kamu yakin ingin menghapus data ${email}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus saja!',
            cancelButtonText: 'Batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "pengguna/hapus/" + id,
                    data: {
                        email: email
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Berhasil', response.sukses, 'success'
                            ).then((result) => {
                                location.reload();
                            })
                        } else if (response.error) {
                            Swal.fire(
                                'Gagal!',
                                response.error,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });

    }


    let formtambah = $('#tampilformtambahpengguna');
    let saveMethod, globalId;

    function clearForm() {
        formtambah.find("input").val("")
        formtambah.find("select").val("")
    }

    function clear_is_invalid() {
        if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
            formtambah.find('input').removeClass('is-invalid');
            formtambah.find('select').removeClass('is-invalid');
            $('.form-control-icon').css("transform", "translate(0,-15px)");
        }
    }

    function defaultform() {
        formtambah.find('.card-title').html('Tambah Data Pengguna');
        formtambah.find("button[type='submit']").html('Simpan');
    }
</script>
<?= $this->endSection() ?>