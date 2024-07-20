<div class="card mb-3 shadow" id="tampilformkembali">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Form <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form action="peminjaman-barang/pengembalian" class="py-4" id="formkembali" saveMethod="<?= $saveMethod ?>" onSubmit="pinjam.submitReturnForm(this, event)">
      <?= csrf_field() ?>
      <input type="hidden" name="globalId" id="globalId" value="<?= $id ?>">
      <div class="col-md-12">
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
              <input <?= $saveMethod == "update" ? 'type="datetime-local" readonly' : 'type="date"' ?> class="form-control" id="tgl_pinjam" name="tgl_pinjam">
              <div class="invalid-feedback errtgl_pinjam"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive" id="tabledatabrg" style="display:none;">
        <table class="table table-responsive-sm table-borderless">
          <thead class="text-center">
            <th style="display:none;">Id</th>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah Peminjaman</th>
            <th>Tanggal Kembali</th>
            <th>Kondisi Kembali</th>
            <th>Status</th>
          </thead>
          <tbody id="tambahrow">
          </tbody>
        </table>
      </div>
      <div class=" row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4" onClick="util.closeBtn('#tampilformkembali')">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan"> Kembalikan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  var form = $("#formkembali");
  var saveMethod = $(form).attr("saveMethod");
  var globalId = $(form).find("[name='globalId']").val();

  $(document).ready(function() {
    const inputId = util.getIdsForm('formkembali');
    util.initializeValidationHandlers(inputId);
    if (saveMethod == 'updateKembali' && globalId == '') {
      $('#tabledatabrg').hide();
      selectOption.peminjam();
      $(document).on('change', '#anggota_id, #tgl_pinjam', function(e) {
        e.preventDefault();
        var anggota_id = $('#anggota_id').val();
        var tgl_pinjam = $('#tgl_pinjam').val();
        if (anggota_id !== "" && tgl_pinjam !== "") {
          pinjam.getDataPeminjaman(anggota_id, tgl_pinjam);
        } else {
          $('#tabledatabrg').hide();
          $('#tambahrow').empty();
        }
      })
    } else {
      $('#tampilformkembali').find('.card-title').html('Ubah Data <?= $title ?>');
      $('.btnsimpan').html('Perbarui')
      $('#tabledatabrg').show();
      let data = <?= json_encode($pinjam !== "" ? $pinjam : ""); ?>;
      pinjam.fillForm2(JSON.parse(data), form);
    }
  });
</script>