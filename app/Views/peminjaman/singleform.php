<div class="card mb-3 shadow" id="tampilformpeminjaman">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title"><?= $saveMethod == 'update' ? 'Update' : 'Tambah' ?> Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="py-4" id="formpeminjaman" action="<?= $saveMethod == 'update' ? "peminjaman-barang/update/$id" : "peminjaman-barang/simpan"  ?>" saveMethod="<?= $saveMethod ?>" onSubmit="pinjam.submit(this, event)">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="jenis_kat" id="jenis_kat" value="<?= $jenis_kat ?>">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="anggota_id" class="form-label">Nama Peminjam</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <select class="form-select" name="anggota_id" id="anggota_id"></select>
              <div class="invalid-feedback erranggota_id"></div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="tgl_pinjam" class="form-label">Tanggal Peminjaman</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
              <input type="datetime-local" class="form-control" id="tgl_pinjam" name="tgl_pinjam">
              <div class="invalid-feedback errtgl_pinjam"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row mb-1">
          <label for="keterangan">Keterangan <?= $title; ?></label>
        </div>
        <div class="row mb-1">
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
            <div class="invalid-feedback errketerangan"></div>
          </div>
        </div>
      </div>
      <?php $no = 1; ?>
      <div class="table-responsive">
        <table class="table table-borderless">
          <thead>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Sisa Stok</th>
            <th>Jumlah peminjaman</th>
            <th>Satuan</th>
            <th <?= $saveMethod == 'update' ? 'hidden' : '' ?>>#</th>
          </thead>
          <tbody id="tambahrow">
            <tr>
              <td><?= $no ?></td>
              <td>
                <select name="barang_id<?= $no ?>" class="form-select p-2" id="barang_id<?= $no ?>" style="width: 400px;"></select>
                <div class="invalid-feedback errbarang_id<?= $no ?>"></div>
              </td>
              <td>
                <input type="number" class="form-control" id="sisastok<?= $no ?>" placeholder="Sisa Stok" disabled>
                <div class="invalid-feedback errsisastok<?= $no ?>"></div>
              </td>
              <td>
                <input type="number" min="1" class="form-control" id="jml_barang<?= $no ?>" placeholder="Masukkan Jumlah Barang" name="jml_barang<?= $no ?>">
                <div class="invalid-feedback errjml_barang<?= $no ?>"></div>
              </td>
              <td>
                <select name="satuan_id<?= $no ?>" class="form-select p-2" id="satuan<?= $no ?>"></select>
                <div class="invalid-feedback errsatuan<?= $no ?>"></div>
              </td>
              <td style="width:1px; white-space:nowrap;" <?= $saveMethod == 'update' ? 'hidden' : '' ?>>
                <button type="button" class="btn btn-primary btn-sm btntambahrow"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-danger btn-sm btnhapusrow" style="display:none;"><i class="fa fa-times"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="viewalert" style="display:none;"></div>
      <div class=" row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4" onClick="util.closeBtn('#tampilformpeminjaman')">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan"><?= $saveMethod == 'update' ? 'Ubah' : 'Simpan' ?></button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  var sisa_stok_lama = [];
  var jumlah_lama = [];
  //check duplikat barang
  idbrgSet = new Set();
  var rowCount = '';

  $(document).ready(function() {
    let lastNumb = parseInt("<?= $no ?>");
    let currIndex = lastNumb + 1;
    var level = '';
    let form = $('#tampilformpeminjaman');
    let saveMethod = $("#formpeminjaman").attr('saveMethod');
    rowCount = $('#tambahrow tr').length;
    $('.anggotabaru').hide();

    pinjam.appendRowFormPinjam(rowCount);
    selectOption.anggota("anggota_id");
    const inputId = util.getIdsForm('formpeminjaman');
    util.initializeValidationHandlers(inputId);

    $('.btntambahrow').on('click', function(e) {
      e.preventDefault();
      var index = currIndex++;
      $("#tambahrow").append(`
      <tr>
        <td>${index}</td>
        <td>
          <select name="barang_id${index}" class="form-select p-2" id="barang_id${index}" style="width: 400px;"></select>
          <div class="invalid-feedback errbarang_id${index}"></div>
        </td>
        <td> <input type="number" class="form-control" id="sisastok${index}" placeholder="Sisa Stok" disabled>
          <div class="invalid-feedback errsisastok${index}"></div>
        </td>
        <td> <input type="number" min="1" class="form-control" id="jml_barang${index}" placeholder="Masukkan Jumlah Barang" name="jml_barang${index}">
          <div class="invalid-feedback errjml_barang${index}"></div>
        </td>
        <td>
          <select name="satuan_id${index}" class="form-select p-2" id="satuan${index}"></select>
          <div class="invalid-feedback errsatuan${index}"></div>
        </td>
        <td style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger btn-sm btnhapusrow"><i class="fa fa-times"></i></button>
        </td>
      </tr>
    `);
      rowCount = $('#tambahrow tr').length;
      pinjam.appendRowFormPinjam(rowCount);
      $("#tambahrow tr:last-child .btnhapusrow").show();
    });

    $(document).on('click', '.btnhapusrow', function(e) {
      e.preventDefault();
      // hapus tr yang diklik
      $(this).parents('tr').remove();
      currIndex--;
      if (currIndex <= lastNumb) {
        currIndex = lastNumb + 1;
      }
      //hapus tr sebelumnya
      rowCount = $('#tambahrow tr').length;
      for (var i = 0; i < rowCount; i++) {
        $('#tambahrow tr').find('.btnhapusrow').hide();
      }
      rowCount === 1 ? $('#tambahrow tr').find('.btnhapusrow').hide() :
        $("#tambahrow tr:last-child .btnhapusrow").show();
    })
    let data = <?= json_encode($pinjam !== "" ? $pinjam : ""); ?>;
    if (saveMethod == "update" && data !== "") {
      pinjam.fillForm(JSON.parse(data), form);
    }
  });
</script>