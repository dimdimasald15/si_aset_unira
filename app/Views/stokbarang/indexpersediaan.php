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
    <div class="card mb-3 shadow" id="tampilformtambahstok" style="display:none;">
      <div class="card-header shadow-sm">
        <div class="row">
          <h4 class="card-title">Tambah Data <?= $title; ?></h4>
        </div>
      </div>
      <div class="card-body mt-3">
        <form class="form form-vertical" id="formTambahStok">
          <?= csrf_field() ?>
          <div class="form-body">
            <div class="row d-flex justify-content-between">
              <div class="col-lg-12">
                <div class="col-12">
                  <input type="hidden" name="id" id="id">
                  <div class="row mb-1">
                    <label for="idbrg mb-2">Nama Barang</label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                      <select name="barang_id" class="form-select p-2" id="idbrg" style="width: 400px;"></select>
                      <div class="invalid-feedback erridbrg"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="lokasi">Lokasi Penempatan <?= $title ?></label>
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
                      <label for="" class="mb-1">Satuan <?= $title; ?></label>
                      <div class="input-group mb-3">
                        <select name="satuan_id" class="form-select p-2" id="satuan"></select>
                        <div class="invalid-feedback errsatuan"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-auto">
                      <label for="tglbeli" class="mb-1">Tanggal Pembelian <?= $title ?></label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                        <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli" name="tgl_beli">
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
  <div class="card-header shadow-sm shadow-sm">
    <h5>Custom Filter</h5>
  </div>
  <div class="card-body">
    <div class="row mt-3">
      <div class="col-lg-4 d-flex justify-content-start">
        <label class="col-sm-4 col-form-label" for="inputGroupSelect01">Barang :</label>
        <div class="col-sm-8">
          <select id="selectbarang" class="form-select"></select>
        </div>
      </div>
      <div class="col-lg-4 d-flex justify-content-start">
        <label class="col-sm-4 col-form-label" for="inputGroupSelect01">Kategori :</label>
        <div class="col-sm-8">
          <select id="selectkategori" class="form-select"></select>
        </div>
      </div>
      <div class="col-lg-4 d-flex justify-content-start">
        <label class="col-sm-4 col-form-label" for="inputGroupSelect01">Lokasi :</label>
        <div class="col-sm-8">
          <select id="selectlokasi" class="form-select"></select>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card mb-3 shadow datalist-stok">
  <div class="card-header shadow-sm shadow-sm">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-7">
        <h4 class="card-title">Data <?= $title; ?></h4>
      </div>
      <div class="col-lg-3 d-flex flex-row justify-content-end">
        <div class="col-lg-auto btn-databarang">
          <button type="button" class="btn btn-success" id="btn-tambahbarang">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
              <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"></path>
            </svg>
            Tambah Barang
          </button>
          <button type="button" class="btn btn-danger" id="btn-restore"><i class="fa fa-trash-o"></i> Trash</button>
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
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah Masuk</th>
            <th>Satuan</th>
            <th>Lokasi</th>
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
      <table class="table table-bordered" id="table-stok" width="100%">
        <thead class=" thead-dark">
          <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Jumlah Masuk</th>
            <th>Satuan</th>
            <th>Lokasi</th>
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
  let formtambah = $('#tampilformtambahstok');
  let saveMethod, globalId;
  let kd_brg = '';
  let jenistrx = '<?= strtolower($title); ?>';
  let jenis_kat = 'Barang Persediaan';
  let datastok = '';
  let datarestore = '';

  function edit(id) {
    clear_is_invalid();
    formtambah.show(500);
    saveMethod = "update";
    globalId = id;

    formtambah.find('.card-title').html('Edit Data <?= $title; ?>');
    formtambah.find("button[type='submit']").html('Perbarui');

    $.ajax({
      type: "get",
      url: "<?= site_url('stokbarangcontroller/getdatastokbarangbyid') ?>",
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
    barang_id,
    nama_brg,
    ruang_id,
    nama_ruang,
    satuan_id,
    kd_satuan,
    jumlah_masuk
  }) {
    formtambah.find("input[name='id']").val(id)
    formtambah.find("input[name='jumlah_masuk']").val(jumlah_masuk)
    formtambah.find("select[name*='barang_id']").html('<option value = "' + barang_id + '" selected >' + nama_brg + '</option>');
    formtambah.find("select[name*='ruang_id']").html('<option value = "' + ruang_id + '" selected >' + nama_ruang + '</option>');
    formtambah.find("select[name*='satuan_id']").html('<option value = "' + satuan_id + '" selected >' + kd_satuan + '</option>');

  }

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").html("")
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data <?= $title ?>');
    formtambah.find("button[type='submit']").html('Simpan');
  }

  function hapus(id, namabrg, namaruang) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namabrg} di ${namaruang}?`,
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
            nama_brg: namabrg,
            nama_ruang: namaruang
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datastok.ajax.reload();
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

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-layers"> </i>${data.text}</span>`
    );

    return $result;
  }

  $(document).ready(function() {
    formtambah.hide();

    datastok = $('#table-stok').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= $nav ?>/listdatastokbarang?jenis_kat=${jenis_kat}&isRestore=0`,
        data: function(d) {
          d.barang = $('#selectbarang').val()
          d.kategori = $('#selectkategori').val()
          d.lokasi = $('#selectlokasi').val()
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
          data: 'jumlah_masuk',
        },
        {
          data: 'kd_satuan'
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
        {
          data: 'action',
          orderable: false
        },
      ],
    });

    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihbarang",
      data: {
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        $('#selectbarang').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectbarang').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihkategori",
      data: {
        jenis_kat: jenis_kat,
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
      url: "<?= base_url() ?>/stokbarangcontroller/pilihlokasi",
      dataType: "json",
      success: function(response) {
        $('#selectlokasi').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectlokasi').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $('#selectbarang').on('change', function(e) {
      e.preventDefault();
      datastok.ajax.reload();
      datarestore.ajax.reload();
    })
    $('#selectkategori').on('change', function(e) {
      e.preventDefault();
      datastok.ajax.reload();
      datarestore.ajax.reload();
    })

    $('#selectlokasi').on('change', function(e) {
      e.preventDefault();
      datastok.ajax.reload();
      datarestore.ajax.reload();
    })

    $('#btn-tambahbarang').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      defaultform();
      clearForm();
      formtambah.show(500);
      saveMethod = "add";
    })

    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      formtambah.hide(500);
    });

    $('#idbrg').select2({
      placeholder: 'Piih Nama Barang Persediaan',
      minimumInputLength: 1,
      allowClear: true,
      width: "50%",
      ajax: {
        url: `<?= base_url() ?>/stokbarangcontroller/pilihbarang`,
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
            jenis_kat: jenis_kat,
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

    $('#idbrg').on('change', function(e) {
      e.preventDefault();
      $('#idbrg').removeClass('is-invalid');
      $('.erroridbrg').html('');
    })
    $('#lokasi').on('change', function(e) {
      e.preventDefault();
      $('#lokasi').removeClass('is-invalid');
      $('.errorlokasi').html('');
    })
    $('#satuan').on('change', function(e) {
      e.preventDefault();
      $('#satuan').removeClass('is-invalid');
      $('.errorsatuan').html('');
    })
    $('#jmlmasuk').on('keyup', function(e) {
      e.preventDefault();
      $('#jmlmasuk').removeClass('is-invalid');
      $('.errorjmlmasuk').html('');
    })

    $('#lokasi').select2({
      placeholder: 'Piih lokasi',
      minimumInputLength: 1,
      allowClear: true,
      width: "50%",
      ajax: {
        url: "<?= base_url() ?>/stokbarangcontroller/pilihlokasi",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
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

    $('#satuan').select2({
      placeholder: 'Piih Satuan',
      minimumInputLength: 1,
      allowClear: true,
      width: "resolve",
      ajax: {
        url: "<?= base_url() ?>/stokbarangcontroller/pilihsatuan",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
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

    $(document).on('change', '#idbrg, #lokasi', function() {
      var b_id = $('#formTambahStok').find('select[name="barang_id"]').val();
      var r_id = $('#formTambahStok').find('select[name="ruang_id"]').val();

      if (b_id != null && r_id != null) {
        $.ajax({
          type: "post",
          url: "<?= base_url() ?>/stokbarangcontroller/cekbrgdanruang",
          data: {
            barang_id: b_id,
            ruang_id: r_id,
          },
          dataType: "json",
          success: function(response) {
            if (response) {
              formtambah.find("input[name='id']").val(response.id);
              $('#satuan').prop('disabled', true);
              formtambah.find("select[name*='satuan_id']").html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
            }
          }
        });
      } else {
        $('#id').val('');
        $('#satuan').prop('disabled', false);
        formtambah.find("select[name*='satuan_id']").html('');
      }
    });

    $('#formTambahStok').submit(function(e) {
      e.preventDefault();

      // Cek apakah select satuan sudah terpilih atau belum
      var satuanVal = $('#satuan').val();
      if (!satuanVal) {
        $('#satuan').addClass('is-invalid');
        $('.errsatuan').html('Pilih satuan terlebih dahulu.');
        return false;
      }
      $('#satuan').prop('disabled', false);


      let url = "";
      if (saveMethod == "update") {
        url = "<?= $nav ?>/update/" + globalId;
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpan";
      }

      let formdata = new FormData(this); // mengambil data dari form
      formdata.append('jenis_transaksi', jenistrx); // menambahkan data tambahan

      $.ajax({
        type: "post",
        url: url,
        data: formdata,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Simpan');
        },
        success: function(result) {
          response = JSON.parse(result)
          if (response.error) {
            if (response.error.idbrg) {
              $('#idbrg').addClass('is-invalid');
              $('.erridbrg').html(response.error.idbrg);
            } else {
              $('#idbrg').removeClass('is-invalid');
              $('.erridbrg').html('');
            }
            if (response.error.lokasi) {
              $('#lokasi').addClass('is-invalid');
              $('.errlokasi').html(response.error.lokasi);
            } else {
              $('#lokasi').removeClass('is-invalid');
              $('.errlokasi').html('');
            }
            if (response.error.jmlmasuk) {
              $('#jmlmasuk').addClass('is-invalid');
              $('.errjmlmasuk').html(response.error.jmlmasuk);
            } else {
              $('#jmlmasuk').removeClass('is-invalid');
              $('.errjmlmasuk').html('');
            }
          } else {
            formtambah.hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              datastok.ajax.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    });

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
          url: `<?= $nav ?>/listdatastokbarang?jenis_kat=${jenis_kat}&isRestore=1`,
          data: function(d) {
            d.barang = $('#selectbarang').val()
            d.kategori = $('#selectkategori').val()
            d.lokasi = $('#selectlokasi').val()
          },
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
            data: 'jumlah_masuk',
          },
          {
            data: 'kd_satuan'
          },
          {
            data: 'nama_ruang'
          },
          {
            data: 'deleted_by'
          },
          {
            data: 'deleted_at',
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
      });
    });
  });

  function detailstokbarang(kd_brg, ruang_id) {
    const kdbrg = kd_brg.split(".").join("-");
    const loc_id = ruang_id;

    window.location.href = `<?= $nav ?>/detail-barang/${kdbrg}-${loc_id}`;
  }

  function cetaklabel(id) {
    $.ajax({
      type: "post",
      url: "<?= base_url() ?>/stokbarangcontroller/tampillabelbarang",
      data: {
        id: id,
      },
      dataType: 'json',
      success: function(response) {
        $('.viewmodal').html(response.sukses).show(500);
        $('#modallabel').modal('show');
      }
    });
  }

  function restore(id, namabrg, namaruang) {
    Swal.fire({
      title: `Memulihkan data ${namabrg} di ${namaruang}?`,
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
            nama_ruang: namaruang,
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

  function hapuspermanen(id, namabrg, namaruang) {
    Swal.fire({
      width: 700,
      title: `Menghapus data ${namabrg} di ${namaruang} secara permanen?`,
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
            nama_brg: namaruang,
            jenis_kat: jenis_kat,
            jenis_transaksi: jenistrx,
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
    var nama_ruang = api.data().toArray().map(function(d) {
      return d.nama_ruang;
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
        hapuspermanen(id.toString(), nama_brg.toString(), nama_ruang.toString());
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
              jenis_transaksi: jenistrx,
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
</script>
<?= $this->endSection() ?>