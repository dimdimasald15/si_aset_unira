<div class="card shadow mb-3" id="tampilform">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title"><?= $saveMethod == 'update' ? 'Update' : 'Tambah' ?> Data Gedung</h4>
    </div>
  </div>
  <div class="card-body">
    <form class="form form-vertical" id="formGedung" action="<?= $saveMethod == 'update' ? "gedung/update/$id" : "gedung/simpan" ?>" saveMethod="<?= $saveMethod ?>" onSubmit="gedung.submit(this, event)">
      <?= csrf_field() ?>
      <div class="form-body">
        <div class="row mt-3">
          <div class="col-12">
            <input type="hidden" name="id" id="id">
            <!-- <div class="form-group has-icon-left"> -->
            <div class="row mb-1">
              <label for="namagedung">Nama Gedung</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
                <input type="text" class="form-control" placeholder="Nama gedung" id="namagedung" name="nama_gedung">
                <div class="invalid-feedback errnamagedung"></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row mb-1">
              <label for="prefix">Nama Singkat Gedung (Prefix)</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-arrow-down-left-square"></i></span>
                <input type="text" class="form-control" placeholder="Nama Singkat Gedung" id="prefix" name="prefix">
                <div class="invalid-feedback errprefix"></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row mb-1">
              <label for="katid">Nama Kategori</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <!-- <span class="input-group-text"><i class="bi bi-layers"></i></span> -->
                <select name="kat_id" class="form-select p-2" id="katid"></select>
                <div class="invalid-feedback errkatid"></div>
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
    let formtambah = $('#tampilform');
    const inputId = util.getIdsForm('formGedung');
    const saveMethod = $("#formGedung").attr('saveMethod');
    let data = <?= json_encode($gedung !== "" ? $gedung : ""); ?>;
    util.initializeValidationHandlers(inputId);
    selectOption.category('katid');
    if (saveMethod === "update" && data !== "") {
      gedung.fillForm(JSON.parse(data), formtambah);
    }
  })
</script>