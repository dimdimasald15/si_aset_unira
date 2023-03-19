<?= $this->extend('/layouts/template'); ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar Kategori</h3>
        <p class="text-subtitle text-muted">Kelola menu kategori di Universitas Islam Raden Rahmat Malang</p>
      </div>
      <div class="col-12 col-md-4 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Kategori</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card mb-3" id="tampilformtambahkategori" style="display:none">
      <div class="card-header">
        <div class="row">
          <h4 class="card-title">Tambah Data Kategori</h4>
        </div>
      </div>
      <div class="card-body">
        <form class="form form-vertical" id="formTambahKategori">
          <?= csrf_field() ?>
          <div class="form-body">
            <div class="row">
              <div class="col-12">
                <input type="hidden" name="id" id="id">
                <div class="row mb-1">
                  <label for="kd_kat">Kode Kategori</label>
                </div>
                <div class="row mb-1">
                  <div class="col-md-3 position-relative">
                    <div class="input-group has-validation">
                      <span class="input-group-text p-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-circle" viewBox="0 0 16 16">
                          <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
                        </svg></span>
                      <select class="form-select" id="subkode1"></select>
                      <input type="text" class="form-control" placeholder="opsi lain" id="subkode1-other" style="display: none;">
                      <div class="invalid-feedback errsk1"></div>
                    </div>
                  </div>
                  <div class="col-md-3 position-relative">
                    <div class="input-group has-validation">
                      <span class="input-group-text p-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-circle" viewBox="0 0 16 16">
                          <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
                        </svg></span>
                      <select class="form-select" id="subkode2"></select>
                      <input type="text" class="form-control" placeholder="opsi lain" id="subkode2-other" style="display: none;">
                      <div class="invalid-feedback errsk2"></div>
                    </div>
                  </div>
                  <div class="col-md-3 position-relative">
                    <div class="input-group has-validation">
                      <span class="input-group-text p-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-circle" viewBox="0 0 16 16">
                          <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
                        </svg></span>
                      <select class="form-select" id="subkode3"></select>
                      <input type="text" class="form-control" placeholder="opsi lain" id="subkode3-other" style="display: none;">
                      <div class="invalid-feedback errsk3"></div>
                    </div>
                  </div>
                  <div class="col-md-3 position-relative">
                    <div class="input-group has-validation">
                      <span class="input-group-text p-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-circle" viewBox="0 0 16 16">
                          <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8Zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z" />
                        </svg></span>
                      <select class="form-select" id="subkode4"></select>
                      <input type="text" class="form-control" placeholder="opsi lain" id="subkode4-other" style="display: none;">
                      <div class="invalid-feedback errsk4"></div>
                    </div>
                  </div>

                </div>
                <div class="input-group col-md-4 mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-code-square"></i></span>
                  <input type="text" class="form-control" placeholder="Kode Kategori" id="kd_kategori" name="kd_kategori" readonly>
                  <div class="invalid-feedback errkdkat"></div>
                </div>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="namakategori">Nama Kategori</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                    <input type="text" class="form-control" placeholder="Nama Kategori" id="namakategori" name="nama_kategori">
                    <div class="invalid-feedback errnamakategori"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="deskripsi">Deskripsi</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" name="deskripsi"></textarea>
                    <div class="invalid-feedback errdeskripsi"></div>
                  </div>
                </div>
              </div>
              <div class="col-12 d-flex justify-content-end">
                <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
                <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<div class="card mb-3 datalist-kategori">
  <div class="card-header">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-9">
        <h4 class="card-title">Data Kategori</h4>
      </div>
      <div class="col-lg-3 d-flex flex-row-reverse">
        <button type="button" class="btn btn-success" id="btn-tambahkategori">
          <i class="bi bi-layers"></i>
          Tambah Kategori
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive py-4">
      <table class="table table-flush" id="table-kategori" width="100%">
        <thead class=" thead-light">
          <tr>
            <th>No.</th>
            <th>Kode Kategori</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Created By</th>
            <th>Created At </th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let formtambah = $('#tampilformtambahkategori');
  let saveMethod, globalId;
  const slctkd_kat = $('#kd_kategori');
  const slctnmkat = $('#namakategori');
  const slctSubkode1 = $('#subkode1');
  const slctSubkode2 = $('#subkode2');
  const slctSubkode3 = $('#subkode3');
  const slctSubkode4 = $('#subkode4');
  const slctSubkode1other = $('#subkode1-other');
  const slctSubkode2other = $('#subkode2-other');
  const slctSubkode3other = $('#subkode3-other');
  const slctSubkode4other = $('#subkode4-other');

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").empty()
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
    }
  }

  function inputnamakategori(subkd1, subkd2, subkd3, subkd4) {
    // periksa apakah nilai undefined
    subkd1 = (typeof subkd1 !== 'undefined' && subkd1 !== 'other1') ? subkd1 : '';
    subkd2 = (typeof subkd2 !== 'undefined' && subkd2 !== 'other2') ? subkd2 : '';
    subkd3 = (typeof subkd3 !== 'undefined' && subkd3 !== 'other3') ? subkd3 : '';
    subkd4 = (typeof subkd4 !== 'undefined' && subkd4 !== 'other4') ? subkd4 : '';

    $.ajax({
      type: "post",
      url: "kategori/getnamakategori",
      data: {
        subkode1: subkd1,
        subkode2: subkd2,
        subkode3: subkd3,
        subkode4: subkd4,
      },
      dataType: "json",
      success: function(response) {
        if (response != null) {
          slctnmkat.val(response.nama_kategori)
          $('#deskripsi').val(response.deskripsi)
        } else {
          slctnmkat.val('')
          $('#deskripsi').val('')
        }
      }
    });
  }

  function getsubkodeother(skother1, skother2, skother3, skother4) {
    var subkd1other = (typeof skother1 !== 'undefined') ? skother1 : '';
    var subkd2other = (typeof skother2 !== 'undefined') ? skother2 : '';
    var subkd3other = (typeof skother3 !== 'undefined') ? skother3 : '';
    var subkd4other = (typeof skother4 !== 'undefined') ? skother3 : '';

    if (subkd2other == '' && subkd3other == '' && subkd4other == '') {
      slctkd_kat.val(`${subkd1other}`)
    } else if (subkd3other == '' && subkd4other == '') {
      slctkd_kat.val(`${subkd1other}.${subkd2other}`)
    } else if (subkd4other == '') {
      slctkd_kat.val(`${subkd1other}.${subkd2other}.${subkd3other}`)
    } else {
      slctkd_kat.val(`${subkd1other}.${subkd2other}.${subkd3other}.${subkd4other}`)
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data Ruangan');
    formtambah.find("button[type='submit']").html('Simpan');
    slctSubkode1other.hide();
    slctSubkode2other.hide();
    slctSubkode3other.hide();
    slctSubkode4other.hide();
  }

  $('.batal-form').click(function(e) {
    e.preventDefault();
    clear_is_invalid();
    defaultform()
    clearForm();
    formtambah.hide(500);
  });

  function getsubkode1(kode1) {
    console.log(kode1);
    $.ajax({
      url: "<?= site_url('kategoricontroller/getsubkode1') ?>",
      type: "GET",
      dataType: "json",
      success: function(result) {
        slctSubkode1.empty();
        slctSubkode1.append('<option value="">SubKode 1</option>');
        $.each(result, function(key, value) {
          slctSubkode1.append('<option value="' + value.kode + '">' + value.kode + '</option>');
        });
        slctSubkode1.append('<option value="other1">Lainnya</option>');

        if (kode1 !== undefined) {
          $("#subkode1 option").each(function() {
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

  function getsubkode2(subkode1, kode2) {
    $.ajax({
      type: "post",
      url: "<?= site_url('kategoricontroller/getsubkode2') ?>",
      data: {
        subkode1: subkode1,
      },
      dataType: "json",
      success: function(result) {
        slctSubkode2.empty();
        slctSubkode2.append('<option value="">SubKode 2</option>');
        $.each(result, function(key, value) {
          slctSubkode2.append('<option value="' + value.subkode2 + '">' + value.subkode2 + '</option>');
        });
        slctSubkode2.append('<option value="other2">Lainnya</option>');
        if (kode2 !== undefined) {
          $("#subkode2 option").each(function() {
            if ($(this).val() === kode2) {
              $(this).attr("selected", "selected");
            }
          });
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function getsubkode3(subkode1, subkode2, kode3) {
    $.ajax({
      type: "post",
      url: "<?= site_url('kategoricontroller/getsubkode3') ?>",
      data: {
        subkode1: subkode1,
        subkode2: subkode2,
      },
      dataType: "json",
      success: function(result) {
        slctSubkode3.empty();
        slctSubkode3.append('<option value="">SubKode 3</option>');
        for (var i = 0; i < result.length; i++) {
          if (result[i].subkode3 != '') {
            slctSubkode3.append('<option value="' + result[i].subkode3 + '">' + result[i].subkode3 + '</option>');
          }
        }

        slctSubkode3.append('<option value="other3">Lainnya</option>');

        if (kode3 !== undefined) {
          $("#subkode3 option").each(function() {
            if ($(this).val() === kode3) {
              $(this).attr("selected", "selected");
            }
          });
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function getsubkode4(subkode1, subkode2, subkode3, kode4) {
    $.ajax({
      type: "post",
      url: "<?= site_url('kategoricontroller/getsubkode4') ?>",
      data: {
        subkode1: subkode1,
        subkode2: subkode2,
        subkode3: subkode3,
      },
      dataType: "json",
      success: function(result) {
        slctSubkode4.empty();
        slctSubkode4.append('<option value="">SubKode 4</option>');
        $.each(result, function(key, value) {
          slctSubkode4.append('<option value="' + value.subkode4 + '">' + value.subkode4 + '</option>');
        });
        slctSubkode4.append('<option value="other4">Lainnya</option>');

        if (kode4 !== undefined) {
          $("#subkode4 option").each(function() {
            if ($(this).val() === kode4) {
              $(this).attr("selected", "selected");
            }
          });
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    formtambah.hide();
    var datakategori = $('#table-kategori').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'kategori/listdatakategori',
      },
      order: [],
      columns: [{
          data: 'no',
          orderable: false
        },
        {
          data: 'kd_kategori'
        },
        {
          data: 'nama_kategori'
        },
        {
          data: 'deskripsi'
        },
        {
          data: 'created_by'
        },
        {
          data: 'created_at'
        },
        {
          data: 'action',
          orderable: false
        },
      ]
    });


    let subkode1, subkode2, subkode3, subkode4;


    $('#btn-tambahkategori').click(function(e) {
      e.preventDefault();
      // clear_is_invalid();
      defaultform();
      clearForm();
      formtambah.show(500);
      saveMethod = "add";

      getsubkode1();
    })


    slctSubkode1.on('change', function() {
      subkode1 = slctSubkode1.val();
      if (subkode1 === 'other1') {
        slctSubkode1other.show();
        slctSubkode1other.on('keyup', function() {
          validateInputOther(slctSubkode1, slctSubkode1other)
          getsubkodeother(slctSubkode1other.val());
          if (slctSubkode1other.val() == '') {
            slctSubkode1other.removeClass('is-invalid');
            slctSubkode1other.next().html('');
          }
        });
      } else {
        slctSubkode1other.hide();
        getsubkodeother(subkode1);
      }

      inputnamakategori(subkode1);

      getsubkode2(subkode1);
    });

    slctSubkode2.on('change', function() {
      subkode2 = slctSubkode2.val();
      if (subkode2 === 'other2') {
        slctSubkode2other.show();
        slctnmkat.val('');
        $('#deskripsi').val('');
        slctSubkode2other.on('keyup', function() {
          validateInputOther(slctSubkode2, slctSubkode2other)
          getsubkodeother(slctSubkode2other.val());
          if (slctSubkode2other.val() == '') {
            slctSubkode2other.removeClass('is-invalid');
            slctSubkode2other.next().html('');
          }
          if (subkode1 !== 'other1') {
            getsubkodeother(subkode1, slctSubkode2other.val());
          } else {
            getsubkodeother(slctSubkode1other.val(), slctSubkode2other.val());
          }
        });
      } else {
        slctSubkode2other.hide();
        getsubkodeother(subkode1, subkode2);
        inputnamakategori(subkode1, subkode2);
      }

      getsubkode3(subkode1, subkode2);
    });

    slctSubkode3.on('change', function() {
      subkode3 = slctSubkode3.val();

      if (subkode3 === 'other3') {
        slctSubkode3other.show(); // menampilkan form input
        slctnmkat.val('');
        $('#deskripsi').val('');
        slctSubkode3other.on('keyup', function() {
          validateInputOther(slctSubkode3, slctSubkode3other)
          getsubkodeother(slctSubkode3other.val());
          if (slctSubkode3other.val() == '') {
            slctSubkode3other.removeClass('is-invalid');
            slctSubkode3other.next().html('');
          }
          if (subkode1 !== 'other1' && subkode2 !== 'other2') {
            getsubkodeother(subkode1, subkode2, slctSubkode3other.val());
          } else if (subkode1 !== 'other1' && subkode2 == 'other2') {
            getsubkodeother(subkode1, slctSubkode2other.val(), slctSubkode3other.val());
          } else {
            getsubkodeother(slctSubkode1other.val(), slctSubkode2other.val(), slctSubkode3other.val());
          }
        });
      } else {
        slctSubkode3other.hide(); // menyembunyikan form input
        getsubkodeother(subkode1, subkode2, subkode3);
        inputnamakategori(subkode1, subkode2, subkode3);
      }

      getsubkode4(subkode1, subkode2, subkode3);
    });

    slctSubkode4.on('change', function() {
      subkode4 = slctSubkode4.val();
      if (subkode4 === 'other4') {
        slctSubkode4other.show();
        slctnmkat.val('');
        $('#deskripsi').val('');
        slctSubkode4other.on('keyup', function() {
          if (subkode1 !== 'other1' && subkode2 !== 'other2' && subkode3 !== 'other3') {
            getsubkodeother(subkode1, subkode2, subkode3, slctSubkode4other.val());
          } else if (subkode1 !== 'other1' && subkode2 !== 'other2', subkode3 == 'other3') {
            getsubkodeother(subkode1, subkode2, slctSubkode3other.val(), slctSubkode4other.val());
          } else if (subkode1 !== 'other1' && subkode2 == 'other2', subkode3 == 'other3') {
            getsubkodeother(subkode1, slctSubkode2other.val(), slctSubkode3other.val(), slctSubkode4other.val());
          } else {
            getsubkodeother(slctSubkode1other.val(), slctSubkode2other.val(), slctSubkode3other.val(), slctSubkode4other.val());
          }
        });
      } else {
        slctSubkode4other.hide(); // menyembunyikan form input
        getsubkodeother(subkode1, subkode2, subkode3, subkode4);
        inputnamakategori(subkode1, subkode2, subkode3, subkode4);
      }
    });

    $('#formTambahKategori').submit(function(e) {
      e.preventDefault();
      let url = "";
      if (saveMethod == "update") {
        url = "kategori/update/" + globalId;
      } else if (saveMethod == "add") {
        url = "kategori/simpan";
      }
      $.ajax({
        type: 'post',
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
          if (response.error) {
            if (response.error.kdkat) {
              slctkd_kat.addClass('is-invalid');
              $('.errkdkat').html(response.error.kdkat);
            } else {
              slctkd_kat.removeClass('is-invalid');
              $('.errkdkat').html('');
            }
            if (response.error.nama_kategori) {
              slctnmkat.addClass('is-invalid');
              $('.errnamakategori').html(response.error.nama_kategori);
            } else {
              slctnmkat.removeClass('is-invalid');
              $('.errnamakategori').html('');
            }
          } else {
            formtambah.hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              datakategori.ajax.reload();
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

  function validateInputOther(skd, skdother) {
    const skdothervalue = skdother.val();
    // Mendapatkan opsi-opsi pada select #subkode2
    const skdoption = skd.find('option');

    // Memeriksa apakah nilai yang dimasukkan pengguna sudah ada pada opsi select #subkode2
    for (let i = 0; i < skdoption.length; i++) {
      const subkodeOption = $(skdoption[i]);
      if (subkodeOption.val() === skdothervalue) {
        // Jika nilai sudah ada, munculkan peringatan error pada input text #subkode2-other
        skdother.addClass('is-invalid');
        skdother.next().html(`${$(skdoption[0]).text()} sudah ada`);
        return;
      }
    }
    // Jika nilai belum ada, hapus peringatan error pada input text #subkode2-other
    skdother.removeClass('is-invalid');
    skdother.next().html('');
  }

  function edit(id) {
    // console.log(id)
    clear_is_invalid();
    formtambah.show(500);
    saveMethod = "update";
    globalId = id;

    formtambah.find('.card-title').html('Edit Data Kategori');
    formtambah.find("button[type='submit']").html('Perbarui');

    $.ajax({
      type: "get",
      url: "<?= site_url('kategoricontroller/get_kategori_by_id/') ?>" + id,
      dataType: "json",
      success: function(response) {
        console.log(response);
        isiForm(response);
      }
    });
  }

  function isiForm({
    id,
    kd_kategori,
    nama_kategori,
    deskripsi
  }) {
    var kode = kd_kategori; // kode yang akan dipisahkan
    var subkode = kode.split('.'); // memisahkan kode dengan tanda titik

    var kode1 = subkode[0]; // mendapatkan subkode 1
    var kode2 = subkode[1]; // mendapatkan subkode 2
    var kode3 = subkode[2]; // mendapatkan subkode 3
    var kode4 = subkode[3]; // mendapatkan subkode 4

    console.log(`${kode1} + ${kode2} + ${kode3} + ${kode4}`);

    getsubkode1(kode1);
    getsubkode2(kode1, kode2);
    getsubkode3(kode1, kode2, kode3);
    getsubkode4(kode1, kode2, kode3, kode4);

    formtambah.find("input[name='id']").val(id)
    formtambah.find("input[name='kd_kategori']").val(kd_kategori)
    formtambah.find("input[name='nama_kategori']").val(nama_kategori)
    formtambah.find("textarea[name='deskripsi']").val(deskripsi)
  }

  function hapus(id, namakategori) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namakategori}?`,
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
          url: "kategori/hapus/" + id,
          data: {
            nama_kategori: namakategori
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
</script>
<?= $this->endSection() ?>