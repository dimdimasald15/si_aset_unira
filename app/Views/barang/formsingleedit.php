<div class="card mb-3 shadow" id="tampilformeditbarang">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Edit Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="form form-vertical py-4" id="formEditBarang">
      <?= csrf_field() ?>
      <div class="form-body">
        <div class="row d-flex justify-content-between">
          <div class="col-lg-12">
            <input type="hidden" name="id" id="id">
            <div class="row g-2 mb-1">
              <div class="col-md-6">
                <label class="form-label" for="jenis_kat">Jenis Kategori Barang</label>
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="bi bi-layers"></i>
                  </span>
                  <select name="jenis_kat" class="form-select p-2" id="jenis_kat"></select>
                  <div class="invalid-feedback errjenis_kat"></div>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="katid">Nama Kategori</label>
                <div class="input-group mb-3">
                  <span class="input-group-text">
                    <i class="bi bi-layers"></i>
                  </span>
                  <select name="kat_id" class="form-select p-2" id="katid"></select>
                  <div class="invalid-feedback errkatid"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
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
                <label for="skbarang"></label>
                <div class="input-group mb-3">
                  <select name="" class="form-select" id="skbarang"></select>
                  <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other" readonly style="display:none;">
                  <input type="text" class="form-control" placeholder="Kode Barang" id="kodebrg" name="kode_brg" readonly style="display:none;">
                  <div class="invalid-feedback errkodebrg"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="row g-2 mb-1">
              <div class="col-md-4">
                <label for="merk" class="form-label">Merk</label>
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="bi bi-tags"></i></span>
                  <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk" name="merk">
                  <div class="invalid-feedback errmerk"></div>
                </div>
              </div>
              <div class="col-md-4">
                <label for="tipe" class="form-label">Tipe Barang</label>
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                  <input type="text" class="form-control" placeholder="Masukkan tipe" id="tipe" name="tipe">
                  <div class="invalid-feedback errtipe"></div>
                </div>
              </div>
              <div class="col-md-4">
                <label for="warna" class="form-label">Warna</label>
                <div class="input-group mb-3">
                  <span class="input-group-text"><i class="bi bi-palette"></i></span>
                  <select class="form-select" id="warna" name="warna"></select>
                  <div class="invalid-feedback errwarna">
                  </div>
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
                <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="namabarang" name="nama_brg" readonly>
                <div class="invalid-feedback errnamabarang"></div>
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="row g-2 mb-1">
              <div class="col-md-5 mb-3 asalbrg">
                <label class="form-label">Asal <?= $title; ?></label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="asal" id="belibaru" value="Beli baru">
                  <label class="form-check-label" for="belibaru">
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
                <label class="form-label">Beli bekas dimana?</label>
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
          <div class="col-lg-12">
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
          <div class="col-lg-12">
            <div class="row g-2 mb-1">
              <div class="col-md-6">
                <label for="hargabeli" class="form-label">Harga beli/satuan</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">Rp</span>
                  <input type="number" <?= $title == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli" name="harga_beli">
                  <div class="invalid-feedback errhargabeli"></div>
                </div>
              </div>
              <div class="col-md-6">
                <label for="hargajual" class="form-label">Harga jual/satuan</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">Rp</span>
                  <input type="number" <?= $title == "Barang Persediaan" ? 'step="50" min="100"' : 'step="500" min="5000"' ?> class="form-control" placeholder="Masukkan Harga Jual" id="hargajual" name="harga_jual">
                  <div class="invalid-feedback errhargajual"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="row g-2 mb-1">
              <div class="col-md-auto">
                <label for="tglpembelian" class="mb-1">Tanggal Pembelian</label>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                  <input type="date" class="form-control" placeholder="dd/mm/yyyy" id="tglpembelian" name="tgl_pembelian">
                  <div class="invalid-feedback errtglpembelian"></div>
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
                    <input type="number" min="1" class="form-control" id="jmlmasuk" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk">
                    <div class="invalid-feedback errjmlmasuk"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="satuan" class="mb-1">Satuan <?= $title; ?></label>
                  <div class="input-group mb-3">
                    <select name="satuan_id" class="form-select p-2" id="satuan"></select>
                    <div class=" invalid-feedback errsatuan">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4" onClick="util.closeBtn('#tampilformeditbarang')">&laquo; batal</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan">Perbarui</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    let asalbrg1 = $('#belibaru').val();
    let asalbrg2 = $('#belibekas').val();
    let asalbrg3 = $('#hibah').val();
    let saveMethod = "<?= $saveMethod; ?>"
    let globalId = "<?= $id ?>";
    kd_brg = '';

    $.ajax({
      type: "post",
      url: "<?= $nav . '/getbarangbyany' ?>",
      data: {
        id: <?= $id ?>,
      },
      dataType: "json",
      success: function(response) {
        isiForm(response);
      }
    });

    $('#katid').select2({
      placeholder: 'Piih Nama Kategori <?= $title; ?>',
      minimumInputLength: 1,
      allowClear: true,
      width: "80%",
      // initSelection: function(element, callback) {
      //   callback({
      //     id: '',
      //     text: ''
      //   });
      // },
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
        $('#kodebrg').val('');
        clearForm();
      } else {
        getsubkdotherbarang(katid);
        getsubkdbarang(katid);
      }
      $('#katid').removeClass('is-invalid');
      $('.errkdkatid').html('');
      hideskbrgother()
    })

    $(document).on('change', `#katid, #merk, #warna, #tipe`, function(e) {
      e.preventDefault();
      var categories = $(`#katid`).find('option:selected').text();
      var merk = $(`#merk`).val();
      var warna = capitalize($(`#warna`).val());
      var tipe = $(`#tipe`).val();
      $(`#namabarang`).val('')
      if (categories !== null) {
        $(`#namabarang`).val(categories);
      }
      if (categories !== '' && merk !== '') {
        $(`#namabarang`).val(`${categories} ${merk}`);
      }
      if (categories !== '' && merk !== '' && tipe !== '') {
        $(`#namabarang`).val(`${categories} ${merk} ${tipe}`);
      }
      if (categories !== '' && merk !== '' && tipe !== '' && warna !== null) {
        $(`#namabarang`).val(`${categories} ${merk} ${tipe} - ${warna} `);
      }
    })

    $('#skbarang').on('change', function(e) {
      e.preventDefault();
      if ($(this).val() == '') {
        clearformwithtrigger();
        hideskbrgother();
        $('#kodebrg').val('');
      } else if ($('#skbarang').val() == 'otherbrg') {
        clearformwithtrigger();
        $('#skbarang-other').show();
        $('#skbarang-other').val(kdbrgother);
        kd_brg = `${$('#subkdkategori').val()}.${$('#skbarang-other').val()}`;
        $('#kodebrg').val(kd_brg);
      }

      $('#kodebrg').removeClass('is-invalid');
      $('.errkodebrg').html('');
    })

    $(`#warna`).select2({
      placeholder: 'Piih Warna',
      minimumInputLength: 1,
      allowClear: true,
      width: "70%",
      ajax: {
        url: `<?= $nav ?>/pilihwarna`,
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
      templateResult: formatResult2,
    });

    $('input[type="radio"]').click(function() {
      if ($(this).attr('id') == 'belibaru') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
        $('#tampilformeditbarang').find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'belibekas') {
        $('.radiobelibekas').show();
        $('.belibaru').hide();
        $('.hibah').hide();
        $('#tampilformeditbarang').find("input[name='toko']").val('')
        $('#tampilformeditbarang').find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'hibah') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
        $('#tampilformeditbarang').find("input[name='toko']").val('')
      } else if ($(this).attr('id') == 'radiotoko') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
        $('#radioinstansi').prop('checked', false);
        $('#tampilformeditbarang').find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'radioinstansi') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
        $('#radiotoko').prop('checked', false);
        $('#tampilformeditbarang').find("input[name='toko']").val('')
      } else {
        $('.radiobelibekas').hide();
        $('.belibaru').hide();
        $('.hibah').hide();
      }

      $(".option .form-check-input").removeClass("is-invalid");
      $(".erroption").html('');
      $(".asalbrg .form-check-input").removeClass("is-invalid");
      $(".errasalbrg").html('');
    });

    $('#namabarang').on('input', function(e) {
      e.preventDefault();
      $('#namabarang').removeClass('is-invalid');
      $('.errornamabarang').html('');
    })
    $('#merk').on('input', function(e) {
      e.preventDefault();
      $('#merk').removeClass('is-invalid');
      $('.errormerk').html('');
    })
    $('#hargabeli').on('input', function(e) {
      e.preventDefault();
      $('#hargabeli').removeClass('is-invalid');
      $('.errorhargabeli').html('');
    })
    $('#hargajual').on('input', function(e) {
      e.preventDefault();
      $('#hargajual').removeClass('is-invalid');
      $('.errorhargajual').html('');
    })

    $('#satuan').select2({
      placeholder: 'Piih Satuan',
      minimumInputLength: 1,
      allowClear: true,
      width: "100%",
      ajax: {
        url: "<?= $nav ?>/pilihsatuan",
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
    $('#jmlmasuk').on('input', function(e) {
      e.preventDefault();
      $('#jmlmasuk').removeClass('is-invalid');
      $('.errorjmlmasuk').html('');
    })

    $('#formEditBarang').submit(function(e) {
      e.preventDefault();

      let url = ""
      if (saveMethod == "update") {
        url = "<?= $nav ?>/updatebarang/" + globalId;
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpanbarang";
      }

      var formdata = new FormData(this);
      if ($("input[name='asal']:checked").length > 0) {
        var asal = $("input[name='asal']:checked").val();
      } else {
        var asal = '';
      }

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
          const fields = ['katid','kodebrg','namabarang','merk','warna','asalbrg','lokasi','hargabeli','jmlmasuk','satuan'];
          if (response.error) {
            util.handleValidationErrors (fields, response.error);
          } else {
            $('#tampilformeditbarang').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              tableBrgTetap.ajax.reload();
              tableBrgPersediaan.ajax.reload();
              tableAlokasiBrg.ajax.reload();
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

  function isiForm({
    id,
    kat_id,
    kd_kategori,
    nama_kategori,
    kode_brg,
    nama_brg,
    warna,
    tipe,
    merk,
    toko,
    instansi,
    asal,
    no_dokumen,
    no_seri,
    harga_beli,
    harga_jual,
    tgl_pembelian,
    jumlah_masuk,
    ruang_id,
    nama_ruang,
    satuan_id,
    kd_satuan,
    jenis
  }) {
    if (!$.isEmptyObject(kd_kategori)) {
      $('#formEditBarang').find("input[name='id']").val(id);
      $('#formEditBarang').find("select[name='jenis_kat']").html(`<option value="${jenis}">${jenis}</option>`);
      $('#formEditBarang').find("select[name*='kat_id']").html('<option value = "' + kat_id + '" selected >' + nama_kategori + '</option>');
      $('#formEditBarang').find("#subkdkategori").val(kd_kategori)

      kd_brg = kode_brg;

      var kode_brg_split = kode_brg.split(kd_kategori + "."); // split kode_brg berdasarkan kd_kategori
      var last_kode_brg = kode_brg_split[kode_brg_split.length - 1]; // ambil array index terakhir
      var last_3_digit = last_kode_brg.substring(last_kode_brg.length - 3); // ambil 3 angka paling belakang

      getsubkdotherbarang(kat_id);
      getsubkdbarang(kat_id, last_3_digit);
      $('#kodebrg').val(kode_brg);
      hideskbrgother()
    }

    $('#formEditBarang').find("input[name='nama_brg']").val(nama_brg)
    $('#formEditBarang').find("select[name='warna']").html(`
    <option>${warna}</option>
    `)
    $('#formEditBarang').find("input[name='merk']").val(merk)
    $('#formEditBarang').find("input[name='toko']").val(toko)
    $('#formEditBarang').find("input[name='tipe']").val(tipe)
    $('#formEditBarang').find("input[name='instansi']").val(instansi)
    $('#formEditBarang').find("input[name='no_seri']").val(no_seri)
    $('#formEditBarang').find("input[name='no_dokumen']").val(no_dokumen)
    $('#formEditBarang').find("input[name='harga_beli']").val(harga_beli)
    $('#formEditBarang').find("input[name='harga_jual']").val(harga_jual)

    let inputtglbeli = '';
    if (tgl_pembelian !== null) {
      inputtglbeli = tgl_pembelian;
      inputtglbeli = inputtglbeli.split(" ")[0]; // ambil tanggal saja
    } else {
      inputtglbeli = tgl_pembelian;
    }
    $('#formEditBarang').find("input[name='tgl_pembelian']").val(inputtglbeli);

    if (asal === 'Beli baru') {
      $('#belibaru').prop('checked', true);
      $('.belibaru').show();
      $('.hibah').hide();
      $('.radiobelibekas').hide();
    } else if (asal == 'Beli bekas') {
      $('#belibekas').prop('checked', true);
      $('.radiobelibekas').hide();
      if (toko == null || toko == '') {
        $('.belibaru').hide();
        $('.hibah').show();
      } else if (instansi == null || instansi == '') {
        $('.belibaru').show();
        $('.hibah').hide();
      }
    } else if (asal == 'Hibah') {
      $('#hibah').prop('checked', true);
      $('.hibah').show();
      $('.belibaru').hide();
      $('.radiobelibekas').hide();
    } else {
      $('#formEditBarang').find("input[type='radio']").prop('checked', false);
      $('.hibah').hide();
      $('.belibaru').hide();
      $('.radiobelibekas').hide();
    }
    $('#formEditBarang').find("input[name='jumlah_masuk']").val(jumlah_masuk);
    $('#formEditBarang').find("select[name*='ruang_id']").html('<option value = "' + ruang_id + '" selected >' + nama_ruang + '</option>');
    $('#formEditBarang').find("select[name*='satuan_id']").html('<option value = "' + satuan_id + '" selected >' + kd_satuan + '</option>');
  }

  function hideskbrgother() {
    $('#skbarang-other').hide();
  }

  function clearForm() {
    $('#tampilformeditbarang').find("#warna").val('');
    $('#tampilformeditbarang').find("input").val("")
    $('#tampilformeditbarang').find("select").html("")
    $('#tampilformeditbarang').find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();
    $('.radiobelibekas').hide();
    hideskbrgother()
  }

  function clear_is_invalid() {
    if ($('#tampilformeditbarang').find('input').hasClass('is-invalid') || $('#tampilformeditbarang').find('select').hasClass('is-invalid')) {
      $('#tampilformeditbarang').find('input').removeClass('is-invalid');
      $('#tampilformeditbarang').find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    $('#tampilformeditbarang').find('.card-title').html('Tambah <?= $title; ?>');
    $('#tampilformeditbarang').find("button[type='submit']").html('Simpan');
  }

  function getsubkdbarang(idkategori, kode1) {
    $.ajax({
      url: "<?= $nav . '/getsubkdbarang' ?>",
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
        }
        if (response[0].subkdbarang !== undefined) {
          $('#subkdkategori').val(response[0].kd_kategori);
          $.each(response, function(key, value) {
            $('#skbarang').append('<option value="' + value.subkdbarang + '">' + value.subkdbarang + '</option>');
          });
        }

        $('#skbarang').append('<option value="otherbrg">Lainnya</option>');
        if (kode1 !== undefined) {
          $('#skbarang').attr('disabled', 'disabled');
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
        type: "get",
        url: "<?= $nav ?>/getkdbrgbykdkat",
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
    $('#tampilformeditbarang').find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();

    $('#tampilformeditbarang').find("input[name='nama_brg']").val('');
    $('#tampilformeditbarang').find("input[name='harga_beli']").val('');
    $('#tampilformeditbarang').find("input[name='harga_jual']").val('');
    $('#tampilformeditbarang').find("#warna").val('');
    $('#tampilformeditbarang').find("input[name='merk']").val('');
    $('#tampilformeditbarang').find("input[name='tipe']").val('');
    $('#tampilformeditbarang').find("input[name='toko']").val('');
    $('#tampilformeditbarang').find("input[name='instansi']").val('');
    $('#tampilformeditbarang').find("input[name='no_seri']").val('');
    $('#tampilformeditbarang').find("input[name='no_dokumen']").val('');
    $('#tampilformeditbarang').find("input[name='tgl_pembelian']").val('');
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

  function formatResult2(data) {
    if (!data.id) {
      return data.text;
    }
    var $result = $(
      `<span><i class="bi bi-palette"> </i>${data.text} <span class="dot" style="height: 25px;
                        width: 25px;
                        background-color: ${data.kode};
                        border-radius: 50%;
                        display: inline-block;"></span></span>`
    );

    return $result;
  }
</script>