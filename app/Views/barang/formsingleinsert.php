<div class="card mb-3 shadow" id="tampilformtambahbarang">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <div class="row px-4 py-4 option">
      <div class="col-lg-12">
        <h6>Pilihan tambah barang</h6>
      </div>
      <div class="col-lg-12">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="opsi1">
          <label class="form-check-label" for="opsi1">
            Barang belum terdaftar di database
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="opsi2">
          <label class="form-check-label" for="opsi2">
            Barang sudah terdaftar di database (Tambah stok dan update tanggal pembelian)
          </label>
          <div class="invalid-feedback erroption"></div>
        </div>
      </div>
    </div>
    <div class="row option">
      <div class="col-12 d-flex justify-content-end">
        <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
        <button type="button" class="btn btn-primary my-4 btnnext">Lanjutkan</button>
      </div>
    </div>
    <form class="form form-vertical py-4" id="formTambahBarang" style="display:none;">
      <?= csrf_field() ?>
      <div class="form-body">
        <div class="row d-flex justify-content-between">
          <div class="col-lg-12">
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
                <label for="subkodebarang"></label>
                <div class="input-group mb-3">
                  <select name="" class="form-select" id="skbarang"></select>
                  <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other" readonly style="display:none;">
                  <input type="text" class="form-control" placeholder="Kode Barang" id="kodebrg" name="kode_brg" readonly style="display:none;">
                  <div class="invalid-feedback errkodebrg"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
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
          <div class="col-lg-12">
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
          <div class="col-lg-12">
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
                  <select class="form-select lokasi" name="ruang_id"></select>
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
                    <input type="number" min="1" class="form-control jmlmasuk" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk">
                    <div class="invalid-feedback errjmlmasuk"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="" class="mb-1">Satuan <?= $title; ?></label>
                  <div class="input-group mb-3">
                    <select name="satuan_id" class="form-select p-2 satuan"></select>
                    <div class="invalid-feedback errsatuan"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4 back-form">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
        </div>
      </div>
    </form>
    <div class="viewformstok" style="display:none;"></div>
  </div>
</div>
<script>
  $(document).ready(function() {
    let asalbrg1 = $('#belibaru').val();
    let asalbrg2 = $('#belibekas').val();
    let asalbrg3 = $('#hibah').val();
    let saveMethod = "<?= $saveMethod; ?>"
    kd_brg = '';

    loadLokasi();

    $('#formTambahBarang').hide();
    $('.viewformstok').hide();

    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      $('#tampilformtambahbarang').hide(500);
    });

    $('.back-form').on('click', function() {
      $('#formTambahBarang').hide(500);
      $('.viewformstok').hide(500);
      $('.option').show(500);
      $('#opsi1').prop('checked', false);
      $('#opsi2').prop('checked', false);
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
      } else {
        // clearformwithtrigger();
        kodebrglama = `${$('#subkdkategori').val()}.${$('#skbarang').val()}`
        // hideskbrgother()
        var kodebrgbaru;
        $.ajax({
          type: "post",
          url: "<?= base_url() ?>" + '/barangcontroller/getbarangbyany',
          data: {
            kode_brg: kodebrglama,
          },
          dataType: "json",
          success: function(response) {
            Swal.fire({
              icon: 'warning',
              text: `${response.nama_brg} dengan kode barang ${response.kode_brg} sudah ada, lebih baik lakukan update barang melalui menu update barang. Sistem akan merekomendasikan opsi lain untuk subkode barang.`,
            }).then((result) => {
              $('#skbarang').val('otherbrg');
              $('#skbarang-other').show(500);
              $('#skbarang-other').val(kdbrgother);
              kodebrgbaru = `${$('#subkdkategori').val()}.${$('#skbarang-other').val()}`;
              $('#kodebrg').val(kodebrgbaru);
            })
          }
        });
      }
      $('#kodebrg').removeClass('is-invalid');
      $('.errkodebrg').html('');
    })

    $('.btnnext').on('click', function() {
      var optionSelected = false;
      $('.option .form-check-input').each(function() {
        if ($(this).is(':checked')) {
          optionSelected = true;
          $(".option .form-check-input").removeClass("is-invalid");
          $(".erroption").html('');
          return false; // break out of the loop
        }
      });
      if (!optionSelected) {
        $(".option .form-check-input").addClass("is-invalid");
        $(".erroption").html('Pilih salah satu opsi');
        return; // stop here, don't proceed to the next form
      }

      if ($('#opsi1').is(':checked')) {
        $('.option').hide(500);
        $('#formTambahBarang').show(500);
        $('.viewformstok').hide();
      } else if ($('#opsi2').is(':checked')) {
        $('.option').hide(500);
        $.ajax({
          type: "post",
          url: "<?= base_url() ?>/barangcontroller/tampiltambahstok",
          data: {
            title: jenistrx,
            jenis_kat: jenis_kat,
            jenistrx: `Tambah Stok ${jenis_kat} di Sarpras`,
            nav: "<?= $nav ?>",
            saveMethod: "update",
          },
          dataType: "json",
          success: function(response) {
            $('.viewformstok').html(response.data).show(500);
            loadLokasi()
          }
        });
        $('#formTambahBarang').hide();
      }
    });

    $('input[type="radio"]').click(function() {
      if ($(this).attr('id') == 'belibaru') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
        $('#tampilformtambahbarang').find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'belibekas') {
        $('.radiobelibekas').show();
        $('.belibaru').hide();
        $('.hibah').hide();
        $('#tampilformtambahbarang').find("input[name='toko']").val('')
        $('#tampilformtambahbarang').find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'hibah') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
        $('#tampilformtambahbarang').find("input[name='toko']").val('')
      } else if ($(this).attr('id') == 'radiotoko') {
        $('.belibaru').show();
        $('.radiobelibekas').hide();
        $('.hibah').hide();
        $('#radioinstansi').prop('checked', false);
        $('#tampilformtambahbarang').find("input[name='instansi']").val('')
      } else if ($(this).attr('id') == 'radioinstansi') {
        $('.belibaru').hide();
        $('.radiobelibekas').hide();
        $('.hibah').show();
        $('#radiotoko').prop('checked', false);
        $('#tampilformtambahbarang').find("input[name='toko']").val('')
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

    $('.satuan').select2({
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

    $('.lokasi').on('change', function(e) {
      e.preventDefault();
      $('.lokasi').removeClass('is-invalid');
      $('.errorlokasi').html('');
    })
    $('.satuan').on('change', function(e) {
      e.preventDefault();
      $('.satuan').removeClass('is-invalid');
      $('.errorsatuan').html('');
    })
    $('.jmlmasuk').on('input', function(e) {
      e.preventDefault();
      $('.jmlmasuk').removeClass('is-invalid');
      $('.errorjmlmasuk').html('');
    })

    $('#formTambahBarang').submit(function(e) {
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
      formdata.append('jenistrx', "<?= $jenistrx ?>");

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
            if (response.error.kodebrg) {
              $('#kodebrg').addClass('is-invalid');
              $('.errkodebrg').html(response.error.kodebrg);
            } else {
              $('#kodebrg').removeClass('is-invalid');
              $('.errkodebrg').html('');
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
              $(".errasalbrg").html(response.error.asal);
            } else {
              $(".asalbrg .form-check-input").removeClass("is-invalid");
              $(".errasalbrg").html('');
            }
            if (response.error.lokasi) {
              $(`.lokasi`).addClass('is-invalid');
              $(`.errlokasi`).html(response.error.lokasi);
            } else {
              $(`.lokasi`).removeClass('is-invalid');
              $(`.errlokasi`).html('');
            }
            if (response.error.hargabeli) {
              $(`#hargabeli`).addClass('is-invalid');
              $(`.errhargabeli`).html(response.error.hargabeli);
            } else {
              $(`#hargabeli`).removeClass('is-invalid');
              $(`.errhargabeli`).html('');
            }
            if (response.error.hargajual) {
              $(`#hargajual`).addClass('is-invalid');
              $(`.errhargajual`).html(response.error.hargajual);
            } else {
              $(`#hargajual`).removeClass('is-invalid');
              $(`.errhargajual`).html('');
            }
            if (response.error.jmlmasuk) {
              $(`.jmlmasuk`).addClass('is-invalid');
              $(`.errjmlmasuk`).html(response.error.jmlmasuk);
            } else {
              $(`.jmlmasuk`).removeClass('is-invalid');
              $(`.errjmlmasuk`).html('');
            }
            if (response.error.satuan) {
              $(`.satuan`).addClass('is-invalid');
              $(`.errsatuan`).html(response.error.satuan);
            } else {
              $(`.satuan`).removeClass('is-invalid');
              $(`.errsatuan`).html('');
            }
          } else {
            $('#tampilformtambahbarang').hide(500);
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

  // fungsi untuk memuat opsi lokasi dengan menggunakan teknik caching
  function loadLokasi() {
    if (lokasiSarprasCache) {
      // jika data lokasi sudah tersedia di cache, gunakan data tersebut
      $('.lokasi').html(`<option value='${lokasiSarprasCache[0].id}' selected>${lokasiSarprasCache[0].text}</option>`);
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
          $('.lokasi').html(`<option value='${response[0].id}' selected>${response[0].text}</option>`);
        }
      });
    }
  }

  function hideskbrgother() {
    $('#skbarang-other').hide();
  }

  function clearForm() {
    $('#tampilformtambahbarang').find("#warna").val('#000000');
    $('#tampilformtambahbarang').find("input").val("")
    $('#tampilformtambahbarang').find("select").html("")
    $('#tampilformtambahbarang').find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();
    $('.radiobelibekas').hide();
    hideskbrgother()
  }

  function clear_is_invalid() {
    if ($('#tampilformtambahbarang').find('input').hasClass('is-invalid') || $('#tampilformtambahbarang').find('select').hasClass('is-invalid')) {
      $('#tampilformtambahbarang').find('input').removeClass('is-invalid');
      $('#tampilformtambahbarang').find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    $('#tampilformtambahbarang').find('.card-title').html('Tambah <?= $title; ?>');
    $('#tampilformtambahbarang').find("button[type='submit']").html('Simpan');
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
    $('#tampilformtambahbarang').find("input[type='radio']").prop('checked', false);
    $('.hibah').hide();
    $('.belibaru').hide();

    $('#tampilformtambahbarang').find("input[name='nama_brg']").val('');
    $('#tampilformtambahbarang').find("input[name='harga_beli']").val('');
    $('#tampilformtambahbarang').find("input[name='harga_jual']").val('');
    $('#tampilformtambahbarang').find("#warna").val('#000000');
    $('#tampilformtambahbarang').find("input[name='merk']").val('');
    $('#tampilformtambahbarang').find("input[name='toko']").val('');
    $('#tampilformtambahbarang').find("input[name='instansi']").val('');
    $('#tampilformtambahbarang').find("input[name='no_seri']").val('');
    $('#tampilformtambahbarang').find("input[name='no_dokumen']").val('');
    $('#tampilformtambahbarang').find("input[name='tgl_pembelian']").val('');
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
</script>