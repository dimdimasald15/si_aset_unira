<div class="card mb-3 shadow" id="cardmultipleinsert">
  <div class="card-header shadow-sm">
    <h5 class="card-title">Form Multiple Insert <?= $title; ?></h5>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form class="form form-vertical py-2 formsimpanmultiple">
        <?= csrf_field() ?>
        <?php $no = 1; ?>
        <table class="table table-responsive-lg">
          <thead>
            <th>Form Tambah Multiple</th>
            <th>Action</th>
          </thead>
          <tbody class="formtambahrow">
            <tr>
              <td>
                <div class="form-body formMultipleInsertBarang">
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
                            <input type="number" <?= $title == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli<?= $no ?>" name="harga_beli<?= $no ?>">
                            <div class="invalid-feedback errhargabeli<?= $no ?>"></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="hargajual" class="form-label">Harga Jual Barang</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" <?= $title == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Jual" id="hargajual<?= $no ?>" name="harga_jual<?= $no ?>">
                            <div class="invalid-feedback errhargajual<?= $no ?>"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12" <?= $title == 'Barang Persediaan' ? "hidden" : "" ?>>
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
            <button type="button" class="btn btn-white my-4 batal-formmultiple">Batal</button>
            <button type="submit" class="btn btn-success my-4 btnsimpanmultiple">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  let formtambahmt = $('#cardmultipleinsert')
  var lastNumb = parseInt("<?= $no ?>");
  var currIndex = lastNumb + 1;
  var rowCount = '';
  var kd_brgmt = '';
  var kdbrgothermt = '';

  function clearFormmt(row) {
    formtambahmt.find(`.asalbrg${row} input[type='radio']`).prop('checked', false);
    formtambahmt.find(`.radiobelibekas${row} input[type='radio']`).prop('checked', false);

    formtambahmt.find(`select #katid${row}`).html('');
    formtambahmt.find(`#subkdkategori${row}`).val('');
    formtambahmt.find(`select #skbarang${row}`).html('');
    formtambahmt.find(`#skbarang-other${row}`).val('');
    formtambahmt.find(`#skbrgfix${row}`).val('');
    formtambahmt.find(`#namabarang${row}`).val('');
    formtambahmt.find(`#merk${row}`).val('');
    formtambahmt.find(`#warna${row}`).val('#000000');
    formtambahmt.find(`#toko${row}`).val('');
    formtambahmt.find(`#instansi${row}`).val('');
    formtambahmt.find(`#noseri${row}`).val('');
    formtambahmt.find(`#nodokumen${row}`).val('');
    formtambahmt.find(`#hargabeli${row}`).val('');
    formtambahmt.find(`#hargajual${row}`).val('');
    formtambahmt.find(`#tglbeli${row}`).val('');

    $(`.hibah${row}`).hide();
    $(`.belibaru${row}`).hide();
    $(`.radiobelibekas${row}`).hide();
    $(`#skbarang-other${row}`).hide();
  }

  function clearformwithtriggermt(row) {
    formtambahmt.find(`.asalbrg${row} input[type='radio']`).prop('checked', false);
    formtambahmt.find(`.radiobelibekas${row} input[type='radio']`).prop('checked', false);

    formtambahmt.find(`#namabarang${row}`).val('');
    formtambahmt.find(`#merk${row}`).val('');
    formtambahmt.find(`#warna${row}`).val('#000000');
    formtambahmt.find(`#toko${row}`).val('');
    formtambahmt.find(`#instansi${row}`).val('');
    formtambahmt.find(`#noseri${row}`).val('');
    formtambahmt.find(`#nodokumen${row}`).val('');
    formtambahmt.find(`#hargabeli${row}`).val('');
    formtambahmt.find(`#hargajual${row}`).val('');
    formtambahmt.find(`#tglbeli${row}`).val('');
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

  function isiFormmt({
    id,
    kat_id,
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
  }, row) {
    formtambahmt.find(`#namabarang${row}`).val(nama_brg);
    formtambahmt.find(`#merk${row}`).val(merk);
    formtambahmt.find(`#warna${row}`).val(warna);
    formtambahmt.find(`#toko${row}`).val(toko);
    formtambahmt.find(`#instansi${row}`).val(instansi);
    formtambahmt.find(`#noseri${row}`).val(no_seri);
    formtambahmt.find(`#nodokumen${row}`).val(no_dokumen);
    formtambahmt.find(`#hargabeli${row}`).val(harga_beli);
    formtambahmt.find(`#hargajual${row}`).val(harga_jual);

    let inputtglbeli = '';
    if (tgl_pembelian !== null) {
      inputtglbeli = tgl_pembelian;
      inputtglbeli = inputtglbeli.split(" ")[0]; // ambil tanggal saja
    } else {
      inputtglbeli = tgl_pembelian;
    }
    formtambahmt.find(`#tglbeli${row}`).val(inputtglbeli);

    if (asal === 'Beli baru') {
      $(`#belibaru${row}`).prop('checked', true);
      $(`.belibaru${row}`).show();
      $(`.hibah${row}`).hide();
      $(`.radiobelibekas${row}`).hide();
    } else if (asal == 'Beli bekas') {
      $(`#belibekas${row}`).prop('checked', true);
      $(`.radiobelibekas${row}`).hide();
      if (toko == null) {
        $(`.belibaru${row}`).hide();
        $(`.hibah${row}`).show();
      } else if (instansi == null) {
        $(`.belibaru${row}`).show();
        $(`.hibah${row}`).hide();
      }
    } else if (asal == 'Hibah') {
      $(`#hibah${row}`).prop('checked', true);
      $(`.hibah${row}`).show();
      $(`.belibaru${row}`).hide();
      $(`.radiobelibekas${row}`).hide();
    } else {
      formtambahmt.find("input[type='radio']").prop('checked', false);
      $(`.hibah${row}`).hide();
      $(`.belibaru${row}`).hide();
      $(`.radiobelibekas${row}`).hide();
    }
  }

  // Inisialisasi Set untuk menyimpan kode barang yang sudah dimasukkan
  let kodebrgSet = new Set();

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

  function looping(row) {
    for (var i = 1; i <= row; i++) {
      $('.formtambahrow tr').find('.btnhapusrow').hide();

      // console.log(i);
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
            console.log(`skbarang on change form ${j} opsi 1`);
            clearformwithtriggermt(j);
            $(`#skbrgfix${j}`).val('');
            $(`#skbarang-other${j}`).hide();
            checkKodeBarangDuplikat(j);
          } else if ($(this).val() == `otherbrg${j}`) {
            console.log(`skbarang on change form ${j} opsi 2`);
            clearformwithtriggermt(j);
            $(`#skbarang-other${j}`).show();
            $(`#skbarang-other${j}`).val(kdbrgothermt);
            kd_brgmt = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang-other${j}`).val()}`;
            // $(`#skbrgfix${j}`).show();
            $(`#skbrgfix${j}`).val(kd_brgmt);
            checkKodeBarangDuplikat(j);
          } else {
            console.log(`skbarang on change form ${j} opsi 3`);
            clearformwithtriggermt(j);
            kd_brgmt = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang${j}`).val()}`;
            // $(`#skbrgfix${j}`).show();
            $(`#skbrgfix${j}`).val(kd_brgmt);
            $(`#skbarang-other${j}`).hide();
            checkKodeBarangDuplikat(j);

            $.ajax({
              type: "post",
              url: "<?= base_url() ?>" + '/barangcontroller/getbarangbyany',
              data: {
                kode_brg: kd_brgmt,
              },
              dataType: "json",
              success: function(response) {
                isiFormmt(response, j)
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
            formtambahmt.find("input[name='instansi[" + j + "]']").val('')
          } else if ($(this).attr('id') == `belibekas${j}`) {
            $(`.radiobelibekas${j}`).show();
            $(`.belibaru${j}`).hide();
            $(`.hibah${j}`).hide();
            formtambahmt.find("input[name='toko[" + j + "]']").val('')
            formtambahmt.find("input[name='instansi[" + j + "]']").val('')
          } else if ($(this).attr('id') == `hibah${j}`) {
            $(`.belibaru${j}`).hide();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).show();
            formtambahmt.find("input[name='toko[" + j + "]']").val('')
          } else if ($(this).attr('id') == `radiotoko${j}`) {
            $(`.belibaru${j}`).show();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).hide();
            $(`#radioinstansi${j}`).prop('checked', false);
            formtambahmt.find("input[name='instansi[" + j + "]']").val('')
          } else if ($(this).attr('id') == `radioinstansi${j}`) {
            $(`.belibaru${j}`).hide();
            $(`.radiobelibekas${j}`).hide();
            $(`.hibah${j}`).show();
            $(`#radiotoko${j}`).prop('checked', false);
            formtambahmt.find("input[name='toko[" + j + "]']").val('')
          } else {
            $(`.radiobelibekas${j}`).hide();
            $(`.belibaru${j}`).hide();
            $(`.hibah${j}`).hide();
          }

          $(`.asalbrg${j} .form-check-input`).removeClass("is-invalid");
          $(`.errasalbrg${j}`).html('');
        });
      })(i);
    }
  }

  function clear_is_invalid() {
    if (formtambahmt.find('input').hasClass('is-invalid') || formtambahmt.find('select').hasClass('is-invalid')) {
      formtambahmt.find('input').removeClass('is-invalid');
      formtambahmt.find('select').removeClass('is-invalid');
    }
  }

  $(document).on('click', '.btntambahrow', function(e) {
    e.preventDefault();
    var index = currIndex++;

    $(".formtambahrow").append(`
            <tr>
              <td>
                <div class="form-body formMultipleInsertBarang">
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
                            <input type="number" <?= $title == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli${index}" name="harga_beli${index}">
                            <div class="invalid-feedback errhargabeli${index}"></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label for="hargajual" class="form-label">Harga Jual Barang</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" <?= $title == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Jual" id="hargajual${index}" name="harga_jual${index}">
                            <div class="invalid-feedback errhargajual${index}"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12" <?= $title == 'Barang Persediaan' ? "hidden" : "" ?>>
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
                  </div>
                </div>
              </td>
              <td class="align-bottom" style="width:1px; white-space:nowrap;">
                <button class="btn btn-danger btn-sm btnhapusrow">
                <i class="fa fa-times"></i> Hapus form ${index}
                </button>
              </td>
            </tr>
            `)

    //hapus tr sebelumnya
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

  $(document).ready(function() {
    $('.batal-formmultiple').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      $('#cardmultipleinsert').hide(500);
    });

    rowCount = $('.formtambahrow tr').length;
    looping(rowCount);

    $('.formsimpanmultiple').submit(function(e) {
      e.preventDefault();
      // mengambil data dari form
      let formdatamultiple = new FormData(this);
      // dapatkan jumlah row
      formdatamultiple.append('jmldata', rowCount);

      $.ajax({
        type: "post",
        url: "<?= $nav; ?>/insertmultiple",
        data: formdatamultiple,
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
            }
          } else {
            formtambahmt.hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              databarang.ajax.reload();
            })
          }
        }
      });
    })
  });
</script>