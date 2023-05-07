<form class="form form-vertical py-2 formsimpanmultiple">
  <?= csrf_field() ?>
  <?php $no = 1; ?>
  <table class="table table-responsive-lg">
    <thead>
      <th>Form Tambah Barang Multiple</th>
      <th>Action</th>
    </thead>
    <tbody class="formtambahrow">
      <tr>
        <td>
          <div class="form-body">
            <div class="row d-flex justify-content-between">
              <div class="col-12">
                <h5>Form <?= $no; ?></h5>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="katid mb-2">Nama Kategori</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                    <select name="kat_id<?= $no; ?>" class="form-select p-2" id="katid<?= $no ?>" style="width: 400px;"></select>
                    <div class="invalid-feedback errkatid<?= $no; ?>"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-6">
                    <label for="kodebrg">Kode Barang</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text">
                        <i class="bi bi-upc"></i>
                      </span>
                      <input type="text" class="form-control" name="kd_kategori[]" placeholder="Kode Kategori" id="subkdkategori<?= $no ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="subkodebarang"></label>
                    <div class="input-group mb-3">
                      <select name="skbrg[]" class="form-select" id="skbarang<?= $no ?>"></select>
                      <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other<?= $no ?>" name="skbrg_lain[]" readonly style="display:none;">
                      <input type="text" class="form-control" id="skbrgfix<?= $no ?>" name="kode_brg<?= $no; ?>" readonly style="display:none;">
                      <div class="invalid-feedback errskbarang<?= $no ?>"></div>
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
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="namabarang<?= $no ?>" name="nama_brg<?= $no; ?>">
                    <div class="invalid-feedback errnamabarang<?= $no ?>"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-6">
                    <label for="merk" class="form-label">Merk</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-tags"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk<?= $no ?>" name="merk<?= $no ?>">
                      <div class="invalid-feedback errmerk<?= $no ?>"></div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="warna" class="form-label">Warna</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-palette"></i></span>
                      <input type="color" class="form-control" placeholder="Masukkan Warna" id="warna<?= $no ?>" name="warna<?= $no ?>">
                      <div class="invalid-feedback errwarna<?= $no ?>">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-5 mb-3 asalbrg<?= $no ?>">
                    <label for="merk" class="form-label">Asal <?= $title; ?></label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="asal_<?= $no ?>" id="belibaru<?= $no ?>" value="Beli baru">
                      <label class="form-check-label" for="asal">
                        Beli Baru
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="asal_<?= $no ?>" id="belibekas<?= $no ?>" value="Beli bekas">
                      <label class="form-check-label" for="belibekas">
                        Beli Bekas
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="asal_<?= $no ?>" id="hibah<?= $no ?>" value="Hibah">
                      <label class="form-check-label" for="hibah">
                        Hibah
                      </label>
                      <div class="invalid-feedback errasalbrg<?= $no ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-7 radiobelibekas<?= $no ?>" style="display:none;">
                    <label for=" merk" class="form-label">Beli bekas dimana?</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" id="radiotoko<?= $no ?>">
                      <label class="form-check-label" for="radiotoko">
                        Beli di toko
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" id="radioinstansi<?= $no ?>">
                      <label class="form-check-label" for="radioinstansi">
                        Beli di Instansi
                      </label>
                    </div>
                  </div>
                  <div class="col-md-7 mb-3 belibaru<?= $no ?>" style="display:none;">
                    <label for="toko" class="form-label">Nama Toko</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-shop"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan nama toko" id="toko<?= $no ?>" name="toko<?= $no ?>">
                      <div class="invalid-feedback errtoko"></div>
                    </div>
                  </div>
                  <div class="col-md-7 hibah<?= $no ?>" style="display:none;">
                    <label for="instansi" class="form-label">Nama Instansi</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-building"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan Nama Instansi" id="instansi<?= $no ?>" name="instansi<?= $no ?>">
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
                      <span class="input-group-text"><i class="bi bi-hash"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan No Seri" id="noseri<?= $no ?>" name="no_seri<?= $no ?>">
                      <div class="invalid-feedback errnoseri"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="nodokumen" class="form-label">Nomor Dokumen</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                      <input type="text" class="form-control" placeholder="Masukkan No Dokumen" id="nodokumen<?= $no ?>" name="no_dokumen<?= $no ?>">
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
                      <span class="input-group-text">Rp</span>
                      <input type="number" <?= $jenis_kat == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli<?= $no ?>" name="harga_beli<?= $no ?>">
                      <div class="invalid-feedback errhargabeli<?= $no ?>"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="hargajual" class="form-label">Harga Jual Barang</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text">Rp</span>
                      <input type="number" <?= $jenis_kat == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Jual" id="hargajual<?= $no ?>" name="harga_jual<?= $no ?>">
                      <div class="invalid-feedback errhargajual<?= $no ?>"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-auto">
                    <label for="tglbeli" class="mb-1">Tanggal Pembelian</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="dd/mm/yyyy" id="tglbeli<?= $no ?>" name="tgl_pembelian<?= $no ?>">
                      <div class="invalid-feedback errtglbeli<?= $no ?>"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="lokasi">Lokasi Penempatan <?= $title ?></label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                      <select class="form-select" id="lokasi<?= $no ?>" name="ruang_id<?= $no ?>"></select>
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
                        <input type="number" min="1" class="form-control " id="jmlmasuk<?= $no ?>" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk<?= $no ?>">
                        <div class="invalid-feedback errjmlmasuk<?= $no ?>"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="" class="mb-1">Satuan <?= $title; ?></label>
                      <div class="input-group mb-3">
                        <select name="satuan_id<?= $no ?>" class="form-select p-2 " id="satuan<?= $no ?>"></select>
                        <div class="invalid-feedback errsatuan<?= $no ?>"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </td>
        <td class="align-bottom" style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row">
    <div class="col-6 d-flex justify-content-start">
      <button type="button" class="btn btn-primary my-4 btn-sm btntambahrow"><i class="fa fa-plus"></i>Tambah Form</button>
    </div>
    <div class="col-6 d-flex justify-content-end">
      <button type="button" class="btn btn-white my-4 backformmultiple">&laquo; Kembali</button>
      <button type="submit" class="btn btn-success my-4 btnsimpanmultiple">Simpan</button>
    </div>
  </div>
</form>

<script>
  lastNumb = parseInt("<?= $no ?>");
  currIndex = lastNumb + 1;
  var rowCount = '';
  var kd_brgmt = '';
  var kdbrgothermt = '';

  function clearFormmt(row) {
    $('.formsimpanmultiple').find("#warna").val('#000000');
    $('.formsimpanmultiple').find("input").val("")
    $('.formsimpanmultiple').find("select").html("")
    $('.formsimpanmultiple').find("input[type='radio']").prop('checked', false);
    $(`.hibah${row}`).hide();
    $(`.belibaru${row}`).hide();
    $(`.radiobelibekas${row}`).hide();
    $(`#skbarang-other${row}`).hide();
  }

  function getsubkdbarangmt(idkategori, row) {
    $.ajax({
      url: "<?= site_url('barangcontroller/getsubkdbarang') ?>",
      type: "POST",
      data: {
        katid: idkategori,
      },
      dataType: "json",
      success: function(response) {
        $(`#skbarang${row}`).empty();
        $(`#skbarang${row}`).append('<option value="">Sub-Kode Barang</option>');
        if (response.subkdbarang == undefined) {
          $(`#subkdkategori${row}`).val(response[0].kd_kategori);
        }
        if (response[0].subkdbarang !== undefined) {
          $(`#subkdkategori${row}`).val(response[0].kd_kategori);
          $.each(response, function(key, value) {
            $(`#skbarang${row}`).append('<option value="' + value.subkdbarang + '">' + value.subkdbarang + '</option>');
          });
        }

        $(`#skbarang${row}`).append('<option value="otherbrg' +
          row + '">Lainnya</option>');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function getsubkdotherbarangmt(idkategori, row) {
    if (idkategori !== null) {
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>/barangcontroller/getkdbrgbykdkat",
        data: {
          katid: idkategori,
        },
        dataType: "json",
        success: function(response) {
          kdbrgothermt = response.subkdbrgother;
        }
      });
    }
  }

  kodebrgSet = new Set();

  function checkKodeBarangDuplikat(row) {
    let kodeBarang = $('#skbrgfix' + row).val();
    var kdbrglain = parseInt($(`#skbarang-other${row}`).val());
    kdbrglain = kdbrglain + 1;
    let sbkdbrgbaru = kdbrglain.toString().padStart(3, '0');

    if (kodebrgSet.has(kodeBarang)) {
      Swal.fire({
        icon: 'info',
        text: 'Kode barang ' + kodeBarang + ' sudah dimasukkan sebelumnya. Sistem akan merekomendasikan subkode barang yang baru.',
      }).then((result) => {
        $(`#skbarang-other${row}`).val(sbkdbrgbaru);
      })
    } else {
      // Tambahkan kode barang ke Set jika belum ada
      kodebrgSet.add(kodeBarang);
    }
  }

  function loadLokasi(row) {
    if (lokasiSarprasCache) {
      // jika data lokasi sudah tersedia di cache, gunakan data tersebut
      $(`#lokasi${row}`).html(`<option value='${lokasiSarprasCache[0].id}' selected>${lokasiSarprasCache[0].text}</option>`);
    } else {
      // jika data lokasi belum tersedia di cache, muat data baru dari server
      $.ajax({
        type: "get",
        url: "<?= base_url() ?>/barangcontroller/pilihlokasi",
        data: {
          search: "Sarana",
        },
        dataType: "json",
        success: function(response) {
          // simpan data lokasi ke dalam cache
          lokasiSarprasCache = response;
          // tampilkan opsi lokasi di form
          $(`#lokasi${row}`).html(`<option value='${response[0].id}' selected>${response[0].text}</option>`);
        }
      });
    }
  }

  function looping(row) {
    for (var i = 1; i <= row; i++) {
      $('.formtambahrow tr').find('.btnhapusrow').hide();

      $(`#katid${i}`).select2({
        placeholder: 'Piih Nama Kategori <?= $title; ?>',
        minimumInputLength: 1,
        allowClear: true,
        width: "50%",
        ajax: {
          url: `<?= $nav; ?>/pilihkategori`,
          dataType: 'json',
          delay: 250,
          data: function(params) {
            return {
              search: params.term,
              jenis_kat: '<?= $jenis_kat; ?>',
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

      (function(j) {
        $(`#katid${j}`).on('change', function(e) {
          e.preventDefault();
          var katid = $(this).val();
          if (katid == null) {
            kd_brg = '';
            clearFormmt(j);
          } else {
            getsubkdbarangmt(katid, j);
            getsubkdotherbarangmt(katid, j);
          }
          $(`#katid${j}`).removeClass('is-invalid');
          $(`.errkdkatid${j}`).html('');
          $(`#skbarang-other${j}`).hide();
        })

        $(`#skbarang${j}`).on('change', function(e) {
          e.preventDefault();
          if ($(this).val() == '') {
            // clearformwithtriggermt(j);
            $(`#skbrgfix${j}`).val('');
            $(`#skbarang-other${j}`).hide();
            checkKodeBarangDuplikat(j);
          } else if ($(this).val() == `otherbrg${j}`) {
            // clearformwithtriggermt(j);
            $(`#skbarang-other${j}`).show();
            $(`#skbarang-other${j}`).val(kdbrgothermt);
            kd_brgmt = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang-other${j}`).val()}`;
            // $(`#skbrgfix${j}`).show();
            $(`#skbrgfix${j}`).val(kd_brgmt);
            checkKodeBarangDuplikat(j);
          } else {
            // clearformwithtriggermt(j);
            var kdbrglama = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang${j}`).val()}`;

            var kodebrgbaru;

            $.ajax({
              type: "post",
              url: "<?= base_url() ?>" + '/barangcontroller/getbarangbyany',
              data: {
                kode_brg: kdbrglama,
              },
              dataType: "json",
              success: function(response) {
                // isiFormmt(response, j)
                Swal.fire({
                  icon: 'warning',
                  text: `${response.nama_brg} dengan kode barang ${response.kode_brg} sudah ada, lebih baik lakukan update barang melalui menu update barang. Sistem akan merekomendasikan opsi lain untuk subkode barang.`,
                }).then((result) => {
                  $(`#skbarang${j}`).val(`otherbrg${j}`);
                  $(`#skbarang-other${j}`).show(500);
                  $(`#skbarang-other${j}`).val(kdbrgothermt);
                  kodebrgbaru = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang-other${j}`).val()}`;
                  $(`#skbrgfix${j}`).val(kodebrgbaru);
                  checkKodeBarangDuplikat(j);
                })
              }
            });
          }
          $(`#skbrgfix${j}`).removeClass('is-invalid');
          $(`.errskbarang${j}`).html('');
        });

        $('input[type="radio"]').click(function() {
          if ($(this).attr('id') == `belibaru${j}`) {
            $(`.belibaru${j}`).show();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).hide();
            $('.formsimpanmultiple').find("input[name='instansi[" + j + "]']").val('')
          } else if ($(this).attr('id') == `belibekas${j}`) {
            $(`.radiobelibekas${j}`).show();
            $(`.belibaru${j}`).hide();
            $(`.hibah${j}`).hide();
            $('.formsimpanmultiple').find("input[name='toko[" + j + "]']").val('')
            $('.formsimpanmultiple').find("input[name='instansi[" + j + "]']").val('')
          } else if ($(this).attr('id') == `hibah${j}`) {
            $(`.belibaru${j}`).hide();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).show();
            $('.formsimpanmultiple').find("input[name='toko[" + j + "]']").val('')
          } else if ($(this).attr('id') == `radiotoko${j}`) {
            $(`.belibaru${j}`).show();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).hide();
            $(`#radioinstansi${j}`).prop('checked', false);
            $('.formsimpanmultiple').find("input[name='instansi[" + j + "]']").val('')
          } else if ($(this).attr('id') == `radioinstansi${j}`) {
            $(`.belibaru${j}`).hide();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).show();
            $(`#radiotoko${j}`).prop('checked', false);
            $('.formsimpanmultiple').find("input[name='toko[" + j + "]']").val('')
          } else {
            $(`.radiobelibekas${j}`).hide();
            $(`.belibaru${j}`).hide();
            $(`.hibah${j}`).hide();
          }

          $(`.asalbrg${j} .form-check-input`).removeClass("is-invalid");
          $(`.errasalbrg${j}`).html('');
        });

        $(`#namabarang${j}`).on(`input`, function(e) {
          e.preventDefault();
          $(`#namabarang${j}`).removeClass(`is-invalid`);
          $(`.errornamabarang${j}`).html(``);
        })
        $(`#merk${j}`).on(`input`, function(e) {
          e.preventDefault();
          $(`#merk${j}`).removeClass(`is-invalid`);
          $(`.errormerk${j}`).html(``);
        })
        $(`#hargabeli${j}`).on(`input`, function(e) {
          e.preventDefault();
          $(`#hargabeli${j}`).removeClass(`is-invalid`);
          $(`.errorhargabeli${j}`).html(``);
        })
        $(`#hargajual${j}`).on(`input`, function(e) {
          e.preventDefault();
          $(`#hargajual${j}`).removeClass(`is-invalid`);
          $(`.errorhargajual${j}`).html(``);
        })

        $(`#satuan${j}`).select2({
          placeholder: 'Piih Satuan',
          minimumInputLength: 1,
          allowClear: true,
          width: "100%",
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
              return {
                results: data
              };
            },
            cache: true
          },
          templateResult: formatResult,
        });

        $(`#satuan${j}`).on('change', function(e) {
          e.preventDefault();
          $(`#satuan${j}`).removeClass('is-invalid');
          $(`.errorsatuan${j}`).html('');
        })
        $(`#jmlmasuk${j}`).on('input', function(e) {
          e.preventDefault();
          $(`#jmlmasuk${j}`).removeClass('is-invalid');
          $(`.errorjmlmasuk${j}`).html('');
        })
      })(i);

      loadLokasi(i);
    }
  }

  function clear_is_invalid() {
    if ($('.formsimpanmultiple').find('input').hasClass('is-invalid') || $('.formsimpanmultiple').find('select').hasClass('is-invalid')) {
      $('.formsimpanmultiple').find('input').removeClass('is-invalid');
      $('.formsimpanmultiple').find('select').removeClass('is-invalid');
    }
  }

  $(document).ready(function() {
    rowCount = $('.formtambahrow tr').length;
    looping(rowCount);
    loadLokasi(rowCount);

    $('.backformmultiple').on('click', function() {
      currIndex = rowCount + 1;
      // Hapus semua baris kecuali baris pertama
      $('.formtambahrow tr').slice(1).remove();
      clear_is_invalid();
      clearFormmt(rowCount);
      $('.formsimpanmultiple').hide(500);
      $('.optionmt').show(500);
      $('#opsi1mt').prop('checked', false);
      $('#opsi2mt').prop('checked', false);
    });

    $('.btntambahrow').on('click', function(e) {
      e.preventDefault();
      var index = currIndex++;

      $(".formtambahrow").append(`
            <tr>
              <td>
                <div class="form-body">
                  <div class="row d-flex justify-content-between">
                  <div class="col-12">
                      <h5>Form ${index}</h5>
                    </div>
                    <div class="col-12">
                      <div class="row mb-1">
                        <label for="katid mb-2">Nama Kategori</label>
                      </div>
                      <div class="row mb-1">
                        <div class="input-group mb-3">
                          <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                          <select name="kat_id${index}" class="form-select p-2" id="katid${index}" style="width: 400px;"></select>
                          <div class="invalid-feedback errkatid${index}"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-6">
                          <label for="kodebrg">Kode Barang</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">
                              <i class="bi bi-upc"></i>
                            </span>
                            <input type="text" class="form-control" name="kd_kategori[]" placeholder="Kode Kategori" id="subkdkategori${index}" readonly>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="subkodebarang"></label>
                          <div class="input-group mb-3">
                            <select name="skbrg[]" class="form-select" id="skbarang${index}"></select>
                            <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other${index}" name="skbrg_lain[]" readonly style="display:none;">
                            <input type="text" class="form-control" id="skbrgfix${index}" name="kode_brg${index}" readonly style="display:none;">
                            <div class="invalid-feedback errskbarang${index}"></div>
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
                          <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                          <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="namabarang${index}" name="nama_brg${index}">
                          <div class="invalid-feedback errnamabarang${index}"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-6">
                          <label for="merk" class="form-label">Merk</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk${index}" name="merk${index}">
                            <div class="invalid-feedback errmerk${index}"></div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label for="warna" class="form-label">Warna</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-palette"></i></span>
                            <input type="color" class="form-control" placeholder="Masukkan Warna" id="warna${index}" name="warna${index}">
                            <div class="invalid-feedback errwarna${index}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-5 mb-3 asalbrg${index}">
                          <label for="merk" class="form-label">Asal <?= $title; ?></label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="asal_${index}" id="belibaru${index}" value="Beli baru">
                            <label class="form-check-label" for="asal">
                              Beli Baru
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="asal_${index}" id="belibekas${index}" value="Beli bekas">
                            <label class="form-check-label" for="belibekas">
                              Beli Bekas
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="asal_${index}" id="hibah${index}" value="Hibah">
                            <label class="form-check-label" for="hibah">
                              Hibah
                            </label>
                            <div class="invalid-feedback errasalbrg${index}">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-7 radiobelibekas${index}" style="display:none;">
                          <label for=" merk" class="form-label">Beli bekas dimana?</label>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" id="radiotoko${index}">
                            <label class="form-check-label" for="radiotoko">
                              Beli di toko
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" id="radioinstansi${index}">
                            <label class="form-check-label" for="radioinstansi">
                              Beli di Instansi
                            </label>
                          </div>
                        </div>
                        <div class="col-md-7 mb-3 belibaru${index}" style="display:none;">
                          <label for="toko" class="form-label">Nama Toko</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan nama toko" id="toko${index}" name="toko${index}">
                            <div class="invalid-feedback errtoko${index}"></div>
                          </div>
                        </div>
                        <div class="col-md-7 hibah${index}" style="display:none;">
                          <label for="instansi" class="form-label">Nama Instansi</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan Nama Instansi" id="instansi${index}" name="instansi${index}">
                            <div class="invalid-feedback errinstansi${index}"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-6">
                          <label for="noseri" class="form-label">Nomor seri barang</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan No Seri" id="noseri${index}" name="no_seri${index}">
                            <div class="invalid-feedback errnoseri"></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="nodokumen" class="form-label">Nomor Dokumen</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan No Dokumen" id="nodokumen${index}" name="no_dokumen${index}">
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
                            <span class="input-group-text">Rp</span>
                            <input type="number" <?= $jenis_kat == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli${index}" name="harga_beli${index}">
                            <div class="invalid-feedback errhargabeli${index}"></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="hargajual" class="form-label">Harga Jual Barang</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" <?= $jenis_kat == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Jual" id="hargajual${index}" name="harga_jual${index}">
                            <div class="invalid-feedback errhargajual${index}"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-auto">
                          <label for="tglbeli" class="mb-1">Tanggal Pembelian</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" id="tglbeli${index}" name="tgl_pembelian${index}">
                            <div class="invalid-feedback errtglbeli${index}"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="col-12">
                        <div class="row mb-1">
                          <label for="lokasi">Lokasi Penempatan <?= $title ?></label>
                        </div>
                        <div class="row mb-1">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                            <select class="form-select" id="lokasi${index}" name="ruang_id${index}"></select>
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
                              <input type="number" min="1" class="form-control " id="jmlmasuk${index}" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk${index}">
                              <div class="invalid-feedback errjmlmasuk${index}"></div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="" class="mb-1">Satuan <?= $title; ?></label>
                            <div class="input-group mb-3">
                              <select name="satuan_id${index}" class="form-select p-2 " id="satuan${index}"></select>
                              <div class="invalid-feedback errsatuan${index}"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td class="align-bottom" style="width:1px; white-space:nowrap;">
                <button type="button" class="btn btn-danger btn-sm btnhapusrow">
                <i class="fa fa-times"></i> Hapus form ${index}
                </button>
              </td>
            </tr>
            `);

      rowCount = $('.formtambahrow tr').length;

      looping(rowCount);

      $(".formtambahrow tr:last-child .btnhapusrow").show();
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
      rowCount = $('.formtambahrow tr').length;
      for (var i = 0; i < rowCount; i++) {
        $('.formtambahrow tr').find('.btnhapusrow').hide();
      }

      rowCount === 1 ? $('.formtambahrow tr').find('.btnhapusrow').hide() :
        $(".formtambahrow tr:last-child .btnhapusrow").show();
    })

    $('.formsimpanmultiple').submit(function(e) {
      e.preventDefault();
      // mengambil data dari form
      let formdatamultiple = new FormData(this);
      // dapatkan jumlah row
      formdatamultiple.append('jmldata', rowCount);
      formdatamultiple.append('jenistrx', "<?= $jenistrx ?>");

      $.ajax({
        type: "post",
        url: "<?= $nav; ?>/insertmultiple",
        data: formdatamultiple,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.btnsimpanmultiple').attr('disable', 'disabled');
          $('.btnsimpanmultiple').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpanmultiple').removeAttr('disable');
          $('.btnsimpanmultiple').html('Simpan');
        },
        success: function(result) {
          var response = JSON.parse(result);
          var jmldata = parseInt(response.jmldata);

          if (response.error) {
            for (var i = 1; i <= jmldata; i++) {
              var errorkatid = response.error[`kat_id${i}`];
              if (errorkatid) {
                $(`#katid${i}`).addClass('is-invalid');
                $(`.errkatid${i}`).html(errorkatid);
              } else {
                $(`#katid${i}`).removeClass('is-invalid');
                $(`.errkatid${i}`).html('');
              }
              var errorkodebrg = response.error[`kode_brg${i}`];
              if (errorkodebrg) {
                $(`#skbrgfix${i}`).addClass('is-invalid');
                $(`.errskbarang${i}`).html(errorkodebrg);
              } else {
                $(`#skbrgfix${i}`).removeClass('is-invalid');
                $(`.errskbarang${i}`).html('');
              }
              var errornama_brg = response.error[`nama_brg${i}`];
              if (errornama_brg) {
                $(`#namabarang${i}`).addClass('is-invalid');
                $(`.errnamabarang${i}`).html(errornama_brg);
              } else {
                $(`#namabarang${i}`).removeClass('is-invalid');
                $(`.errnamabarang${i}`).html('');
              }
              var errormerk = response.error[`merk${i}`];
              if (errormerk) {
                $(`#merk${i}`).addClass('is-invalid');
                $(`.errmerk${i}`).html(errormerk);
              } else {
                $(`#merk${i}`).removeClass('is-invalid');
                $(`.errmerk${i}`).html('');
              }
              var errorwarna = response.error[`warna${i}`];
              if (errorwarna) {
                $(`#warna${i}`).addClass('is-invalid');
                $(`.errwarna${i}`).html(errorwarna);
              } else {
                $(`#warna${i}`).removeClass('is-invalid');
                $(`.errwarna${i}`).html('');
              }
              var errorasal = response.error[`asal_${i}`];
              if (errorasal) {
                $(`.asalbrg${i} .form-check-input`).addClass('is-invalid');
                $(`.errasalbrg${i}`).html(errorasal);
              } else {
                $(`.asalbrg${i} .form-check-input`).removeClass('is-invalid');
                $(`.errasalbrg${i}`).html('');
              }
              var errorhrgbeli = response.error[`harga_beli${i}`];
              if (errorhrgbeli) {
                $(`#hargabeli${i}`).addClass('is-invalid');
                $(`.errhargabeli${i}`).html(errorhrgbeli);
              } else {
                $(`#hargabeli${i}`).removeClass('is-invalid');
                $(`.errhargabeli${i}`).html('');
              }
              var errorhrgjual = response.error[`harga_jual${i}`];
              if (errorhrgjual) {
                $(`#hargajual${i}`).addClass('is-invalid');
                $(`.errhargajual${i}`).html(errorhrgjual);
              } else {
                $(`#hargajual${i}`).removeClass('is-invalid');
                $(`.errhargajual${i}`).html('');
              }
              var errorlokasi = response.error[`ruang_id${i}`];
              if (errorlokasi) {
                $(`#lokasi${i}`).addClass('is-invalid');
                $(`.errlokasi${i}`).html(errorlokasi);
              } else {
                $(`#lokasi${i}`).removeClass('is-invalid');
                $(`.errlokasi${i}`).html('');
              }
              var errorjmlmasuk = response.error[`jumlah_masuk${i}`];
              if (errorjmlmasuk) {
                $(`#jmlmasuk${i}`).addClass('is-invalid');
                $(`.errjmlmasuk${i}`).html(errorjmlmasuk);
              } else {
                $(`#jmlmasuk${i}`).removeClass('is-invalid');
                $(`.errjmlmasuk${i}`).html('');
              }
              var errorsatuan = response.error[`satuan_id${i}`];
              if (errorsatuan) {
                $(`#satuan${i}`).addClass('is-invalid');
                $(`.errsatuan${i}`).html(errorsatuan);
              } else {
                $(`#satuan${i}`).removeClass('is-invalid');
                $(`.errsatuan${i}`).html('');
              }
            }
          } else {
            $('.formtambahrow tr').slice(1).remove();
            $('.formsimpanmultiple').hide(500);
            $('.optionmt').show(500);
            $('#opsi1mt').prop('checked', false);
            $('#opsi2mt').prop('checked', false);
            $('#cardmultipleinsert').hide(500);
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
    })
  });
</script>