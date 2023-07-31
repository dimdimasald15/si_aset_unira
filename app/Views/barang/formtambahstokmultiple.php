<div class="card mb-3" id="cardTambahStokMultiple">
  <div class="card-header shadow-sm">
    <h5 class="card-title">Form Tambah Stok <?= ucwords($title); ?></h5>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form class="form form-vertical py-2" id="formTambahStokMultiple">
        <?= csrf_field() ?>
        <?php $row = 1; ?>
        <table class="table table-responsive-lg">
          <thead>
            <th>Form Tambah Stok Multiple</th>
            <th>Action</th>
          </thead>
          <tbody class="formtambahrow">
            <tr>
              <td>
                <div class="form-body">
                  <div class="row d-flex justify-content-between">
                    <div class="col-12">
                      <h5>Form <?= $row; ?></h5>
                    </div>
                    <div class="col-lg-12">
                      <input type="hidden" name="id[]" id="id<?= $row ?>">
                      <div class="row g-2 mb-1">
                        <div class="col-md-6">
                          <label class="form-label" for="jenis_kat<?= $row ?>">Jenis Kategori Barang</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text">
                              <i class="bi bi-layers"></i>
                            </span>
                            <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat<?= $row ?>">
                              <option value="">Pilih Jenis Kategori Barang</option>
                              <option value="Barang Tetap">Barang Tetap</option>
                              <option value="Barang Persediaan">Barang Persediaan</option>
                            </select>
                            <div class="invalid-feedback errjenis_kat<?= $row ?>"></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="idbrg<?= $row ?>">Nama Barang</label>
                          <div class="row mb-1">
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                              <select name="barang_id[]" class="form-select p-2" id="idbrg<?= $row; ?>"></select>
                              <div class="invalid-feedback erridbrg<?= $row; ?>"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="row mb-1">
                          <label for="lokasi<?= $row ?>">Lokasi Penempatan <?= ucwords($title) ?></label>
                        </div>
                        <div class="row mb-1">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                            <select class="form-select" id="lokasi<?= $row; ?>" name="ruang_id[]"></select>
                            <div class="invalid-feedback errlokasi<?= $row; ?>"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="row g-2 mb-1">
                          <div class="col-md-5">
                            <label class="mb-1">Sisa Stok</label>
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                              <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok<?= $row ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <label for="jmlmasuk<?= $row ?>" class="mb-1">Jumlah <?= $title ?></label>
                            <div class="input-group mb-3">
                              <input type="number" min="1" class="form-control" id="jmlmasuk<?= $row; ?>" placeholder="Masukkan Jumlah <?= $title ?>" name="jumlah_masuk[]">
                              <div class="invalid-feedback errjmlmasuk<?= $row; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="satuan<?= $row ?>" class="mb-1">Satuan</label>
                            <div class="input-group mb-3">
                              <select name="satuan_id[]" class="form-select p-2" id="satuan<?= $row; ?>"></select>
                              <div class="invalid-feedback errsatuan"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-5">
                          <label class="mb-1">Tanggal Pembelian Sebelumnya</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama<?= $row ?>" name="tgl_belilama[]" readonly>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <label for="tglbeli<?= $row ?>" class="mb-1">Tanggal Pembelian Baru</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli<?= $row; ?>" name="tgl_pembelian[]">
                            <div class="invalid-feedback errtglbeli<?= $row; ?>"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td class="align-bottom" style="width:1px; white-space:nowrap;">
                <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrowstok" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="row">
          <div class="col-6 d-flex justify-content-start">
            <button type="button" class="btn btn-primary my-4 btn-sm btntambahrowstok"><i class="fa fa-plus"></i>Tambah Form</button>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <button type="button" class="btn btn-white my-4 backformmultiple">&laquo; Kembali</button>
            <button type="submit" class="btn btn-success my-4 btnsimpanmultiple">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  var lastNumbstok = parseInt("<?= $row ?>");
  var currIndexstok = lastNumbstok + 1;
  var rowCountstok = '';

  function loadLokasistok(row) {
    if (lokasiSarprasCache) {
      // jika data lokasi sudah tersedia di cache, gunakan data tersebut
      $(`#lokasi${row}`).html(`<option value='${lokasiSarprasCache[0].id}' selected>${lokasiSarprasCache[0].text}</option>`);
    } else {
      // jika data lokasi belum tersedia di cache, muat data baru dari server
      $.ajax({
        type: "get",
        url: "<?= $nav ?>/pilihlokasi",
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

  function clear_is_invalid() {
    if ($('#formTambahStokMultiple').find('input').hasClass('is-invalid') || $('#formTambahStokMultiple').find('select').hasClass('is-invalid')) {
      $('#formTambahStokMultiple').find('input').removeClass('is-invalid');
      $('#formTambahStokMultiple').find('select').removeClass('is-invalid');
    }
  }

  function clearFormmt(row) {
    $('#formTambahStokMultiple').find("input").val("")
    $('#formTambahStokMultiple').find("select").html("")
  }

  //check duplikat barang
  idbrgSet = new Set();

  function checkBarangDuplikat(row) {
    let idbrg = $(`#idbrg${row}`).val();

    if (idbrgSet.has(idbrg)) {
      Swal.fire({
        icon: 'info',
        text: 'Nama barang sudah dimasukkan sebelumnya! Sistem akan mengosongkan input barang.',
      }).then((result) => {
        $(`#idbrg${row}`).html('');
        $(`#satuan${row}`).html('');
        $(`#sisastok${row}']`).val("")
        $(`#tglbelilama${row}']`).val("")
      });
    } else {
      idbrgSet.add(idbrg);
    }
  }

  $(document).ready(function() {
    var saveMethod = "<?= $saveMethod ?>";
    rowCountstok = $('.formtambahrow tr').length;
    loopingstok(rowCountstok);
    loadLokasistok(rowCountstok);

    $('.backformmultiple').on('click', function() {
      // Hapus semua baris kecuali baris pertama
      $('.formtambahrow tr').slice(1).remove();
      $('#cardTambahStokMultiple').hide(500);
      clear_is_invalid();
      clearFormmt(rowCountstok);
      $('.optionmt').show(500);
      $('#opsi1mt').prop('checked', false);
      $('#opsi2mt').prop('checked', false);
    });

    $('.btntambahrowstok').on('click', function(e) {
      e.preventDefault();
      var index = currIndexstok++;

      $(".formtambahrow").append(`
      <tr>
        <td>
          <div class="form-body">
            <div class="row d-flex justify-content-between">
              <div class="col-12">
                <h5>Form ${index}</h5>
              </div>
              <div class="col-lg-12">
              <input type="hidden" name="id[]" id="id${index}">
              <div class="row g-2 mb-1">
                <div class="col-md-6">
                  <label class="form-label" for="jenis_kat${index}">Jenis Kategori Barang</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text">
                      <i class="bi bi-layers"></i>
                    </span>
                    <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat${index}">
                      <option value="">Pilih Jenis Kategori Barang</option>
                      <option value="Barang Tetap">Barang Tetap</option>
                      <option value="Barang Persediaan">Barang Persediaan</option>
                    </select>
                    <div class="invalid-feedback errjenis_kat${index}"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="idbrg${index}">Nama Barang</label>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                      <select name="barang_id[]" class="form-select p-2" id="idbrg${index}"></select>
                      <div class="invalid-feedback erridbrg${index}"></div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="lokasi${index}">Lokasi Penempatan Stok <?= ucwords($title) ?></label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                      <select class="form-select" id="lokasi${index}" name="ruang_id[]"></select>
                      <div class="invalid-feedback errlokasi${index}"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-5">
                      <label class="mb-1">Sisa Stok</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                        <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok${index}" readonly>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <label for="jmlmasuk${index}" class="mb-1">Jumlah <?= $title ?></label>
                      <div class="input-group mb-3">
                        <input type="number" min="1" class="form-control" id="jmlmasuk${index}" placeholder="Masukkan Jumlah <?= $title ?>" name="jumlah_masuk[]">
                        <div class="invalid-feedback errjmlmasuk${index}"></div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label for="satuan${index}" class="mb-1">Satuan</label>
                      <div class="input-group mb-3">
                        <select name="satuan_id[]class="form-select p-2" id="satuan${index}"></select>
                        <div class="invalid-feedback errsatuan"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-5">
                    <label  class="mb-1">Tanggal Pembelian Sebelumnya</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama${index}" name="tgl_belilama[]" readonly>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <label for="tglbeli${index}" class="mb-1">Tanggal Pembelian Baru</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli${index}" name="tgl_pembelian[]">
                      <div class="invalid-feedback errtglbeli${index}"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </td>
        <td class="align-bottom" style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrowstok" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
        </td>
      </tr>
      `);

      rowCountstok = $('.formtambahrow tr').length;

      loopingstok(rowCountstok);

      $(".formtambahrow tr:last-child .btnhapusrowstok").show();
    });

    $(document).on('click', '.btnhapusrowstok', function(e) {
      e.preventDefault();
      // hapus tr yang diklik
      $(this).parents('tr').remove();
      currIndexstok--;

      if (currIndexstok <= lastNumbstok) {
        currIndexstok = lastNumbstok + 1;
      }

      //hapus tr sebelumnya
      rowCountstok = $('.formtambahrow tr').length;
      for (var i = 0; i < rowCountstok; i++) {
        $('.formtambahrow tr').find('.btnhapusrowstok').hide();
      }
      rowCountstok === 1 ? $('.formtambahrow tr').find('.btnhapusrowstok').hide() :
        $(".formtambahrow tr:last-child .btnhapusrowstok").show();
    })

    $('#formTambahStokMultiple').submit(function(e) {
      e.preventDefault();
      var url = "<?= $nav ?>/updatedatastokmultiple";

      let formdatamultiple = new FormData(this); // mengambil data dari form
      formdatamultiple.append('jmldata', rowCountstok);

      $.ajax({
        type: "post",
        url: url,
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
              var errjenis_kat = response.error[`jenis_kat.${i-1}`];
              var erridbrg = response.error[`barang_id.${i-1}`];
              var errjmlmasuk = response.error[`jumlah_masuk.${i-1}`];
              var errtglbeli = response.error[`tgl_pembelian.${i-1}`];

              if (errjenis_kat) {
                $(`#jenis_kat${i}`).addClass('is-invalid');
                $(`.errjenis_kat${i}`).html(errjenis_kat);
              } else {
                $(`#jenis_kat${i}`).removeClass('is-invalid');
                $(`.errjenis_kat${i}`).html('');
              }

              if (erridbrg) {
                $(`#idbrg${i}`).addClass('is-invalid');
                $(`.erridbrg${i}`).html(erridbrg);
              } else {
                $(`#idbrg${i}`).removeClass('is-invalid');
                $(`.erridbrg${i}`).html();
              }

              if (errjmlmasuk) {
                $(`#jmlmasuk${i}`).addClass('is-invalid');
                $(`.errjmlmasuk${i}`).html(errjmlmasuk);
              } else {
                $(`#jmlmasuk${i}`).removeClass('is-invalid');
                $(`.errjmlmasuk${i}`).html();
              }

              if (errtglbeli) {
                $(`#tglbeli${i}`).addClass('is-invalid');
                $(`.errtglbeli${i}`).html(errtglbeli);
              } else {
                $(`#tglbeli${i}`).removeClass('is-invalid');
                $(`.errtglbeli${i}`).html();
              }
            }
          } else {
            $('.viewtambahmultiple').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              tableBrgTetap.ajax.reload();
              tableBrgPersediaan.ajax.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          Swal.fire(
            'Error!',
            'Terjadi kesalahan saat mengirim data karena tidak ada data yang diubah',
            'error'
          )
        }
      });
      return false;
    });

  });

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }
    if (data.asal) {
      var $result = $(
        `<span><i class="bi bi-box"> </i>${data.text} (${data.asal})</span>`);
    } else {
      var $result = $(
        `<span><i class="bi bi-layers"> </i>${data.text}</span>`);
    }



    return $result;
  }

  function loopingstok(row) {
    for (var i = 1; i <= row; i++) {
      $('.formtambahrow tr').find('.btnhapusrowstok').hide();

      (function(j) {
        $(`#jenis_kat${j}`).on('change', function(e) {
          e.preventDefault();
          var jenis_kat = $(this).val();
          $(`#idbrg${j}`).select2({
            placeholder: 'Piih Nama Barang',
            minimumInputLength: 1,
            allowClear: true,
            width: "80%",
            ajax: {
              url: `<?= $nav ?>/pilihbarang`,
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
          $(`#jenis_kat${j}`).removeClass('is-invalid');
          $(`.errjenis_kat${j}`).html('');
        })
      })(i);

      (function(j) {
        $(`#satuan${j}`).select2({
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

        $(`#lokasi${j}`).on('change', function(e) {
          e.preventDefault();
          $(`#lokasi${j}`).removeClass('is-invalid');
          $(`.errorlokasi${j}`).html('');
        })
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
        $(`#tglbeli${j}`).on('input', function(e) {
          e.preventDefault();
          $(`#tglbeli${j}`).removeClass('is-invalid');
          $(`.errtglbeli${j}`).html();
        })

        $(`#idbrg${j}`).on('change', function(e) {
          e.preventDefault();
          $(`#idbrg${j}`).removeClass('is-invalid');
          $(`.erroridbrg${j}`).html('');

          checkBarangDuplikat(j);

          var b_id = $(`#idbrg${j}`).val();
          var r_id = $(`#lokasi${j}`).val();

          if (b_id != null && r_id != null) {
            $.ajax({
              type: "post",
              url: "<?= $nav ?>/cekbrgdanruang",
              data: {
                barang_id: b_id,
                ruang_id: r_id,
              },
              dataType: "json",
              success: function(response) {
                if (response) {
                  $(`#id${j}`).val(response.id);
                  $(`#sisastok${j}`).val(response.sisa_stok);
                  $(`#tglbelilama${j}`).val(response.tgl_beli);
                  $(`#satuan${j}`).prop('disabled', true);
                  $(`#satuan${j}`).html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
                }
              }
            });
          } else {
            $(`#id_${j}`).val('');
            $(`#satuan${j}`).prop('disabled', false);
            $(`#satuan${j}`).html('');
            $(`#sisastok${j}`).html('');
            $(`#tglbelilama${j}`).html('');
          }
        });

      })(i);

      loadLokasistok(i);
    }
  }
</script>