<div class="card mb-3 shadow" id="cardtransferbarang">
  <div class="card-header shadow-sm">
    <h5 class="card-title">Form Transfer <?= $title ?></h5>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form class="form form-vertical py-2" id="formtrfbarang">
        <?= csrf_field() ?>
        <table class="table table-responsive-lg">
          <thead>
            <th>Form Transfer Barang Multiple</th>
          </thead>
          <tbody class="formtambahrow">
            <?php $row = intval($jmldata);
            for ($i = 1; $i <= $row; $i++) {
            ?>
              <tr>
                <td>
                  <div class="form-body">
                    <div class="row d-flex justify-content-between">
                      <div class="col-12">
                        <h5>Form <?= $i; ?></h5>
                      </div>
                      <div class="col-lg-12">
                        <div class="col-12">
                          <input type="hidden" name="id_<?= $i; ?>" id="id_<?= $i; ?>">
                          <div class="row mb-1">
                            <label for="idbrg<?= $i ?>">Nama Barang</label>
                          </div>
                          <div class="row mb-1">
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                              <select name="barang_id<?= $i; ?>" class="form-select p-2" id="idbrg<?= $i; ?>" style="width: 400px;"></select>
                              <div class="invalid-feedback erridbrg<?= $i; ?>"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="row mb-1">
                            <label for="lokasi<?= $i ?>">Lokasi Penempatan <?= ucwords($title) ?></label>
                          </div>
                          <div class="row mb-1">
                            <div class="input-group mb-3">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                              <select class="form-select" id="lokasi<?= $i; ?>" name="ruang_id<?= $i; ?>"></select>
                              <div class="invalid-feedback errlokasi<?= $i; ?>"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="row g-2 mb-1">
                            <div class="col-md-5">
                              <label for="sisastok<?= $i ?>" class="mb-1">Sisa Stok <?= $jenis_kat ?></label>
                              <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok<?= $i; ?>" id="sisastok<?= $i; ?>" readonly>
                                <div class="invalid-feedback errsisastok<?= $i; ?>"></div>
                              </div>
                            </div>
                            <div class="col-md-5">
                              <label for="jmlkeluar<?= $i ?>" class="mb-1">Jumlah Barang Pindah</label>
                              <div class="input-group mb-3">
                                <input type="number" min="1" class="form-control" id="jmlkeluar<?= $i; ?>" placeholder="Masukkan Jumlah Barang keluar" name="jumlah_keluar<?= $i; ?>">
                                <div class="invalid-feedback errjmlkeluar<?= $i; ?>"></div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <label for="satuan<?= $i ?>" class="mb-1">Satuan</label>
                              <div class="input-group mb-3">
                                <select name="satuan_id_<?= $i; ?>" class="form-select p-2" id="satuan<?= $i; ?>"></select>
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
                              <input type="date" class="form-control" placeholder="Masukkan Tanggal" name="tgl_belilama<?= $i; ?>" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="row">
          <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-white my-4 closeformtrf">Batal</button>
            <button type="submit" class="btn btn-success my-4 btnsimpantrf">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  var rowCount = <?= $row ?>;
  var stoklama = JSON.parse('<?= $stoklama ?>');
  var sisa_stok_lama = [];

  function isiform() {
    $.each(stoklama, function(i, val) {
      sisa_stok_lama.push(val.sisa_stok);
      $('#formtrfbarang').find(`input[name='id_${i+1}']`).val(val.id)
      $('#formtrfbarang').find(`select[name*='barang_id${i+1}']`).html(`<option value="${val.barang_id}" selected >${val.nama_brg}</option>`).prop('disabled', true);
      $('#formtrfbarang').find(`input[name='sisa_stok${i+1}']`).val(val.sisa_stok)
      // $('#formtrfbarang').find(`input[name='jumlah_keluar_${i+1}']`).val(val.jumlah_keluar);
      $('#formtrfbarang').find(`select[name='ruang_id${i+1}']`).html(`<option value='${val.ruang_id}' selected>${val.nama_ruang}</option>`);
      $('#formtrfbarang').find(`select[name='satuan_id_${i+1}']`).html(`<option value='${val.satuan_id}' selected >${val.kd_satuan}</option>`).prop('disabled', true);
      $('#formtrfbarang').find(`input[name='tgl_belilama${i+1}']`).val(val.tgl_beli);
    });
  }

  $(document).ready(function() {
    $('.closeformtrf').click(function(e) {
      e.preventDefault();
      $('#cardtransferbarang').hide(500);
    });

    isiform();
    formlooping(rowCount);

    $('#formtrfbarang').submit(function(e) {
      e.preventDefault();

      let formdatamultiple = new FormData(this); // mengambil data dari form
      formdatamultiple.append('jmldata', rowCount);
      formdatamultiple.append('jenis', "<?= strtolower($jenis_kat) ?>"); // menambahkan data tambahan
      formdatamultiple.append('jenistrx', "transfer <?= strtolower($jenis_kat) ?>"); // menambahkan data tambahan
      $.ajax({
        type: "post",
        url: "<?= $nav ?>/transferbarang",
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
            if (response.error.isSarpras) {
              Swal.fire(
                'Error!',
                response.error.isSarpras,
                'error'
              )
            }
            if (response.error.transStatus) {
              Swal.fire(
                'Error!',
                response.error.transStatus,
                'error'
              )
            }
            for (var i = 1; i <= jmldata; i++) {
              var errlokasi = response.error[`ruang_id${i}`];
              var errjmlkeluar = response.error[`jumlah_keluar${i}`];
              if (errlokasi) {
                $(`#lokasi${i}`).addClass('is-invalid');
                $(`.errlokasi${i}`).html(errlokasi);
              } else {
                $(`#lokasi${i}`).removeClass('is-invalid');
                $(`.errlokasi${i}`).html();
              }
              if (errjmlkeluar) {
                $(`#jmlkeluar${i}`).addClass('is-invalid');
                $(`.errjmlkeluar${i}`).html(errjmlkeluar);
              } else {
                $(`#jmlkeluar${i}`).removeClass('is-invalid');
                $(`.errjmlkeluar${i}`).html();
              }
            }
          } else {
            $('#cardtransferbarang').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              dataalokasi.ajax.reload();
              $('#checkall').prop('checked', false)
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
    })
  });

  function clear_is_invalid() {
    if ($('#formtrfbarang').find('input').hasClass('is-invalid') || $('#formtrfbarang').find('select').hasClass('is-invalid')) {
      $('#formtrfbarang').find('input').removeClass('is-invalid');
      $('#formtrfbarang').find('select').removeClass('is-invalid');
    }
  }

  function clearFormmt(row) {
    $('#formtrfbarang').find("input").val("")
    $('#formtrfbarang').find("select").html("")
  }

  function formlooping(row) {
    for (var i = 1; i <= row; i++) {
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

        $(`#lokasi${j}`).select2({
          placeholder: 'Piih lokasi',
          minimumInputLength: 1,
          allowClear: true,
          width: "50%",
          ajax: {
            url: "<?= $nav . '/pilihlokasi' ?>",
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
        $(`#jmlkeluar${j}`).on('input', function(e) {
          e.preventDefault();
          $(`#jmlkeluar${j}`).removeClass('is-invalid');
          $(`.errorjmlkeluar${j}`).html('');
        })

        $(`#jmlkeluar${j}`).on('input', function(e) {
          e.preventDefault();
          var jumlah_keluar_baru = $(`#jmlkeluar${j}`).val();
          var sisa_stok_baru = sisa_stok_lama[j - 1] - jumlah_keluar_baru;
          $('#formtrfbarang').find(`input[name='sisa_stok${j}']`).val(sisa_stok_baru)
          if ($(`#sisastok${j}`).val() < 0) {
            $('#formtrfbarang').find(`input[name='sisa_stok${j}']`).val(0)
            $(`#sisastok${j}`).addClass('is-invalid');
            $(`.errsisastok${j}`).html('sisa stok tidak boleh kurang dari 0');
            $(`#jmlkeluar${j}`).addClass('is-invalid');
            $(`.errjmlkeluar${j}`).html('input jumlah transfer barang sudah melebihi kapasitas sisa stok');
          } else {
            $('#formtrfbarang').find(`input[name='sisa_stok${j}']`).val(sisa_stok_baru)
            $(`#sisastok${j}`).removeClass('is-invalid');
            $(`.errsisastok${j}`).html('');
            $(`#jmlkeluar${j}`).removeClass('is-invalid');
            $(`.errjmlkeluar${j}`).html('');
          }
        })
      })(i);
    }
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