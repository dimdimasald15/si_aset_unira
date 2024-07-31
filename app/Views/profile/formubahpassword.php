<div class="card shadow mb-3" id="tampilubahpassword">
    <div class="card-header shadow-sm">
        <div class="row">
            <h4 class="card-title">Form Ubah Password</h4>
        </div>
    </div>
    <div class="card-body mt-3">
        <form class="form form-vertical" id="formUbahPassword" action="profile/ubahpassword" onSubmit="profile.updatePassword(this, event)">
            <input type="hidden" name="id" value="<?= $id ?>">
            <?= csrf_field() ?>
            <div class="form-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-1">
                            <label for="password_lama">Password Lama</label>
                        </div>
                        <div class="row mb-1">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" placeholder="Password Lama" id="password_lama" name="password_lama">
                                <div class="invalid-feedback errpassword_lama"></div>
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
                                <div class="invalid-feedback errpassword_baru"></div>
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
                        <button type="button" class="btn btn-white" onclick="util.closeBtn('#tampilubahpassword')">Batal</button>
                        <button type="submit" class="btn btn-success btnsimpan">Ubah</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        const idFormPassword = util.getIdsForm('formUbahPassword');
        util.initializeValidationHandlers(idFormPassword);
        util.togglePasswordVisibility("#show-password", ['#password_baru', '#password_lama'])
    });
</script>