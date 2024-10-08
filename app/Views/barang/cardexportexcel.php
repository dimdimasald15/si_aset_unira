<div class="card mb-3 shadow" id="cardexport">
  <div class="card-header shadow-sm">
    <h5 class="card-title"><?= $title; ?></h5>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form class="form form-vertical py-1" id="" action="<?= $nav ?>/downloadtemplate" method="post" onSubmit="formbrg.downloadTemplate(this, event)">
        <?= csrf_field() ?>
        <div class="row d-flex justify-content-center">
          <div class="col-md-12">
            <div class="row mb-1">
              <label for="jenis_kat">Pilih Kategori</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <select name="jenis_kat" class="form-select p-2" id="jenis_kat" onChange="selectOption.multiCategory('katid',this)" required>
                  <option value="">Pilih Jenis Kategori Barang</option>
                  <option value="Barang Tetap">Barang Tetap</option>
                  <option value="Barang Persediaan">Barang Persediaan</option>
                </select>
                <div class="invalid-feedback errjenis_kat"></div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <label for="katid">Nama Kategori</label>
            <div class="form-group">
              <select name="katid[]" id="katid" class="choices form-select multiple-remove" multiple="multiple" disabled required></select>
              <div class="invalid-feedback errkatid"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-white my-2 batal-form" onClick="util.closeBtn('#cardexport')">Batal</button>
            <button type="submit" class="btn btn-success my-2">Download Template</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/js/pages/form-element-select.js') ?>"></script>