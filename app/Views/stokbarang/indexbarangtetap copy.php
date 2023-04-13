<?= $this->extend('/layouts/template'); ?>
<?= $this->section('styles') ?>
<style>
  img {
    display: block;
    max-width: 100%;
  }

  .preview {
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1px solid red;
  }

  .modal-lg {
    max-width: 1000px !important;
  }

  .img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
    /* sesuaikan dengan tinggi gambar yang ingin di crop */
    overflow: hidden;
  }

  .img-container img {
    display: block;
    max-width: 100%;
    max-height: 100%;
    margin: auto;
  }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar Barang</h3>
        <p class="text-subtitle text-muted">Kelola menu barang di Universitas Islam Raden Rahmat Malang</p>
      </div>
      <div class="col-12 col-md-4 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <?php foreach ($breadcrumb as $crumb) : ?>
              <?php if (end($breadcrumb) == $crumb) : ?>
                <div class="breadcrumb-item"><?= $crumb['name'] ?></div>
              <?php else : ?>
                <div class="breadcrumb-item active"><a href="#"><?= $crumb['name'] ?></a></div>
              <?php endif ?>
            <?php endforeach ?>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card mb-3" id="tampilformtambahbarang" style="display:none;">
      <div class="card-header">
        <div class="row">
          <h4 class="card-title">Tambah Data Barang</h4>
        </div>
      </div>
      <div class="card-body">
        <form class="form form-vertical" id="formTambahBarang">
          <?= csrf_field() ?>
          <div class="form-body">
            <div class="row d-flex justify-content-between">
              <div class="col-lg-6">
                <div class="col-12">
                  <input type="hidden" name="id" id="id">
                  <input type="hidden" name="jenis_transaksi" id="jenistrx" value="barang tetap masuk">
                  <div class="row mb-1">
                    <label for="katid mb-2">Nama Kategori</label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                      <select name="kat_id" class="form-select p-2" id="katid" style="width: 400px;"></select>
                      <div class="invalid-feedback errkatid"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="kodebrg">Kode Barang</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                          <i class="bi bi-upc"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Kode Kategori" id="subkdkategori" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="subkodebarang"></label>
                      <div class="input-group mb-3">
                        <select name="" class="form-select" id="skbarang"></select>
                        <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other" readonly style="display:none;">
                        <div class="invalid-feedback errskbrg"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="lokasi">Lokasi Penempatan Barang</label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                      <select class="form-select" id="lokasi" name="ruang_id"></select>
                      <div class="invalid-feedback errlokasi"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="namabarang">Nama Barang</label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="namabarang" name="nama_brg">
                      <div class="invalid-feedback errnamabarang"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="jmlmasuk" class="mb-1">Jumlah Barang Masuk</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                        <input type="number" min="1" class="form-control" placeholder="Masukkan Jumlah Barang Masuk" id="jmlmasuk" name="jumlah_masuk">
                        <div class="invalid-feedback errjmlmasuk"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="" class="mb-1">Satuan Barang</label>
                      <div class="input-group mb-3">
                        <select name="satuan_id" class="form-select p-2" id="satuan"></select>
                        <div class="invalid-feedback errsatuan"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="merk" class="form-label">Merk</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-tags"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk" name="merk">
                        <div class="invalid-feedback errmerk"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="warna" class="form-label">Warna</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-palette"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan Warna" id="warna" name="warna" <div class="invalid-feedback errwarna">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-5 asalbrg">
                      <label for="merk" class="form-label">Asal Barang Tetap</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asal" id="belibaru" value="Beli baru">
                        <label class="form-check-label" for="asal">
                          Beli Baru
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asal" id="belibekas" value="Beli bekas">
                        <label class="form-check-label" for="belibekas">
                          Beli Bekas
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="asal" id="hibah" value="Hibah">
                        <label class="form-check-label" for="hibah">
                          Hibah
                        </label>
                      </div>
                    </div>
                    <div class="col-md-7 radiobelibekas" style="display:none;">
                      <label for=" merk" class="form-label">Beli bekas dimana?</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" id="radiotoko">
                        <label class="form-check-label" for="radiotoko">
                          Beli di toko
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" id="radioinstansi">
                        <label class="form-check-label" for="radioinstansi">
                          Beli di Instansi
                        </label>
                      </div>
                    </div>
                    <div class="col-md-7 belibaru" style="display:none;">
                      <label for="toko" class="form-label">Nama Toko</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-shop"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan nama toko" id="toko" name="toko">
                        <div class="invalid-feedback errtoko"></div>
                      </div>
                    </div>
                    <div class="col-md-7 hibah" style="display:none;">
                      <label for="warna" class="form-label">Nama Instansi</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Instansi" id="instansi" name="instansi">
                        <div class="invalid-feedback errinstansi"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="noseri" class="form-label">Nomor seri barang</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-hash"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan No Seri" id="noseri" name="no_seri">
                        <div class="invalid-feedback errnoseri"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="nodokumen" class="form-label">Nomor Dokumen</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-earmark-text"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan No Dokumen" id="nodokumen" name="no_dokumen">
                        <div class="invalid-feedback errnodokumen"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="hargabeli" class="form-label">Harga Beli Barang</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Rp</span>
                        <input type="number" step="500" min="5000" class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli" name="harga_beli">
                        <div class="invalid-feedback errnoseri"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="hargajual" class="form-label">Harga Jual Barang</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Rp</span>
                        <input type="number" step="500" min="5000" class="form-control" placeholder="Masukkan Harga Jual" id="hargajual" name="harga_jual">
                        <div class="invalid-feedback errhargajual"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-auto">
                      <label for="fotobrg" class="mb-1">Gambar Barang</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-image"></i></span>
                        <input type="file" class="form-control" placeholder="Upload gambar barang" id="fotobrg" name="foto_barang">
                        <input id="cropped_image" name="cropped_image" style="display:none;">
                        <div class="invalid-feedback errfotobrg"></div>
                      </div>
                    </div>
                    <div class="col-md-auto">
                      <div class="previewresult" style="display:none;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-auto">
                      <label for="tglbeli" class="mb-1">Tanggal Pembelian</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                        <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli" name="tgl_pembelian">
                        <div class="invalid-feedback errtglbeli"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 d-flex justify-content-end">
              <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
              <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<div class="card mb-3 shadow">
  <div class="card-header shadow-sm">
    <h5>Custom Filter</h5>
  </div>
  <div class="card-body">
    <div class="row mt-3">
      <div class="col-lg-6 d-flex justify-content-start">
        <label class="col-sm-4 col-form-label" for="inputGroupSelect01">Kategori :</label>
        <div class="col-sm-8">
          <select id="selectkategori" class="form-select"></select>
        </div>
      </div>
      <div class="col-lg-6 d-flex justify-content-start">
        <label class="col-sm-4 col-form-label" for="inputGroupSelect01">Lokasi :</label>
        <div class="col-sm-8">
          <select id="selectlokasi" class="form-select"></select>
        </div>
      </div>
      <div class="col-lg-4"></div>
    </div>
    <!-- <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a> -->
  </div>
</div>
<div class="card mb-3 shadow datalist-barang">
  <div class="card-header shadow-sm">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-9">
        <h4 class="card-title">Data Barang</h4>
      </div>
      <div class="col-lg-3 d-flex flex-row-reverse">
        <button type="button" class="btn btn-success" id="btn-tambahbarang">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
            <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"></path>
          </svg>
          Tambah Barang
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive py-4">
      <table class="table table-bordered" id="table-barang" width="100%">
        <thead class=" thead-dark">
          <tr>
            <!-- <th style="width: 50px;">No.</th> -->
            <th>Action</th>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok Barang</th>
            <th>Satuan</th>
            <th>Harga Beli</th>
            <th>Lokasi</th>
            <th>Created By</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="viewmodal" style="display:none;"></div>

<div class="modal fade" id="modal_crop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pangkas gambar sebelum upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="img-container">
          <div class="row">
            <div class="col-md-8">
              <img src="" id="sample_image" />
            </div>
            <div class="col-md-4">
              <div class="preview"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="crop_and_upload" class="btn btn-success">Crop</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
<script>
  let formtambah = $('#tampilformtambahbarang');
  let saveMethod, globalId;
  let kd_brg = '';
  let jenistrx = $('#jenistrx').val();
  var kdbrgother = '';
  let asalbrg1 = $('#belibaru').val();
  let asalbrg2 = $('#belibekas').val();
  let asalbrg3 = $('#hibah').val();

  console.log(jenistrx + ' - ' + asalbrg1 + ' - ' + asalbrg2 + ' - ' + asalbrg3);
  // function edit(id) {
  //   // console.log('edit :' + id);
  //   clear_is_invalid();
  //   formtambah.show(500);
  //   saveMethod = "update";
  //   globalId = id;

  //   formtambah.find('.card-title').html('Edit Data Gedung');
  //   formtambah.find("button[type='submit']").html('Perbarui');

  //   $.ajax({
  //     type: "get",
  //     url: "<?= site_url('gedungcontroller/get_gedung_by_id/') ?>" + id,
  //     dataType: "json",
  //     success: function(response) {
  //       console.log(response);
  //       isiForm(response);
  //     }
  //   });
  // }

  // function isiForm({
  //   id,
  //   nama_gedung,
  //   prefix,
  //   kat_id,
  //   nama_kategori
  // }) {
  //   formtambah.find("input[name='id']").val(id)
  //   formtambah.find("input[name='nama_gedung']").val(nama_gedung)
  //   formtambah.find("input[name='prefix']").val(prefix)
  //   formtambah.find("select[name*='kat_id']").html('<option value = "' + kat_id + '" selected >' + nama_kategori + '</option>');

  // }

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").html("")
    formtambah.find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();
    $('.radiobelibekas').hide();
    $('#skbarang-other').hide();
    $('.previewresult').hide();
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data Barang');
    formtambah.find("button[type='submit']").html('Simpan');
  }

  // function hapus(id, namagedung) {
  //   // console.log(id + " & " + namagedung);
  //   // console.log('delete : ' + namagedung);
  //   Swal.fire({
  //     title: `Apakah kamu yakin ingin menghapus data ${namagedung}?`,
  //     icon: 'warning',
  //     showCancelButton: true,
  //     confirmButtonColor: '#3085d6',
  //     cancelButtonColor: '#d33',
  //     confirmButtonText: 'Ya, Hapus saja!',
  //     cancelButtonText: 'Batalkan',
  //   }).then((result) => {
  //     if (result.isConfirmed) {
  //       $.ajax({
  //         type: "post",
  //         url: "gedung/hapus/" + id,
  //         data: {
  //           nama_gedung: namagedung
  //         },
  //         dataType: 'json',
  //         success: function(response) {
  //           if (response.sukses) {
  //             Swal.fire(
  //               'Berhasil', response.sukses, 'success'
  //             ).then((result) => {
  //               location.reload();
  //             })
  //           } else if (response.error) {
  //             Swal.fire(
  //               'Gagal!',
  //               response.error,
  //               'error'
  //             );
  //           }
  //         },
  //         error: function(xhr, ajaxOptions, thrownError) {
  //           alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
  //         }
  //       });
  //     }
  //   });
  // }

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-layers"> </i>${data.text}</span>`
    );

    return $result;
  }

  function getsubkdbarang(idkategori) {
    $.ajax({
      url: "<?= site_url('barangcontroller/getsubkdbarang') ?>",
      type: "POST",
      data: {
        katid: idkategori,
      },
      dataType: "json",
      success: function(result) {
        console.log(result);
        $('#skbarang').empty();
        $('#skbarang').append('<option value="">Sub-Kode Barang</option>');
        $.each(result, function(key, value) {
          // $('#subkdbarang').val()
          $('#skbarang').append('<option value="' + value.subkdbarang + '">' + value.subkdbarang + '</option>');
        });
        $('#skbarang').append('<option value="otherbrg">Lainnya</option>');

        // if (kode1 !== undefined) {
        //   $("#skbarang option").each(function() {
        //     if ($(this).val() === kode1) {
        //       $(this).attr("selected", "selected");
        //     }
        //   });
        // }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    })

  }

  function clearformwithtrigger() {
    formtambah.find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();

    formtambah.find("input[name='nama_brg']").val('');
    formtambah.find("input[name='jumlah_masuk']").val('');
    formtambah.find("input[name='harga_beli']").val('');
    formtambah.find("input[name='harga_jual']").val('');
    formtambah.find("input[name='warna']").val('');
    formtambah.find("input[name='merk']").val('');
    formtambah.find("input[name='toko']").val('');
    formtambah.find("input[name='instansi']").val('');
  }

  var databarang = '';

  $(document).ready(function() {
    formtambah.hide();

    databarang = $('#table-barang').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'barang-tetap/listdatabarang',
        data: function(d) {
          d.kategori = $('#selectkategori').val()
          d.lokasi = $('#selectlokasi').val()
        }
      },
      order: [],
      columns: [{
          data: 'action',
          orderable: false
        },
        {
          data: 'no',
          orderable: false
        },
        {
          data: 'kode_brg'
        },
        {
          data: 'nama_brg'
        },
        {
          data: 'nama_kategori'
        },
        {
          data: 'sisa_stok',
        },
        {
          data: 'kd_satuan'
        },
        {
          data: 'harga_beli',
          render: function(data, type, row) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
          }
        },
        {
          data: 'nama_ruang'
        },
        {
          data: 'created_by'
        },
        {
          data: 'created_at',
          render: function(data, type, full, meta) {
            var dateParts = data.split(/[- :]/);
            var year = parseInt(dateParts[0]);
            var month = parseInt(dateParts[1]) - 1;
            var day = parseInt(dateParts[2]);
            var hours = parseInt(dateParts[3]);
            var minutes = parseInt(dateParts[4]);
            var seconds = parseInt(dateParts[5]);
            var options = {
              weekday: 'long',
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            };
            var formattedDate = new Date(year, month, day, hours, minutes, seconds).toLocaleDateString('id-ID', options);
            return formattedDate;
          }
        },
      ]
    });

    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/pilihkategori",
      data: {
        jenis_kat: 'Barang Tetap',
      },
      dataType: "json",
      success: function(response) {
        $('#selectkategori').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectkategori').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/pilihlokasi",
      dataType: "json",
      success: function(response) {
        console.log(response);
        $('#selectlokasi').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectlokasi').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $('#selectkategori').on('change', function(e) {
      e.preventDefault();
      databarang.ajax.reload();
    })

    $('#selectlokasi').on('change', function(e) {
      e.preventDefault();
      databarang.ajax.reload();
    })

    $('#btn-tambahbarang').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      defaultform();
      clearForm();
      $('#jenistrx').val(jenistrx);
      $('#belibaru').val(asalbrg1);
      $('#belibekas').val(asalbrg2);
      $('#hibah').val(asalbrg3);
      formtambah.show(500);
      saveMethod = "add";
    })

    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      formtambah.hide(500);
    });

    $('#katid').select2({
      placeholder: 'Piih Nama Kategori Barang tetap',
      minimumInputLength: 1,
      allowClear: true,
      width: "50%",
      ajax: {
        url: `barang-tetap/pilihkategori`,
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
            jenis_kat: 'Barang Tetap',
          }
        },
        processResults: function(data, page) {
          // console.log(data);
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatResult,
    });

    // var kodebarang = '';
    $('#katid').on('change', function(e) {
      e.preventDefault();
      var katid = $(this).val();
      if (katid == null) {
        kd_brg = '';
        clearForm();
      } else {
        $.ajax({
          type: "post",
          url: "<?= base_url() ?>/barangcontroller/getkdbrgbykdkat",
          data: {
            katid: katid,
          },
          dataType: "json",
          success: function(response) {
            $('#subkdkategori').val(response.subkdkat);
            // $('#skbarang-other').val();
            kdbrgother = response.subkdbrg;
            // kd_brg = `${$('#subkdkategori').val()}.${$('#skbarang-other').val()}`;
          }
        });

        getsubkdbarang(katid);
      }
    })

    $('#skbarang').on('change', function(e) {
      e.preventDefault();
      // console.log($('#skbarang').val());
      // console.log('kdbrgother : ' + kdbrgother);
      if ($(this).val() == '') {
        clearformwithtrigger();
        formtambah.find("select[name='satuan_id']").html("");
        formtambah.find("select[name='ruang_id']").html("");
      } else if ($('#skbarang').val() == 'otherbrg') {
        $('#skbarang-other').show();
        $('#skbarang-other').val(kdbrgother);
        kd_brg = `${$('#subkdkategori').val()}.${$('#skbarang-other').val()}`;
        clearformwithtrigger();
        formtambah.find("select[name='satuan_id']").html("");
        formtambah.find("select[name='ruang_id']").html("");
      } else {
        kd_brg = `${$('#subkdkategori').val()}.${$('#skbarang').val()}`
        $('#skbarang-other').hide();
        clearformwithtrigger();
        formtambah.find("select[name='satuan_id']").html("");
        formtambah.find("select[name='ruang_id']").html("");

        $.ajax({
          type: "post",
          url: "<?= base_url() ?>" + '/barangcontroller/getbarangbykdbarang',
          data: {
            kode_brg: kd_brg,
          },
          dataType: "json",
          success: function(response) {
            console.log('test1 = ' + response);
            formtambah.find("input[name='nama_brg']").val(response.nama_brg);
            formtambah.find("input[name='jumlah_masuk']").val(response.sisa_stok);
            formtambah.find("input[name='harga_beli']").val(response.harga_beli);
            formtambah.find("input[name='harga_jual']").val(response.harga_jual);
            formtambah.find("input[name='warna']").val(response.warna);
            formtambah.find("input[name='merk']").val(response.merk);
            formtambah.find("input[name='toko']").val(response.toko);
            formtambah.find("input[name='instansi']").val(response.instansi);
            if (response.asal === 'Beli baru') {
              $('#belibaru').prop('checked', true);
              $('.belibaru').show();
              $('.hibah').hide();
              $('.radiobelibekas').hide();
            } else if (response.asal == 'Beli bekas') {
              $('#belibekas').prop('checked', true);
              $('.radiobelibekas').hide();
              // $('.radiobelibekas').show();
              if (response.toko == null) {
                $('.belibaru').hide();
                $('.hibah').show();
              } else if (response.instansi == null) {
                $('.belibaru').show();
                $('.hibah').hide();
              }
            } else if (response.asal == 'Hibah') {
              $('#hibah').prop('checked', true);
              $('.hibah').show();
              $('.belibaru').hide();
              $('.radiobelibekas').hide();
            } else {
              formtambah.find("input[type='radio']").prop('checked', false);
              $('.hibah').hide();
              $('.belibaru').hide();
              $('.radiobelibekas').hide();
            }
          }
        });
      }
    })

    $('#lokasi').select2({
      placeholder: 'Piih lokasi',
      minimumInputLength: 1,
      allowClear: true,
      width: "50%",
      ajax: {
        url: "<?= base_url() ?>/barangcontroller/pilihlokasi",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
          }
        },
        processResults: function(data, page) {
          console.log(data);
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatResult,
    });

    $('#lokasi').on('change', function(e) {
      e.preventDefault();
      lokasi = $(this).val();
      console.log('lokasi = ' + lokasi);
      if (lokasi === null) {
        formtambah.find("input[name='jumlah_masuk']").val("");
        formtambah.find("select[name='satuan_id']").html("");
      } else {
        $.ajax({
          type: "post",
          url: "<?= base_url() ?>" + '/barangcontroller/getbarangbykdbarang',
          data: {
            kode_brg: kd_brg,
            ruang_id: lokasi,
          },
          dataType: "json",
          success: function(response) {
            console.log('test : ' + response);
            if (response !== null) {
              formtambah.find("input[name='nama_brg']").val(response.nama_brg);
              formtambah.find("input[name='jumlah_masuk']").val(response.sisa_stok);
              formtambah.find("input[name='harga_beli']").val(response.harga_beli);
              formtambah.find("input[name='harga_jual']").val(response.harga_jual);
              formtambah.find("input[name='warna']").val(response.warna);
              formtambah.find("input[name='merk']").val(response.merk);
              formtambah.find("input[name='toko']").val(response.toko);
              formtambah.find("input[name='instansi']").val(response.instansi);
              formtambah.find("select[name*='satuan_id']").html('<option value = "' + response.satuan_id + '" selected>' + response.kd_satuan + '</option>');
              if (response.asal === 'Beli baru') {
                $('#belibaru').prop('checked', true);
                $('.belibaru').show();
                $('.hibah').hide();
                $('.radiobelibekas').hide();
              } else if (response.asal == 'Beli bekas') {
                $('#belibekas').prop('checked', true);
                $('.radiobelibekas').hide();
                // $('.radiobelibekas').show();
                if (response.toko == null) {
                  $('.belibaru').hide();
                  $('.hibah').show();
                } else if (response.instansi == null) {
                  $('.belibaru').show();
                  $('.hibah').hide();
                }
              } else if (response.asal == 'Hibah') {
                $('#hibah').prop('checked', true);
                $('.hibah').show();
                $('.belibaru').hide();
                $('.radiobelibekas').hide();
              } else {
                formtambah.find("input[type='radio']").prop('checked', false);
                $('.hibah').hide();
                $('.belibaru').hide();
                $('.radiobelibekas').hide();
              }
            } else if (response == null) {
              clearformwithtrigger();
              formtambah.find("select[name='satuan_id']").html("");

            }
          }
        });
      }
    });

    $('#satuan').select2({
      placeholder: 'Piih Satuan',
      minimumInputLength: 1,
      allowClear: true,
      width: "resolve",
      ajax: {
        url: "<?= base_url() ?>/barangcontroller/pilihsatuan",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
          }
        },
        processResults: function(data, page) {
          console.log(data);
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatResult,
    });

    $('input[type="radio"]').click(function() {
      if ($(this).attr('id') == 'belibaru') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
      } else if ($(this).attr('id') == 'belibekas') {
        $('.radiobelibekas').show();
        $('.belibaru').hide();
        $('.hibah').hide();
      } else if ($(this).attr('id') == 'hibah') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
      } else if ($(this).attr('id') == 'radiotoko') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
      } else if ($(this).attr('id') == 'radioinstansi') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
      } else {
        $('.radiobelibekas').hide();
        $('.belibaru').hide();
        $('.hibah').hide();
      }
    });

    // var modalCrop = $('#modalCropImage');
    // var image = $('#sample_image');
    // var cropper;

    // $('#fotobrg').on('change', function(e) {
    //   // previewImage(this);
    //   var file = $(this).get(0).files[0]; // ambil file yang diupload
    //   console.log(file);
    //   // baca file menggunakan FileReader
    //   var reader = new FileReader();
    //   reader.onload = function() {
    //     $('.preview').show(500);

    //     $('.preview').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang</label><img src="' + reader.result + '" class="img-fluid text-center">'); // tampilkan gambar preview
    //   }
    //   reader.readAsDataURL(file);
    // });

    var $modal = $('#modal_crop');
    var crop_image = document.getElementById('sample_image');
    var cropper;

    $('#fotobrg').change(function(event) {
      var files = event.target.files;
      var done = function(url) {
        crop_image.src = url;
        $modal.modal('show');
      };
      if (files && files.length > 0) {
        reader = new FileReader();
        reader.onload = function(event) {
          done(reader.result);
        };
        reader.readAsDataURL(files[0]);
      }
    });
    $modal.on('shown.bs.modal', function() {
      cropper = new Cropper(crop_image, {
        aspectRatio: 16 / 9,
        viewMode: 3,
        preview: '.preview'
      });
    }).on('hidden.bs.modal', function() {
      cropper.destroy();
      cropper = null;
    });
    $('#crop_and_upload').click(function() {
      canvas = cropper.getCroppedCanvas({
        width: 1200,
        height: 1200
      });
      canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
          var base64data = reader.result;
          $('.previewresult').show(500);
          // $('#fotobrg').hide();
          // $('#cropped_image').show();
          $('#cropped_image').val(base64data);
          $('.preview').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang</label><img src="' + base64data + '" class="img-thumbnail" style="width: 200px; height: 200px;">'); // tampilkan gambar preview
          $('.previewresult').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang</label><img src="' + base64data + '" class="img-thumbnail" style="width: 400px; height: auto;">'); // tampilkan gambar preview
          $modal.modal('hide');
        };
      });
    });

    $('#formTambahBarang').submit(function(e) {
      e.preventDefault();
      // let url = "";
      // if (saveMethod == "update") {
      //   url = "barang-tetap/update/" + globalId;
      // } else if (saveMethod == "add") {
      //   url = "barang-tetap/simpan";
      // }
      var formdata = new FormData(this);
      var croppedImage = $('#cropped_image').val();
      var jenis = jenistrx;
      // console.log(jenis);
      var kode_brg = kd_brg;
      var asal = $("input[name='asal']:checked").val();

      formdata.append('jenis', jenis);
      formdata.append('kode_brg', kode_brg);
      formdata.append('asal', asal);
      formdata.append('cropped_image', croppedImage);

      $.ajax({
        type: "post",
        url: 'barang-tetap/simpan',
        data: formdata,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Simpan');
        },
        success: function(response) {
          console.log(response);
          if (response.error) {
            if (response.error.katid) {
              $('#katid').addClass('is-invalid');
              $('.errkatid').html(response.error.katid);
            } else {
              $('#katid').removeClass('is-invalid');
              $('.errkatid').html('');
            }
            if (response.error.skbarang) {
              $('#skbarang').addClass('is-invalid');
              $('.errskbarang').html(response.error.skbarang);
            } else {
              $('#skbarang').removeClass('is-invalid');
              $('.errskbarang').html('');
            }
            if (response.error.lokasi) {
              $('#lokasi').addClass('is-invalid');
              $('.errlokasi').html(response.error.lokasi);
            } else {
              $('#lokasi').removeClass('is-invalid');
              $('.errlokasi').html('');
            }
            if (response.error.namabarang) {
              $('#namabarang').addClass('is-invalid');
              $('.errnamabarang').html(response.error.namabarang);
            } else {
              $('#namabarang').removeClass('is-invalid');
              $('.errnamabarang').html('');
            }
            if (response.error.merk) {
              $('#merk').addClass('is-invalid');
              $('.errmerk').html(response.error.merk);
            } else {
              $('#merk').removeClass('is-invalid');
              $('.errmerk').html('');
            }
            if (response.error.warna) {
              $('#warna').addClass('is-invalid');
              $('.errwarna').html(response.error.warna);
            } else {
              $('#warna').removeClass('is-invalid');
              $('.errwarna').html('');
            }
            if (response.error.jmlmasuk) {
              $('#jmlmasuk').addClass('is-invalid');
              $('.errjmlmasuk').html(response.error.jmlmasuk);
            } else {
              $('#jmlmasuk').removeClass('is-invalid');
              $('.errjmlmasuk').html('');
            }
            if (response.error.satuan) {
              $('#satuan').addClass('is-invalid');
              $('.errsatuan').html(response.error.satuan);
            } else {
              $('#satuan').removeClass('is-invalid');
              $('.errsatuan').html('');
            }
            // if (response.error.fotobrg) {
            //   $('#fotobrg').addClass('is-invalid');
            //   $('.errfotobrg').html(response.error.fotobrg);
            // } else {
            //   $('#fotobrg').removeClass('is-invalid');
            //   $('.errfotobrg').html('');
            // }
          } else {
            formtambah.hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              databarang.ajax.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });

      return false;

    })
  });

  function detailstokbarang(id) {
    console.log(id);
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/tampildetailstokbarang",
      data: {
        sb_id: id,
      },
      dataType: "json",
      success: function(response) {
        console.log(response);
        $('.viewmodal').html(response.data).show();
        $('#modaldetail').modal('show');
      }
    });

  }

  function qrcode(id) {
    console.log(id);
  }

  function updatebarang(id) {
    console.log(id);
    // $.ajax({
    //   type: "get",
    //   url: "<?= base_url() ?>/barangcontroller/tampildetailstokbarang",
    //   data: {
    //     sb_id: id,
    //   },
    //   dataType: "json",
    //   success: function(response) {
    //     console.log(response);
    //     $('.viewmodal').html(response.data).show();
    //     $('#modaldetail').modal('show');
    //   }
    // });

  }
</script>
<?= $this->endSection() ?>