<div class="card shadow mb-3" id="tampilform">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title"><?= $saveMethod == 'update' ? 'Update' : 'Tambah' ?> Data Ruangan</h4>
    </div>
  </div>
  <div class="card-body">
    <form class="form form-vertical" id="formRuang" action="<?= $saveMethod == 'update' ? "ruang/update/$id" : "ruang/simpan" ?>" saveMethod="<?= $saveMethod ?>" onSubmit="ruang.submit(this, event)">
      <?= csrf_field() ?>
      <div class="form-body">
        <div class="row mt-3">
          <div class="col-12">
            <input type="hidden" name="id" id="id">
            <div class="row mb-1">
              <label for="namaruang">Nama Ruang</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-door-closed"></i></span>
                <input type="text" class="form-control" placeholder="Nama ruang" id="namaruang" name="nama_ruang">
                <div class="invalid-feedback errnamaruang"></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row mb-1">
              <label for="namalantai">Nama Lantai</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-layers"></i></span>
                <select name="nama_lantai" class="form-select" placeholder="Nama lantai" id="namalantai">
                  <option value="" selected>Pilih Lantai</option>
                  <option value="1">Lantai 1</option>
                  <option value="2">Lantai 2</option>
                  <option value="3">Lantai 3</option>
                </select>
                <div class="invalid-feedback errnamalantai"></div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row mb-1">
              <label for="namagedung">Nama Gedung</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <select class="form-select" name="gedung_id" id="namagedung">
                  <option value="" selected>Pilih Gedung</option>
                  <?php foreach (json_decode($gedung) as $row) : ?>
                    <option value="<?= $row->id ?>">Gedung <?= $row->nama_gedung . " (" . $row->prefix . ")" ?> </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback errnamagedung"></div>
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
    const inputId = util.getIdsForm('formRuang');
    const saveMethod = $("#formRuang").attr('saveMethod');
    let data = <?= json_encode($ruang !== "" ? $ruang : ""); ?>;
    util.initializeValidationHandlers(inputId);
    if (saveMethod === "update" && data !== "") {
      ruang.fillForm(JSON.parse(data), form);
    }
  });
</script>