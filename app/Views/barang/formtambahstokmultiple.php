<div class="card mb-3" id="cardTambahStokMultiple">
  <div class="card-header shadow-sm">
    <h5 class="card-title">Form Tambah <?= ucwords($title); ?></h5>
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
                      <div class="col-12">
                        <input type="hidden" name="id_<?= $row; ?>" id="id_<?= $row; ?>">
                        <div class="row mb-1">
                          <label for="idbrg<?= $row ?>">Nama Barang</label>
                        </div>
                        <div class="row mb-1">
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                            <select name="barang_id<?= $row; ?>" class="form-select p-2" id="idbrg<?= $row; ?>" style="width: 400px;"></select>
                            <div class="invalid-feedback erridbrg<?= $row; ?>"></div>
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
                            <select class="form-select" id="lokasi<?= $row; ?>" name="ruang_id_<?= $row; ?>"></select>
                            <div class="invalid-feedback errlokasi<?= $row; ?>"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="row g-2 mb-1">
                          <div class="col-md-5">
                            <label class="mb-1">Sisa Stok <?= $jenis_kat ?></label>
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                              <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok<?= $row; ?>" readonly>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <label for="jmlmasuk<?= $row ?>" class="mb-1">Jumlah Barang Masuk</label>
                            <div class="input-group mb-3">
                              <input type="number" min="1" class="form-control" id="jmlmasuk<?= $row; ?>" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk_<?= $row; ?>">
                              <div class="invalid-feedback errjmlmasuk<?= $row; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <label for="satuan<?= $row ?>" class="mb-1">Satuan</label>
                            <div class="input-group mb-3">
                              <select name="satuan_id_<?= $row; ?>" class="form-select p-2" id="satuan<?= $row; ?>"></select>
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
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal" name="tgl_belilama<?= $row; ?>" readonly>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <label for="tglbeli<?= $row ?>" class="mb-1">Tanggal Pembelian Baru</label>
                          <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                            <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli<?= $row; ?>" name="tgl_pembelian_<?= $row; ?>">
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
        $('#formTambahStokMultiple').find(`input[name='sisa_stok${row}']`).val("")
        $('#formTambahStokMultiple').find(`input[name='tgl_belilama${row}']`).val("")
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
                <div class="col-12">
                  <input type="hidden" name="id_${index}" id="id_${index}">
                  <div class="row mb-1">
                    <label for="idbrg${index}">Nama Barang</label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                      <select name="barang_id${index}" class="form-select p-2" id="idbrg${index}" style="width: 400px;"></select>
                      <div class="invalid-feedback erridbrg${index}"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="lokasi${index}">Lokasi Penempatan <?= ucwords($title) ?></label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                      <select class="form-select" id="lokasi${index}" name="ruang_id_${index}"></select>
                      <div class="invalid-feedback errlokasi${index}"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-5">
                      <label class="mb-1">Sisa Stok <?= $jenis_kat ?></label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                        <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok${index}" readonly>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <label for="jmlmasuk${index}" class="mb-1">Jumlah Barang Masuk</label>
                      <div class="input-group mb-3">
                        <input type="number" min="1" class="form-control" id="jmlmasuk${index}" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk_${index}">
                        <div class="invalid-feedback errjmlmasuk${index}"></div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label for="satuan${index}" class="mb-1">Satuan</label>
                      <div class="input-group mb-3">
                        <select name="satuan_id_${index}" class="form-select p-2" id="satuan${index}"></select>
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
                      <input type="date" class="form-control" placeholder="Masukkan Tanggal" name="tgl_belilama${index}" readonly>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <label for="tglbeli${index}" class="mb-1">Tanggal Pembelian Baru</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli${index}" name="tgl_pembelian_${index}">
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
      let url = "";

      if (saveMethod == "update") {
        url = "<?= $nav ?>/updatedatastokmultiple";
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpanstok";
      }

      let formdatamultiple = new FormData(this); // mengambil data dari form
      formdatamultiple.append('jmldata', rowCountstok);
      formdatamultiple.append('jenistrx', "<?= $jenistrx ?>"); // menambahkan data tambahan

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
              var erridbrg = response.error[`barang_id${i}`];
              if (erridbrg) {
                $(`#idbrg${i}`).addClass('is-invalid');
                $(`.erridbrg${i}`).html(erridbrg);
              } else {
                $(`#idbrg${i}`).removeClass('is-invalid');
                $(`.erridbrg${i}`).html();
              }
              var errjmlmasuk = response.error[`jumlah_masuk_${i}`];
              if (errjmlmasuk) {
                $(`#jmlmasuk${i}`).addClass('is-invalid');
                $(`.errjmlmasuk${i}`).html(errjmlmasuk);
              } else {
                $(`#jmlmasuk${i}`).removeClass('is-invalid');
                $(`.errjmlmasuk${i}`).html();
              }
              var errtglbeli = response.error[`tgl_pembelian_${i}`];
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
              databarang.ajax.reload();
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

    var $result = $(
      `<span><i class="bi bi-layers"> </i>${data.text}</span>`
    );

    return $result;
  }

  function loopingstok(row) {
    for (var i = 1; i <= row; i++) {
      $('.formtambahrow tr').find('.btnhapusrowstok').hide();

      (function(j) {
        $(`#idbrg${j}`).select2({
          placeholder: 'Piih Nama <?= $title ?>',
          minimumInputLength: 1,
          allowClear: true,
          width: "50%",
          ajax: {
            url: `<?= $nav ?>/pilihbarang`,
            dataType: 'json',
            delay: 250,
            data: function(params) {
              return {
                search: params.term,
                jenis_kat: "<?= $jenis_kat ?>",
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

        $(`#idbrg${j}`).on('change', function(e) {
          e.preventDefault();
          $(`#idbrg${j}`).removeClass('is-invalid');
          $(`.erroridbrg${j}`).html('');

          checkBarangDuplikat(j);

          var b_id = $(`#idbrg${j}`).val();
          var r_id = $(`#formTambahStokMultiple`).find(`select[name="ruang_id_${j}"]`).val();

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
                  $('#formTambahStokMultiple').find(`input[name='id_${j}']`).val(response.id);
                  $('#formTambahStokMultiple').find(`input[name='sisa_stok${j}']`).val(response.sisa_stok);
                  $('#formTambahStokMultiple').find(`input[name='tgl_belilama${j}']`).val(response.tgl_beli);
                  $(`#satuan${j}`).prop('disabled', true);
                  $('#formTambahStokMultiple').find(`select[name*='satuan_id_${j}']`).html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
                }
              }
            });
          } else {
            $(`#id_${j}`).val('');
            $(`#satuan${j}`).prop('disabled', false);
            $('#formTambahStokMultiple').find(`select[name*='satuan_id_${j}']`).html('');
          }
        });

      })(i);

      loadLokasistok(i);
    }
  }
</script>