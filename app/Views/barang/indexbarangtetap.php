<?= $this->extend('/layouts/template'); ?>
<?= $this->section('styles') ?>
</head>
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
        <h3>Daftar <?= $title; ?></h3>
        <p class="text-subtitle text-muted">Kelola menu <?= strtolower($title); ?> di Universitas Islam Raden Rahmat Malang</p>
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
    <div class="card mb-3 shadow" id="tampilformtambahbarang" style="display:none;">
      <div class=" card-header shadow-sm">
        <div class="row">
          <h4 class="card-title">Tambah <?= $title; ?></h4>
        </div>
      </div>
      <div class="card-body">
        <form class="form form-vertical py-4" id="formTambahBarang">
          <?= csrf_field() ?>
          <div class="form-body">
            <div class="row d-flex justify-content-between">
              <div class="col-12">
                <input type="hidden" name="id" id="id">
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
                      <div class="invalid-feedback errskbarang"></div>
                    </div>
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
                    <label for="merk" class="form-label">Merk</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-tags"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk" name="merk">
                      <div class="invalid-feedback errmerk"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="warna" class="form-label">Warna</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-palette"></i></span>
                      <input type="color" class="form-control" placeholder="Masukkan Warna" id="warna" name="warna">
                      <div class="invalid-feedback errwarna">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-5 mb-3 asalbrg">
                    <label for="merk" class="form-label">Asal <?= $title; ?></label>
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
                      <div class="invalid-feedback errasalbrg">
                      </div>
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
                  <div class="col-md-7 mb-3 belibaru" style="display:none;">
                    <label for="toko" class="form-label">Nama Toko</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-shop"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan nama toko" id="toko" name="toko">
                      <div class="invalid-feedback errtoko"></div>
                    </div>
                  </div>
                  <div class="col-md-7 hibah" style="display:none;">
                    <label for="instansi" class="form-label">Nama Instansi</label>
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
                      <div class="invalid-feedback errhargabeli"></div>
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
                    <label for="tglbeli" class="mb-1">Tanggal Pembelian</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="dd/mm/yyyy" id="tglbeli" name="tgl_pembelian">
                      <div class="invalid-feedback errtglbeli"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- </div> -->
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

<div class="col-12 col-md-12 viewdata" style="display:none;">
</div>

<div class="card mb-3 shadow">
  <div class="card-header shadow-sm">
    <h5>Custom Filter</h5>
  </div>
  <div class="card-body">
    <div class="row py-4">
      <div class="col-lg-6 d-flex justify-content-start">
        <label class="col-sm-4 col-form-label" for="inputGroupSelect01">Kategori :</label>
        <div class="col-sm-8">
          <select id="selectkategori" class="form-select"></select>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card mb-3 shadow datalist-barang">
  <div class="card-header shadow-sm">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-7">
        <h4 class="card-title">Data <?= $title; ?></h4>
      </div>
      <div class="col-lg-5 d-flex flex-row justify-content-end">
        <div class="col-lg-auto d-flex flex-row justify-content-end">
          <div class="col-lg-auto btn-databarang">
            <div class="btn-group">
              <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                Input <?= $title; ?>
              </button>
              <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" id="btn-tambahbarang"><i class="fa fa-plus-square"></i> Tambah Barang
                  </a>
                </li>
                <li><a class="dropdown-item" onclick="multipleinsert()"><i class="fa fa-file-text"></i> Input Multiple</a>
                </li>
              </ul>
            </div>
            <button type="button" class="btn btn-danger" id="btn-restore"><i class="fa fa-trash-o"></i> Trash</button>
          </div>
        </div>
        <div class="col-lg-auto btn-datarestorebarang" style="display:none;">
          <button class="btn btn-success" onclick="restoreall()"><i class="fa fa-undo"></i> Pulihkan semua</button>
          <button class="btn btn-danger" onclick="hapuspermanenall()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body table-restore" style="display:none;">
    <div class="table-responsive py-4">
      <table class="table table-bordered mb-3" id="table-restore" width="100%">
        <thead class=" thead-dark">
          <tr>
            <!-- <th style="width: 50px;">No.</th> -->
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Deleted By</th>
            <th>Deleted At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-body table-barang">
    <div class="table-responsive py-4">
      <table class="table table-bordered mb-3" id="table-barang" width="100%">
        <thead class=" thead-dark">
          <tr>
            <!-- <th style="width: 50px;">No.</th> -->
            <th>No.</th>
            <!-- <th>Qr Code</th> -->
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Beli</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row m-2 btn-datarestorebarang" style="display:none;">
    <a href="<?= $nav ?>">&laquo; Kembali ke data <?= strtolower($title); ?></a>
  </div>
</div>

<div class="viewmodal" style="display:none;"></div>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>

<script>
  let formtambah = $('#tampilformtambahbarang');
  let saveMethod, globalId;
  let jenis_kat = "<?= $title ?>";
  var databarang = '';
  var datarestore = '';
  let kd_brg = '';
  var kdbrgother = '';
  let asalbrg1 = $('#belibaru').val();
  let asalbrg2 = $('#belibekas').val();
  let asalbrg3 = $('#hibah').val();

  function hapus(id, namabrg) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namabrg}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus saja!',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= $nav ?>/hapus/" + id,
          data: {
            nama_brg: namabrg
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                databarang.ajax.reload();
              })
            } else if (response.error) {
              Swal.fire(
                'Gagal!',
                response.error,
                'error'
              );
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function edit(id) {
    clear_is_invalid();
    formtambah.show(500);
    saveMethod = "update";
    globalId = id;

    formtambah.find('.card-title').html('Edit Data <?= $title ?>');
    formtambah.find("button[type='submit']").html('Perbarui');

    $.ajax({
      type: "get",
      url: "<?= site_url('barangcontroller/getbarangbyany') ?>",
      data: {
        id: id,
      },
      dataType: "json",
      success: function(response) {
        isiForm(response);
      }
    });
  }

  function isiForm({
    id,
    kat_id,
    kd_kategori,
    nama_kategori,
    kode_brg,
    nama_brg,
    warna,
    merk,
    toko,
    instansi,
    asal,
    no_dokumen,
    no_seri,
    harga_beli,
    harga_jual,
    tgl_pembelian,

  }) {
    if (!$.isEmptyObject(kd_kategori)) {
      formtambah.find("input[name='id']").val(id)
      formtambah.find("select[name*='kat_id']").html('<option value = "' + kat_id + '" selected >' + nama_kategori + '</option>');
      formtambah.find("#subkdkategori").val(kd_kategori)

      kd_brg = kode_brg;

      var kode_brg_split = kode_brg.split(kd_kategori + "."); // split kode_brg berdasarkan kd_kategori
      var last_kode_brg = kode_brg_split[kode_brg_split.length - 1]; // ambil array index terakhir
      var last_3_digit = last_kode_brg.substring(last_kode_brg.length - 3); // ambil 3 angka paling belakang

      getsubkdotherbarang(kat_id);
      getsubkdbarang(kat_id, last_3_digit);
      hideskbrgother()
    }
    // else {
    formtambah.find("input[name='nama_brg']").val(nama_brg)
    formtambah.find("input[name='warna']").val(warna)
    formtambah.find("input[name='merk']").val(merk)
    formtambah.find("input[name='toko']").val(toko)
    formtambah.find("input[name='instansi']").val(instansi)
    formtambah.find("input[name='no_seri']").val(no_seri)
    formtambah.find("input[name='no_dokumen']").val(no_dokumen)
    formtambah.find("input[name='harga_beli']").val(harga_beli)
    formtambah.find("input[name='harga_jual']").val(harga_jual)

    let inputtglbeli = '';
    if (tgl_pembelian !== null) {
      inputtglbeli = tgl_pembelian;
      inputtglbeli = inputtglbeli.split(" ")[0]; // ambil tanggal saja
    } else {
      inputtglbeli = tgl_pembelian;
    }
    formtambah.find("input[name='tgl_pembelian']").val(inputtglbeli);

    if (asal === 'Beli baru') {
      $('#belibaru').prop('checked', true);
      $('.belibaru').show();
      $('.hibah').hide();
      $('.radiobelibekas').hide();
    } else if (asal == 'Beli bekas') {
      $('#belibekas').prop('checked', true);
      $('.radiobelibekas').hide();
      // $('.radiobelibekas').show();
      if (toko == null) {
        $('.belibaru').hide();
        $('.hibah').show();
      } else if (instansi == null) {
        $('.belibaru').show();
        $('.hibah').hide();
      }
    } else if (asal == 'Hibah') {
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
    // }
  }

  function hideskbrgother() {
    $('#skbarang-other').hide();
  }

  function clearForm() {
    formtambah.find("#warna").val('#000000');
    formtambah.find("input").val("")
    formtambah.find("select").html("")
    formtambah.find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();
    $('.radiobelibekas').hide();
    hideskbrgother()
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah <?= $title; ?>');
    formtambah.find("button[type='submit']").html('Simpan');
  }

  function getsubkdbarang(idkategori, kode1) {
    $.ajax({
      url: "<?= site_url('barangcontroller/getsubkdbarang') ?>",
      type: "POST",
      data: {
        katid: idkategori,
      },
      dataType: "json",
      success: function(response) {
        $('#skbarang').empty();
        $('#skbarang').append('<option value="">Sub-Kode Barang</option>');
        if (response.subkdbarang == undefined) {
          $('#subkdkategori').val(response[0].kd_kategori);
          // $('#skbarang').append('<option value="">Sub-Kode Barang</option>');
          // $('#skbarang').append('<option value="otherbrg">Lainnya</option>');
        }
        if (response[0].subkdbarang !== undefined) {
          $('#subkdkategori').val(response[0].kd_kategori);
          $.each(response, function(key, value) {
            $('#skbarang').append('<option value="' + value.subkdbarang + '">' + value.subkdbarang + '</option>');
          });
        }

        $('#skbarang').append('<option value="otherbrg">Lainnya</option>');
        if (kode1 !== undefined) {
          $("#skbarang option").each(function() {
            if ($(this).val() === kode1) {
              $(this).attr("selected", "selected");
            }
          });
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function getsubkdotherbarang(idkategori) {
    if (idkategori !== null) {
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>/barangcontroller/getkdbrgbykdkat",
        data: {
          katid: idkategori,
        },
        dataType: "json",
        success: function(response) {
          kdbrgother = response.subkdbrgother;
        }
      });
    }
  }

  function clearformwithtrigger() {
    formtambah.find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();

    formtambah.find("input[name='nama_brg']").val('');
    formtambah.find("input[name='harga_beli']").val('');
    formtambah.find("input[name='harga_jual']").val('');
    formtambah.find("#warna").val('#000000');
    formtambah.find("input[name='merk']").val('');
    formtambah.find("input[name='toko']").val('');
    formtambah.find("input[name='instansi']").val('');
    formtambah.find("input[name='no_seri']").val('');
    formtambah.find("input[name='no_dokumen']").val('');
    formtambah.find("input[name='tgl_pembelian']").val('');
  }

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-layers"> </i>${data.text}</span>`
    );

    return $result;
  }

  // function imgQR(qrCanvas, centerImage, factor) {
  //   var h = qrCanvas.height;
  //   //center size
  //   var cs = h * factor;
  //   // Center offset
  //   var co = (h - cs) / 2;
  //   var ctx = qrCanvas.getContext("2d");
  //   ctx.drawImage(centerImage, 0, 0, centerImage.width, centerImage.height, co, co, cs, cs + 10);
  //   ctx.strokeStyle = "#ffffff";
  //   ctx.lineWidth = 2 // ketebalan garis tepi 2 piksel
  //   ctx.strokeRect(co, co, cs, cs + 10); // membuat garis tepi persegi panjang di sekitar gambar
  // }
  var katid = '';

  $(document).ready(function() {
    formtambah.hide();

    databarang = $('#table-barang').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= $nav ?>/listdatabarang?jenis_kat=${jenis_kat}&isRestore=0`,
        data: function(d) {
          d.kategori = $('#selectkategori').val()
        },
        dataSrc: function(json) {
          json.data.forEach(function(item) {
            item.id = item.id;
          });
          return json.data;
        }
      },
      order: [],
      columns: [{
          data: 'no',
          orderable: false,
        },
        // {
        //   data: null,
        //   render: function(data, type, row) {
        //     return '<div id="qrcode-' + row.id + '"></div>';
        //   }
        // },
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
          data: 'harga_beli',
          render: function(data, type, row) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
          }
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
        {
          data: 'action',
          orderable: false
        },
      ],
      // drawCallback: function(settings) {
      //   var api = this.api();
      //   api.rows().every(function(rowIdx, tableLoop, rowLoop) {
      //     var rowData = this.data();
      //     var id = rowData.id;
      //     var kodebarang = rowData.kode_brg;
      //     const kdbrg = kodebarang.split(".").join("-");
      //     const logo = "<?= base_url('assets/images/logo/logounira.jpg') ?>";

      //     const icon = new Image();
      //     icon.onload = function() {
      //       // create qr code with logo
      //       var qrcode = new QRCode(document.getElementById('qrcode-' + id), {
      //         text: `<?= base_url() ?>/public/detail-barang/${kdbrg}`,
      //         width: 200,
      //         height: 200,
      //         correctLevel: QRCode.CorrectLevel.H,
      //         colorDark: "#000000",
      //         colorLight: "#ffffff",
      //       });
      //       imgQR(qrcode._oDrawing._elCanvas, this, 0.2);
      //     }
      //     icon.src = logo;
      //   });
      // }
    });

    $('#btn-tambahbarang').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      defaultform();
      clearForm();
      $('.viewdata').hide();
      $('#belibaru').val(asalbrg1);
      $('#belibekas').val(asalbrg2);
      $('#hibah').val(asalbrg3);
      formtambah.show(500);
      saveMethod = "add";
    })

    $('#btn-restore').on('click', function() {
      $('.table-barang').hide();
      $('.table-restore').show();
      $('.datalist-barang h4').html('Restore Data <?= $title; ?>');
      formtambah.hide();
      $('.btn-databarang').hide();
      $('.btn-datarestorebarang').show();
      datarestore = $('#table-restore').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: `<?= $nav ?>/tampildatarestore?jenis_kat=${jenis_kat}&isRestore=1`,
          data: function(d) {
            d.kategori = $('#selectkategori').val()
          }
        },
        order: [],
        columns: [{
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
            data: 'harga_beli',
            render: function(data, type, row) {
              return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
            }
          },
          {
            data: 'deleted_by'
          },
          {
            data: 'deleted_at',
            render: function(data, type, full, meta) {
              if (data !== null) {
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
            }
          },
          {
            data: 'action',
            orderable: false
          },
        ]
      });
    });

    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/pilihkategori",
      data: {
        jenis_kat: '<?= $title; ?>',
      },
      dataType: "json",
      success: function(response) {
        $('#selectkategori').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectkategori').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $('#selectkategori').on('change', function(e) {
      e.preventDefault();
      databarang.ajax.reload();
      datarestore.ajax.reload();
    })

    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      formtambah.hide(500);
    });

    $('#katid').select2({
      placeholder: 'Piih Nama Kategori <?= $title; ?>',
      minimumInputLength: 1,
      allowClear: true,
      width: "50%",
      initSelection: function(element, callback) {
        callback({
          id: '',
          text: ''
        });
      },
      ajax: {
        url: `<?= $nav ?>/pilihkategori`,
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
            jenis_kat: '<?= $title; ?>',
          }
        },
        processResults: function(data, page) {
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatResult,
    });

    $('#katid').on('change', function(e) {
      e.preventDefault();
      katid = $(this).val();
      if (katid == null) {
        kd_brg = '';
        clearForm();
      } else {
        getsubkdotherbarang(katid);
        getsubkdbarang(katid);
      }
      $('#katid').removeClass('is-invalid');
      $('.errkdkatid').html('');
      hideskbrgother()
    })

    $('#skbarang').on('change', function(e) {
      e.preventDefault();
      if ($(this).val() == '') {
        clearformwithtrigger();
        hideskbrgother();
      } else if ($('#skbarang').val() == 'otherbrg') {
        clearformwithtrigger();
        $('#skbarang-other').show();
        $('#skbarang-other').val(kdbrgother);
        kd_brg = `${$('#subkdkategori').val()}.${$('#skbarang-other').val()}`;
      } else {
        clearformwithtrigger();
        kd_brg = `${$('#subkdkategori').val()}.${$('#skbarang').val()}`
        hideskbrgother()

        $.ajax({
          type: "post",
          url: "<?= base_url() ?>" + '/barangcontroller/getbarangbyany',
          data: {
            kode_brg: kd_brg,
          },
          dataType: "json",
          success: function(response) {
            isiForm(response)
          }
        });
      }
      $('#skbarang').removeClass('is-invalid');
      $('.errskbarang').html('');
    })

    $('input[type="radio"]').click(function() {
      if ($(this).attr('id') == 'belibaru') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
        formtambah.find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'belibekas') {
        $('.radiobelibekas').show();
        $('.belibaru').hide();
        $('.hibah').hide();
        formtambah.find("input[name='toko']").val('')
        formtambah.find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'hibah') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
        formtambah.find("input[name='toko']").val('')
      } else if ($(this).attr('id') == 'radiotoko') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
        $('#radioinstansi').prop('checked', false);
        formtambah.find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'radioinstansi') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
        $('#radiotoko').prop('checked', false);
        formtambah.find("input[name='toko']").val('')
      } else {
        $('.radiobelibekas').hide();
        $('.belibaru').hide();
        $('.hibah').hide();
      }

      $(".asalbrg .form-check-input").removeClass("is-invalid");
      $(".errasalbrg").html('');
    });

    $('#formTambahBarang').submit(function(e) {
      e.preventDefault();
      let url = "";
      if (saveMethod == "update") {
        url = "<?= $nav ?>/update/" + globalId;
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpan";
      }
      var kode_brg = kd_brg;

      var formdata = new FormData(this);
      if ($("input[name='asal']:checked").length > 0) {
        var asal = $("input[name='asal']:checked").val();
      } else {
        var asal = '';
      }

      // console.log((katid == '') ? true : false);
      // formdata.append('kat_id', katid);
      formdata.append('kode_brg', kode_brg);
      formdata.append('asal', asal);

      $.ajax({
        type: "post",
        url: url,
        data: formdata,
        processData: false,
        contentType: false,
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Simpan');
        },
        success: function(result) {
          var response = JSON.parse(result);
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
            if (response.error.asal) {
              $(".asalbrg .form-check-input").addClass("is-invalid");
              $(".errasalbrg").html(response.error.asal); // menampilkan error message
            } else {
              $(".asalbrg .form-check-input").removeClass("is-invalid");
              $(".errasalbrg").html(''); // menampilkan error message

            }
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

  // function detailbarang(kd_brg) {
  //   const kdbrg = kd_brg.split(".").join("-");

  //   window.location.href = `<?= $nav ?>/detail-barang/${kdbrg}`;
  // }

  function detailbarang(id) {
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/tampildetailbarang",
      data: {
        id: id,
      },
      dataType: "json",
      success: function(response) {
        $('.viewmodal').html(response.data).show();
        $('#modaldetail').modal('show');
      }
    });
  }

  function upload(id, nama_brg) {
    $.ajax({
      type: "post",
      url: "<?= base_url() ?>/barangcontroller/tampilcardupload",
      data: {
        id: id,
        nama_brg: nama_brg,
      },
      dataType: "json",
      success: function(response) {
        formtambah.hide();
        $('.viewdata').html(response.sukses).show(500);
      }
    });
  }

  function restore(id, namabrg) {
    Swal.fire({
      title: `Memulihkan data ${namabrg}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= $nav ?>/restore/" + id,
          data: {
            nama_brg: namabrg,
            jenis_kat: jenis_kat,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestore.ajax.reload();
              })
            } else if (response.error) {
              Swal.fire(
                'Gagal!',
                response.error,
                'error'
              );
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function restoreall() {
    var api = $('#table-restore').DataTable().rows();
    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title); ?> yang dapat dipulihkan',
        'error'
      );
    } else {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data <?= $title ?> yang telah terhapus?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "<?= $nav ?>/restore",
            data: {
              jenis_kat: jenis_kat,
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  location.reload();
                })
              } else if (response.error) {
                Swal.fire(
                  'Gagal!',
                  response.error,
                  'error'
                );
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        }
      });
    }

  }

  function hapuspermanen(id, namabrg) {
    Swal.fire({
      width: 700,
      title: `Menghapus data ${namabrg} secara permanen?`,
      icon: 'warning',
      text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= $nav ?>/hapuspermanen",
          data: {
            id: id,
            nama_brg: namabrg,
            jenis_kat: jenis_kat,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestore.ajax.reload();
              })
            } else if (response.error) {
              Swal.fire(
                'Gagal!',
                response.error,
                'error'
              );
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function hapuspermanenall() {
    var api = $('#table-restore').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var nama_brg = api.data().toArray().map(function(d) {
      return d.nama_brg;
    })

    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title); ?> yang dapat dihapus secara permanen',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data <?= strtolower($title); ?> secara permanen?`,
        icon: 'warning',
        text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        hapuspermanen(id.toString(), nama_brg.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data <?= strtolower($title); ?> secara permanen?`,
        icon: 'warning',
        text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "<?= $nav ?>/hapuspermanen",
            data: {
              id: id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  datarestore.ajax.reload();
                })
              } else if (response.error) {
                Swal.fire(
                  'Gagal!',
                  response.error,
                  'error'
                );
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        }
      });
    }
  }

  function multipleinsert() {
    $.ajax({
      url: "<?= base_url() ?>/barangcontroller/tampilMultipleInsert",
      data: {
        jenis_kat: jenis_kat,
        nav: "<?= $nav ?>",
      },
      dataType: "json",
      success: function(response) {
        formtambah.hide(500);
        $('.viewdata').html(response.data).show(500);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  // function cetaklabel(id) {
  //   $.ajax({
  //     type: "post",
  //     url: "<?= base_url() ?>/barangcontroller/tampillabelbarang",
  //     data: {
  //       id: id,
  //       jenis_kat: jenis_kat,
  //     },
  //     dataType: 'json',
  //     success: function(response) {
  //       $('.viewmodal').html(response.sukses).show(500);
  //       $('#modallabel').modal('show');
  //     }
  //   });
  // }
</script>
<?= $this->endSection() ?>