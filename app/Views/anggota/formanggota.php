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
<div class="card mb-3 shadow" id="tampilformanggota">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="py-4" id="formanggota" action="<?= $saveMethod == 'update' ? "anggota/updateanggota/$id" : "anggota/simpananggota"  ?>" saveMethod="<?= $saveMethod ?>" onSubmit="anggota.submit(this, event)">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="namaanggota" class="form-label">Nama <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" placeholder="Masukkan Nama Anggota" id="nama_anggota" name="nama_anggota">
              <div class="invalid-feedback errnama_anggota"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="level">Level <?= $title ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-badge-fill"></i></span>
                <select name="level" class="form-select p-2" id="level" onChange="anggota.handleLevel(this, 'formanggota')">
                  <option value="" disabled selected>Pilih Level</option>
                  <option value="Karyawan">Karyawan</option>
                  <option value="Mahasiswa">Mahasiswa</option>
                </select>
                <div class="invalid-feedback errlevel"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6 no_anggota" style="display:none;">
          </div>
          <div class="col-md-6">
            <label for="unit" class="form-label">Unit <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
              <select name="unit_id" class="form-select p-2" id="unit_id"></select>
              <div class="invalid-feedback errunit_id"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="no_hp" class="form-label">No Hp <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-telephone-plus"></i></span>
              <input type="number" class="form-control" placeholder="Masukkan No Handphone" id="no_hp" name="no_hp">
              <div class="invalid-feedback errno_hp"></div>
            </div>
          </div>
        </div>
      </div>
      <div class=" row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4" onClick="util.closeBtn('#tampilformanggota')">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan"><?= $saveMethod == 'update' ? 'Ubah' : 'Simpan' ?></button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    let form = $("#tampilformanggota");
    const inputId = util.getIdsForm('formanggota');
    const saveMethod = $("#formanggota").attr('saveMethod');
    let data = <?= json_encode($anggota !== "" ? $anggota : ""); ?>;
    util.initializeValidationHandlers(inputId);
    if (saveMethod === "update" && data !== "") {
      anggota.fillForm(JSON.parse(data), form);
    }
  });
</script>