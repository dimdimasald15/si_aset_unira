<div class="card shadow mb-3 formkategori">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title . " " . $jenis ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="form form-vertical mt-3" id="formTambahKategori">
      <?= csrf_field() ?>
      <div class="form-body">
        <div class="row">
          <div class="col-12">
            <input type="hidden" name="id" id="id" value="<?= $globalId ?>">
            <input type="hidden" name="jenis" id="jenis" value="<?= $jenis; ?>">
            <div class="row mb-1">
              <label for="subkode1">Kode <?= $title ?></label>
            </div>
            <div class="row mb-1 subkodekategori">
              <div class="<?= $jenis == "Barang Persediaan" ? 'col-sm-4' : 'col-sm-3' ?> position-relative">
                <div class="input-group has-validation">
                  <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-1-square" viewBox="0 0 16 16">
                      <path d="M9.283 4.002V12H7.971V5.338h-.065L6.072 6.656V5.385l1.899-1.383h1.312Z"></path>
                      <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
                    </svg>
                  </span>
                  <select class="form-select" id="subkode1"></select>
                  <input type="text" class="form-control" placeholder="opsi lain" id="subkode1-other" style="display: none;">
                  <div class="invalid-feedback errsk1"></div>
                </div>
              </div>
              <div class="<?= $jenis == "Barang Persediaan" ? 'col-sm-4' : 'col-sm-3' ?> position-relative">
                <div class="input-group has-validation">
                  <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-2-square" viewBox="0 0 16 16">
                      <path d="M6.646 6.24v.07H5.375v-.064c0-1.213.879-2.402 2.637-2.402 1.582 0 2.613.949 2.613 2.215 0 1.002-.6 1.667-1.287 2.43l-.096.107-1.974 2.22v.077h3.498V12H5.422v-.832l2.97-3.293c.434-.475.903-1.008.903-1.705 0-.744-.557-1.236-1.313-1.236-.843 0-1.336.615-1.336 1.306Z"></path>
                      <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
                    </svg>
                  </span>
                  <select class="form-select" id="subkode2"></select>
                  <input type="text" class="form-control" placeholder="opsi lain" id="subkode2-other" style="display: none;">
                  <div class="invalid-feedback errsk2"></div>
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
              <label for="namakategori">Nama <?= $title ?></label>
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
              <label for="deskripsi">Deskripsi <?= $title ?></label>
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
<script>
  $(document).ready(function() {
    var jenis = $('#jenis').val();
    let subkode1, subkode2, subkode3, subkode4;
    let saveMethod = "<?= $saveMethod ?>",
      globalId;

    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      clearForm();
      $('.formkategori').hide(500);
    });

    getsubkode1(jenis);

    $('#subkode1').on('change', function() {
      subkode1 = $('#subkode1').val();

      $('#kd_kategori').removeClass('is-invalid');
      $('.errkdkat').html('');

      $('#namakategori').removeClass('is-invalid');
      $('.errnamakategori').html('');

      if (subkode1 === 'other1') {
        $('#subkode1-other').show();
        $('#kd_kategori').val('');
        $('#subkode1-other').on('keyup', function() {
          validateInputOther($('#subkode1'), $('#subkode1-other'))
          getsubkodeother($('#subkode1-other').val());
          if ($('#subkode1-other').val() == '') {
            $('#subkode1-other').removeClass('is-invalid');
            $('#subkode1-other').next().html('');
          }
        });
      } else {
        $('#subkode1-other').hide();
        getsubkodeother(subkode1);
      }

      inputnamakategori(jenis, subkode1);

      getsubkode2(subkode1);
    });

    $('#subkode2').on('change', function() {
      subkode2 = $('#subkode2').val();
      if (subkode2 === 'other2') {
        $('#subkode2-other').show();
        $('#kd_kategori').val('');
        $('#namakategori').val('');
        $('#deskripsi').val('');
        $('#subkode2-other').on('keyup', function() {
          validateInputOther($('#subkode2'), $('#subkode2-other'))
          getsubkodeother($('#subkode2-other').val());
          if ($('#subkode2-other').val() == '') {
            $('#subkode2-other').removeClass('is-invalid');
            $('#subkode2-other').next().html('');
          }
          if (subkode1 !== 'other1') {
            getsubkodeother(subkode1, $('#subkode2-other').val());
          } else {
            getsubkodeother($('#subkode1-other').val(), $('#subkode2-other').val());
          }
        });
      } else {
        $('#subkode2-other').hide();
        getsubkodeother(subkode1, subkode2);
        inputnamakategori(jenis, subkode1, subkode2);
      }
      if (jenis == "Barang Tetap") {
        getsubkode3(subkode1, subkode2);
      }
    });

    if (jenis == "Barang Tetap") {
      $('.subkodekategori').append(`
      <div class="col-sm-3 position-relative subkdtetap">
        <div class="input-group has-validation">
          <span class="input-group-text" id="basic-addon1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-3-square" viewBox="0 0 16 16">
              <path d="M7.918 8.414h-.879V7.342h.838c.78 0 1.348-.522 1.342-1.237 0-.709-.563-1.195-1.348-1.195-.79 0-1.312.498-1.348 1.055H5.275c.036-1.137.95-2.115 2.625-2.121 1.594-.012 2.608.885 2.637 2.062.023 1.137-.885 1.776-1.482 1.875v.07c.703.07 1.71.64 1.734 1.917.024 1.459-1.277 2.396-2.93 2.396-1.705 0-2.707-.967-2.754-2.144H6.33c.059.597.68 1.06 1.541 1.066.973.006 1.6-.563 1.588-1.354-.006-.779-.621-1.318-1.541-1.318Z"></path>
              <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
            </svg>
          </span>
          <select class="form-select" id="subkode3"></select>
          <input type="text" class="form-control" placeholder="opsi lain" id="subkode3-other" style="display: none;">
          <div class="invalid-feedback errsk3"></div>
        </div>
      </div>
      <div class="col-sm-3 position-relative subkdtetap">
        <div class="input-group has-validation">
          <span class="input-group-text" id="basic-addon1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-4-square" viewBox="0 0 16 16">
              <path d="M7.519 5.057c.22-.352.439-.703.657-1.055h1.933v5.332h1.008v1.107H10.11V12H8.85v-1.559H4.978V9.322c.77-1.427 1.656-2.847 2.542-4.265ZM6.225 9.281v.053H8.85V5.063h-.065c-.867 1.33-1.787 2.806-2.56 4.218Z"></path>
              <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
            </svg>
          </span>
          <select class="form-select" id="subkode4"></select>
          <input type="text" class="form-control" placeholder="opsi lain" id="subkode4-other" style="display: none;">
          <div class="invalid-feedback errsk4"></div>
        </div>
      </div>
      `);

      $('#subkode3').on('change', function() {
        subkode3 = $('#subkode3').val();

        if (subkode3 === 'other3') {
          $('#subkode3-other').show(); // menampilkan form input
          $('#namakategori').val('');
          $('#kd_kategori').val('');
          $('#deskripsi').val('');
          $('#subkode3-other').on('keyup', function() {
            validateInputOther($('#subkode3'), $('#subkode3-other'))
            getsubkodeother($('#subkode3-other').val());
            if ($('#subkode3-other').val() == '') {
              $('#subkode3-other').removeClass('is-invalid');
              $('#subkode3-other').next().html('');
            }
            if (subkode1 !== 'other1' && subkode2 !== 'other2') {
              getsubkodeother(subkode1, subkode2, $('#subkode3-other').val());
            } else if (subkode1 !== 'other1' && subkode2 == 'other2') {
              getsubkodeother(subkode1, $('#subkode2-other').val(), $('#subkode3-other').val());
            } else {
              getsubkodeother($('#subkode1-other').val(), $('#subkode2-other').val(), $('#subkode3-other').val());
            }
          });
        } else {
          $('#subkode3-other').hide(); // menyembunyikan form input
          getsubkodeother(subkode1, subkode2, subkode3);
          inputnamakategori(jenis, subkode1, subkode2, subkode3);
        }

        getsubkode4(subkode1, subkode2, subkode3);
      });

      $('#subkode4').on('change', function() {
        subkode4 = $('#subkode4').val();
        if (subkode4 === 'other4') {
          $('#subkode4-other').show();
          $('#namakategori').val('');
          $('#kd_kategori').val('');
          $('#deskripsi').val('');
          $('#subkode4-other').on('keyup', function() {
            if (subkode1 !== 'other1' && subkode2 !== 'other2' && subkode3 !== 'other3') {
              getsubkodeother(subkode1, subkode2, subkode3, $('#subkode4-other').val());
            } else if (subkode1 !== 'other1' && subkode2 !== 'other2', subkode3 == 'other3') {
              getsubkodeother(subkode1, subkode2, $('#subkode3-other').val(), $('#subkode4-other').val());
            } else if (subkode1 !== 'other1' && subkode2 == 'other2', subkode3 == 'other3') {
              getsubkodeother(subkode1, $('#subkode2-other').val(), $('#subkode3-other').val(), $('#subkode4-other').val());
            } else {
              getsubkodeother($('#subkode1-other').val(), $('#subkode2-other').val(), $('#subkode3-other').val(), $('#subkode4-other').val());
            }
          });
        } else {
          $('#subkode4-other').hide(); // menyembunyikan form input
          getsubkodeother(subkode1, subkode2, subkode3, subkode4);
          inputnamakategori(jenis, subkode1, subkode2, subkode3, subkode4);
        }
      });

    }

    if (saveMethod == "update") {
      var id = $('#id').val();
      console.log(id);
      $.ajax({
        type: "post",
        url: "<?= $nav ?>/getkategoribyid",
        data: {
          id: id
        },
        dataType: "json",
        success: function(response) {
          isiForm(response);
        }
      });
    }

    $('#formTambahKategori').submit(function(e) {
      e.preventDefault();
      let url = "";
      if (saveMethod == "update") {
        url = "<?= $nav ?>/update/" + $('#id').val();
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpan";
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
              $('#kd_kategori').addClass('is-invalid');
              $('.errkdkat').html(response.error.kdkat);
            } else {
              $('#kd_kategori').removeClass('is-invalid');
              $('.errkdkat').html('');
            }
            if (response.error.nama_kategori) {
              $('#namakategori').addClass('is-invalid');
              $('.errnamakategori').html(response.error.nama_kategori);
            } else {
              $('#namakategori').removeClass('is-invalid');
              $('.errnamakategori').html('');
            }
          } else {
            $('#formTambahKategori').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              tableKatTetap.ajax.reload();
              tableKatPersediaan.ajax.reload();
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

  function clear_is_invalid() {
    if ($('#formtambahkategori').find('input').hasClass('is-invalid') || $('#formtambahkategori').find('select').hasClass('is-invalid')) {
      $('#formtambahkategori').find('input').removeClass('is-invalid');
      $('#formtambahkategori').find('select').removeClass('is-invalid');
    }
  }

  function clearForm() {
    $('#formtambahkategori').find("input").val("")
    $('#formtambahkategori').find("textarea").val("")
    $('#formtambahkategori').find("select").empty()
  }

  function inputnamakategori(jenis, subkd1, subkd2, subkd3, subkd4) {
    // periksa apakah nilai undefined
    subkd1 = (typeof subkd1 !== 'undefined' && subkd1 !== 'other1') ? subkd1 : '';
    subkd2 = (typeof subkd2 !== 'undefined' && subkd2 !== 'other2') ? subkd2 : '';
    subkd3 = (typeof subkd3 !== 'undefined' && subkd3 !== 'other3') ? subkd3 : '';
    subkd4 = (typeof subkd4 !== 'undefined' && subkd4 !== 'other4') ? subkd4 : '';

    $.ajax({
      type: "post",
      url: "<?= $nav ?>/getnamakategori",
      data: {
        subkode1: subkd1,
        subkode2: subkd2,
        subkode3: subkd3,
        subkode4: subkd4,
        jenis: jenis,
      },
      dataType: "json",
      success: function(response) {
        if (response != null) {
          $('#namakategori').val(response.nama_kategori)
          $('#deskripsi').val(response.deskripsi)
        } else {
          $('#namakategori').val('')
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
      $('#kd_kategori').val(`${subkd1other}`)
    } else if (subkd3other == '' && subkd4other == '') {
      $('#kd_kategori').val(`${subkd1other}.${subkd2other}`)
    } else if (subkd4other == '') {
      $('#kd_kategori').val(`${subkd1other}.${subkd2other}.${subkd3other}`)
    } else {
      $('#kd_kategori').val(`${subkd1other}.${subkd2other}.${subkd3other}.${subkd4other}`)
    }
  }

  function getsubkode1(jenis, kode1) {
    $.ajax({
      url: "<?= $nav ?>/getsubkode1",
      data: {
        jenis: jenis,
      },
      type: "post",
      dataType: "json",
      success: function(result) {
        $('#subkode1').empty();
        $('#subkode1').append('<option value="">SubKode 1</option>');
        $.each(result, function(key, value) {
          $('#subkode1').append('<option value="' + value.subkode1 + '">' + value.subkode1 + '</option>');
        });
        $('#subkode1').append('<option value="other1">Lainnya</option>');

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
      url: "<?= $nav ?>/getsubkode2",
      data: {
        subkode1: subkode1,
      },
      dataType: "json",
      success: function(result) {
        $('#subkode2').empty();
        $('#subkode2').append('<option value="">SubKode 2</option>');
        $.each(result, function(key, value) {
          $('#subkode2').append('<option value="' + value.subkode2 + '">' + value.subkode2 + '</option>');
        });
        $('#subkode2').append('<option value="other2">Lainnya</option>');
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
      url: "<?= $nav ?>/getsubkode3",
      data: {
        subkode1: subkode1,
        subkode2: subkode2,
      },
      dataType: "json",
      success: function(result) {
        $('#subkode3').empty();
        $('#subkode3').append('<option value="">SubKode 3</option>');
        for (var i = 0; i < result.length; i++) {
          if (result[i].subkode3 != '') {
            $('#subkode3').append('<option value="' + result[i].subkode3 + '">' + result[i].subkode3 + '</option>');
          }
        }

        $('#subkode3').append('<option value="other3">Lainnya</option>');

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
      url: "<?= $nav ?>/getsubkode4",
      data: {
        subkode1: subkode1,
        subkode2: subkode2,
        subkode3: subkode3,
      },
      dataType: "json",
      success: function(result) {
        $('#subkode4').empty();
        $('#subkode4').append('<option value="">SubKode 4</option>');
        $.each(result, function(key, value) {
          $('#subkode4').append('<option value="' + value.subkode4 + '">' + value.subkode4 + '</option>');
        });
        $('#subkode4').append('<option value="other4">Lainnya</option>');

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

  function isiForm({
    id,
    kd_kategori,
    nama_kategori,
    deskripsi,
    jenis
  }) {
    var kode = kd_kategori; // kode yang akan dipisahkan
    var subkode = kode.split('.'); // memisahkan kode dengan tanda titik

    var kode1 = subkode[0]; // mendapatkan subkode 1
    var kode2 = subkode[1]; // mendapatkan subkode 2

    getsubkode1(jenis, kode1);
    getsubkode2(kode1, kode2);
    if (jenis == "Barang Tetap") {
      var kode3 = subkode[2]; // mendapatkan subkode 3
      var kode4 = subkode[3]; // mendapatkan subkode 4
      getsubkode3(kode1, kode2, kode3);
      getsubkode4(kode1, kode2, kode3, kode4);
    }

    $('#formTambahKategori').find("input[name='id']").val(id)
    $('#formTambahKategori').find("input[name='kd_kategori']").val(kd_kategori)
    $('#formTambahKategori').find("input[name='nama_kategori']").val(nama_kategori)
    $('#formTambahKategori').find("textarea[name='deskripsi']").val(deskripsi)
  }
</script>