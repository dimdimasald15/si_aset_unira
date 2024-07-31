<div class="card shadow mb-3" id="tampilform">
    <div class="card-header shadow-sm">
        <div class="row">
            <h4 class="card-title"><?= $saveMethod == 'update' ? 'Update' : 'Tambah' ?> Data Pengguna</h4>
        </div>
    </div>
    <div class="card-body">
        <form class="form form-vertical" id="formpengguna" action="<?= $saveMethod == 'update' ? "pengguna/update/$id" : "pengguna/simpan" ?>" saveMethod="<?= $saveMethod ?>" onSubmit="users.submit(this, event)">
            <?= csrf_field() ?>
            <div class="form-body">
                <div class="row mt-3">
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
                    <?php if ($saveMethod !== 'update') : ?>
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
                    <?php endif ?>
                    <div class="col-12">
                        <div class="row mb-1">
                            <label for="role">Role</label>
                        </div>
                        <div class="row mb-1">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="role"><i class="bi bi-layers"></i></label>
                                <select name="role" class="form-select" id="role" placeholder="Role">
                                    <option value="" selected> -- Pilih Role --</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Petugas">Petugas</option>
                                </select>
                                <div class="invalid-feedback errrole"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-white my-4" onClick="util.closeBtn('#tampilform')">Batal</button>
                        <button type="submit" class="btn btn-success my-4 btnsimpan"><?= $saveMethod == 'update' ? 'Ubah' : 'Simpan' ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        let form = $('#tampilform');
        const inputId = util.getIdsForm('formpengguna');
        const saveMethod = $("#formpengguna").attr('saveMethod');
        let data = <?= json_encode($pengguna !== "" ? $pengguna : ""); ?>;
        util.initializeValidationHandlers(inputId);
        if (saveMethod === "update" && data !== "") {
            users.fillForm(JSON.parse(data), form);
        }
    });
</script>