<div class="card mb-3 shadow" id="tampilformunit">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title"><?= $saveMethod == 'update' ? 'Update' : 'Tambah' ?> Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="py-4" id="formunit" action="<?= $saveMethod == 'update' ? "anggota/updateunit/$id" : "anggota/simpanunit"  ?>" saveMethod="<?= $saveMethod ?>" onSubmit="unit.submit(this, event)">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="namaunit" class="form-label">Nama <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-circle-square"></i></span>
              <input type="text" class="form-control" placeholder="Masukkan Nama Unit" id="nama_unit" name="nama_unit">
              <div class="invalid-feedback errnama_unit"></div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="singkatan" class="form-label">Singkatan <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control" placeholder="Masukkan Singkatan" id="singkatan" name="singkatan">
              <div class="invalid-feedback errsingkatan"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="kat_unit">Kategori <?= $title ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
                <select name="kategori_unit" class="form-select p-2" id="kategori_unit" style="width: 100px;">
                  <option value="">Pilih Unit</option>
                  <?php foreach ($kategori as $row) : ?>
                    <option value="<?= $row ?>"><?= $row ?></option>
                  <?php endforeach ?>
                </select>
                <div class="invalid-feedback errkategori_unit"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row mb-1">
              <label for="deskripsi">Deskripsi <?= $title; ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
                <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                <div class="invalid-feedback errdeskripsi"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class=" row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4" onClick="util.closeBtn('#tampilformunit')">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan"><?= $saveMethod == 'update' ? 'Ubah' : 'Simpan' ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    let form = $("#tampilformunit");
    const inputId = util.getIdsForm('formunit');
    const saveMethod = $("#formunit").attr('saveMethod');
    let data = <?= json_encode($unit !== "" ? $unit : ""); ?>;
    util.initializeValidationHandlers(inputId);
    if (saveMethod === "update" && data !== "") {
      unit.fillForm(JSON.parse(data), form);
    }
  });
</script>