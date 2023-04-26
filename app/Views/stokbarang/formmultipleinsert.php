<div class="card mb-3 shadow" id="cardmultipleinsert">
  <div class="card-header shadow-sm">
    <h5 class="card-title">Form Multiple Insert <?= $title; ?></h5>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form class="form form-vertical py-4" class="formMultipleInsertBarang">
        <?= csrf_field(); ?>
        <p>
          <button type="button" class="btn btn-secondary batal-form">Close</button>
          <button type="submit" class="btn btn-success btnsimpanmultipleinsert">
            <i class="fa fa-save"></i> Simpan</button>
        </p>
        <table class="table table-sm table-bordered">
          <thead>
            <tr class="text-center">
              <th>Nama Kategori</th>
              <th>Kode Kategori</th>
              <th>Subkode Barang</th>
              <th id="skbrg-lain-header" style="display:none;">Subkode Barang Lain</th>
              <th>Tanggal Lahir</th>
              <th>Jenis Kelamin</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody class="formtambahrow">
            <tr>
              <td>
                <input type="text" name="kat_id[]" class="form-control">
              </td>
              <td>
                <input type="text" name="skat[]" class="form-control">
              </td>
              <td>
                <input type="text" name="skbbrg[]" class="form-control">
              </td>
              <td id="skbrg-lain" style="display:none;">
                <input type="text" name="skbrg_lain[]">
              </td>
              <td>
                <input type="text" name="nama_brg[]" class="form-control">
              </td>
              <td>
                <input type="text" name="merk[]" class="form-control">
              </td>
              <td>
                <input type="color" name="warna[]" class="form-control">
              </td>
              <td>
                <input type="date" name="tgl_pembelian[]" class="form-control">
              </td>
              <td>
                <button class="btn btn-primary btnaddform">
                  <i class="fa fa-plus"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<script>
  // let formtambah = $('#tampilformtambahbarang');

  $(document).ready(function() {
    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      $('#cardmultipleinsert').hide(500);
    });
  });
</script>