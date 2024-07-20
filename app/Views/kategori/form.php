<style>
  input[type=number] {
    -moz-appearance: textfield;
    /* Firefox */
  }

  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    /* May be needed depending on the styling */
  }
</style>
<div class="card shadow mb-3" id="tampilformkategori">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title"><?= $saveMethod == 'update' ? 'Update' : 'Tambah' ?> Data <?= $title . " " . $jenis ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="form form-vertical mt-3" id="formKategori" action="<?= $saveMethod == 'update' ? "kategori/update/$id" : "kategori/simpan" ?>" saveMethod="<?= $saveMethod ?>" onSubmit="kategori.submit(this, event)">
      <?= csrf_field() ?>
      <div class="form-body">
        <div class="row">
          <div class="col-12">
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            <input type="hidden" name="jenis" id="jenis" value="<?= $jenis; ?>">
            <div class="row mb-1">
              <label for="subkode1">Kode <?= $title ?></label>
            </div>
            <div class="row mb-1 subkodekategori">
              <div class="<?= $jenis == "Barang Persediaan" ? 'col-sm-4' : 'col-sm-3' ?> position-relative">
                <div class="input-group has-validation">
                  <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-square" viewBox="0 0 16 16">
                      <path d="M9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z"></path>
                      <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
                    </svg>
                  </span>
                  <select class="form-select" id="subkode1" onChange="kategori.handleSubkode1Change(this, $('#jenis').val())"></select>
                  <input type="text" class="form-control" placeholder="opsi lain" id="subkode1-other" style="display: none;">
                  <div class="invalid-feedback errsk1"></div>
                </div>
              </div>
              <div class="<?= $jenis == "Barang Persediaan" ? 'col-sm-4' : 'col-sm-3' ?> position-relative">
                <div class="input-group has-validation">
                  <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-2-square" viewBox="0 0 16 16">
                      <path d="M6.646 6.24v.07H5.375v-.064c0-1.213.879-2.402 2.637-2.402 1.582 0 2.613.949 2.613 2.215 0 1.002-.6 1.667-1.287 2.43l-.096.107-1.974 2.22v.077h3.498V12H5.422v-.832l2.97-3.293c.434-.475.903-1.008.903-1.705 0-.744-.557-1.236-1.313-1.236-.843 0-1.336.615-1.336 1.306Z"></path>
                      <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
                    </svg>
                  </span>
                  <select class="form-select" id="subkode2" onChange="kategori.handleSubkode2Change(this, $('#jenis').val())"></select>
                  <input type="number" class="form-control" placeholder="opsi lain" id="subkode2-other" style="display: none;">
                  <div class="invalid-feedback errsk2"></div>
                </div>
              </div>
            </div>
            <div class="input-group col-md-4 mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-code-square"></i></span>
              <input type="text" class="form-control" placeholder="Kode Kategori" id="kd_kategori" name="kd_kategori" readonly>
              <div class="invalid-feedback errkd_kategori"></div>
            </div>
          </div>
          <div class="col-12">
            <div class="row mb-1">
              <label for="namakategori">Nama <?= $title ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                <input type="text" class="form-control" placeholder="Nama Kategori" id="nama_kategori" name="nama_kategori">
                <div class="invalid-feedback errnama_kategori"></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row mb-1">
              <label for="deskripsi">Deskripsi <?= $title ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
                <textarea class="form-control" id="deskripsi" name="deskripsi" name="deskripsi"></textarea>
                <div class="invalid-feedback errdeskripsi"></div>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-white my-4" onclick="util.closeBtn('#tampilformkategori')">Batal</button>
            <button type="submit" class="btn btn-success my-4 btnsimpan"><?= $saveMethod == 'update' ? 'Ubah' : 'Simpan' ?></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    let formkategori = $('#tampilformkategori');
    const inputId = util.getIdsForm('formKategori');
    util.initializeValidationHandlers(inputId);
    var jenis = $('#jenis').val();
    const saveMethod = $("#formKategori").attr('saveMethod');
    let data = <?= json_encode($kategori !== "" ? $kategori : ""); ?>;
    kategori.getSubkode1(jenis);
    if (jenis == "Barang Tetap") {
      kategori.getElementSubKode3dan4();
    }
    if (saveMethod === "update" && data !== "") {
      kategori.fillForm(JSON.parse(data), formkategori);
    }
  });
</script>