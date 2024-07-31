<div class="card shadow mb-3" id="tampilgantifoto">
    <div class="card-header shadow-sm">
        <div class="row">
            <h4 class="card-title">Ganti Foto</h4>
        </div>
    </div>
    <div class="card-body mt-3">
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