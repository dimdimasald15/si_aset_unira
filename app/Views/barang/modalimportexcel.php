<div class="modal fade" id="modalimportexcel" tabindex="-1" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="title"><?= $title ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form onSubmit="barang.uploadExcel(this, event)" method="post">
                <div class="modal-body modal-body-label">
                    <div class="container">
                        <?= csrf_field(); ?>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <label for="file" class="form-label">Input File (Format: .xls, .xlsx)</label>
                                    <input class="form-control" name="file" type="file" id="file" onInput="util.rmIsInvalid('file')">
                                    <div class="invalid-feedback errfile"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-upload"></i>
                                Upload</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>