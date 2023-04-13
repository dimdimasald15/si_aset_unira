<?= $this->extend('/layouts/template'); ?>
<?= $this->section('styles') ?>
<style>
  img {
    display: block;
    max-width: 100%;
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
                  <input type="hidden" name="jenis_transaksi" id="jenistrx" value="<?= strtolower($title); ?>">
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
              <!-- <div class="col-lg-6">
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
              </div> -->
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
      <div class="col-lg-4"></div>
    </div>
    <!-- <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a> -->
  </div>
</div>
<div class="card mb-3 shadow datalist-barang">
  <div class="card-header shadow-sm shadow-sm">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-9">
        <h4 class="card-title">Data <?= $title; ?></h4>
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
      <table class="table table-bordered" id="table-stok" width="100%">
        <thead class=" thead-dark">
          <tr>
            <!-- <th style="width: 50px;">No.</th> -->
            <th>Action</th>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Jumlah Masuk</th>
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

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let formtambah = $('#tampilformtambahstok');
  let saveMethod, globalId;
  let kd_brg = '';
  let jenistrx = $('#jenistrx').val();
  let jenis_kat = 'Barang Tetap';

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

  var datastok = '';

  $(document).ready(function() {
    formtambah.hide();

    datastok = $('#table-stok').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: `barang-tetap-masuk/listdatastokbarang?jenis_kat=${jenis_kat}&isRestore=0`,
        data: function(d) {
          d.barang = $('#selectbarang').val()
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
          data: 'jumlah_masuk',
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
      url: "barang-tetap-masuk/pilihbarang",
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
      url: "barang-tetap-masuk/pilihkategori",
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

    $('#selectkategori').on('change', function(e) {
      e.preventDefault();
      datastok.ajax.reload();
    })

    $('#selectlokasi').on('change', function(e) {
      e.preventDefault();
      datastok.ajax.reload();
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
      placeholder: 'Piih Nama Barang tetap',
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
          console.log(data);
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
          console.log(data);
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
          // console.log(data);
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatResult,
    });

    $('#formTambahStok').submit(function(e) {
      e.preventDefault();
      console.log('test');
      let url = "";
      if (saveMethod == "update") {
        url = "barang-tetap-masuk/update/" + globalId;
      } else if (saveMethod == "add") {
        url = "barang-tetap-masuk/simpan";
      }

      $.ajax({
        type: "post",
        url: url,
        data: $(this).serialize(),
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
            if (response.error.satuan) {
              $('#satuan').addClass('is-invalid');
              $('.errsatuan').html(response.error.satuan);
            } else {
              $('#satuan').removeClass('is-invalid');
              $('.errsatuan').html('');
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
</script>
<?= $this->endSection() ?>