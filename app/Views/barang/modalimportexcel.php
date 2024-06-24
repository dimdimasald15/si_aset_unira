<style>
    .btn-close-white {
        color: white;
    }

    .card {
        height: auto;
    }

    .card-label {
        border: 4px solid var(--bs-success) !important;
        border-radius: 15px !important;
        /* border-color: #1fa164; */
    }
</style>

<div class="modal fade" id="modalimportexcel" tabindex="-1" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content ">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="title"><?= $title ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form onSubmit="barang.uploadExcel(this, event)" id="formUpload"  method="post">
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

<script>
    $(document).ready(function() {
        $(`#jenis_kat`).on('change', function(e) {
            e.preventDefault();
            var jenis_kat = $(this).val();
           
            // Periksa jika Select2 sudah diinisialisasi, lalu hancurkan jika sudah
            if ($(`#katid`).hasClass('select2-hidden-accessible')) {
                console.log("destroy");
                $(`#katid`).select2('destroy');
            }

            $(`#katid`).select2({
                placeholder: 'Piih Kategori',
                minimumInputLength: 1,
                allowClear: true,
                width: "100%",
                ajax: {
                    url: `<?= $nav; ?>/pilihkategori`,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        console.log('Select2 ajax data function called with params:', params);
                        return {
                            search: params.term,
                            jenis_kat
                        };
                    },
                    processResults: function(data, page) {
                        console.log('Received data from AJAX:', data);
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatResult,
            });

            console.log('Select2 initialized with ajax settings');

            $(`#jenis_kat`).removeClass('is-invalid');
            $(`.errjenis_kat`).html('');
        });
    })
</script>