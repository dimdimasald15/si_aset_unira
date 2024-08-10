<div class="modal fade" id="modaltransfer" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="title"><?= $title ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="form form-vertical py-2" id="formtrfbarang">
        <div class="modal-body modal-body-label">
          <div class="container">
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
                              <input type="hidden" name="id[]" id="id<?= $i; ?>">
                              <div class="row mb-1">
                                <label for="idbrg<?= $i ?>">Nama Barang</label>
                              </div>
                              <div class="row mb-1">
                                <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                                  <select name="barang_id[]" class="form-select p-2" id="idbrg<?= $i; ?>"></select>
                                  <div class="invalid-feedback erridbrg<?= $i; ?>"></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="row mb-1">
                                <label for="lokasi<?= $i ?>">Lokasi Penempatan Barang</label>
                              </div>
                              <div class="row mb-1">
                                <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                  <select class="form-select" id="lokasi<?= $i; ?>" name="ruang_id[]"></select>
                                  <div class="invalid-feedback errlokasi<?= $i; ?>"></div>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="row g-2 mb-1">
                                <div class="col-md-5">
                                  <label for="sisastok<?= $i ?>" class="mb-1">Sisa Stok</label>
                                  <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok<?= $i; ?>" readonly>
                                    <div class="invalid-feedback errsisastok<?= $i; ?>"></div>
                                  </div>
                                </div>
                                <div class="col-md-5">
                                  <label for="jmlkeluar<?= $i ?>" class="mb-1">Jumlah Barang Pindah</label>
                                  <div class="input-group mb-3">
                                    <input type="number" min="1" class="form-control" id="jmlkeluar<?= $i; ?>" placeholder="Masukkan Jumlah Barang keluar" name="jumlah_keluar[]">
                                    <div class="invalid-feedback errjmlkeluar<?= $i; ?>"></div>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <label for="satuan<?= $i ?>" class="mb-1">Satuan</label>
                                  <div class="input-group mb-3">
                                    <select name="satuan_id[]" class="form-select p-2" id="satuan<?= $i; ?>"></select>
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
                                  <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama<?= $i ?>" name="tgl_belilama[]" readonly>
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
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
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
      $(`#id${i+1}`).val(val.id)
      $(`#idbrg${i+1}`).html(`<option value="${val.barang_id}" selected >${val.nama_brg}</option>`).prop('disabled', true);
      $(`#sisastok${i+1}`).val(val.sisa_stok)
      $(`#lokasi${i+1}`).html(`<option value='${val.ruang_id}' selected>${val.nama_ruang}</option>`);
      $(`#satuan${i+1}`).html(`<option value='${val.satuan_id}' selected >${val.kd_satuan}</option>`).prop('disabled', true);
      $(`#tglbelilama${i+1}`).val(val.tgl_beli);
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

      let formdata = new FormData(this); // mengambil data dari form
      formdata.append('jmldata', rowCount);
      $.ajax({
        type: "post",
        url: `${nav}/transferbarang`,
        data: formdata,
        headers: {
          authorization: `Bearer ${token}`
        },
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
            let errorMessage = '';

            if (response.error.isSarpras) {
              errorMessage = response.error.isSarpras;
            } else if (response.error.transStatus) {
              errorMessage = response.error.transStatus;
            }

            if (errorMessage !== '') {
              Swal.fire('Error!', errorMessage, 'error');
            }

            for (var i = 1; i <= jmldata; i++) {
              var errlokasi = response.error[`ruang_id.${i-1}`];
              var errjmlkeluar = response.error[`jumlah_keluar.${i-1}`];
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
            $(`#modaltransfer`).modal('hide');
            Swal.fire(
              'Berhasil!',
              response.success,
              'success'
            ).then((result) => {
              $('#checkall').prop('checked', false)
              tableBrgTetap.ajax.reload();
              tableAlokasiBrg.ajax.reload();
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
        selectOption.satuan(`satuan${j}`);
        selectOption.lokasi(`lokasi${j}`);
        const inputId = ["lokasi"];
        util.initializeValidationHandlers(inputId, j);

        $(`#jmlkeluar${j}`).on('input', function(e) {
          e.preventDefault();
          $(`#jmlkeluar${j}`).removeClass('is-invalid');
          $(`.errorjmlkeluar${j}`).html('');
          var jumlah_keluar_baru = $(`#jmlkeluar${j}`).val();
          var sisa_stok_baru = sisa_stok_lama[j - 1] - jumlah_keluar_baru;
          $(`#sisastok${j}`).val(sisa_stok_baru)
          if ($(`#sisastok${j}`).val() < 0) {
            $(`#sisastok${j}`).val(0)
            $(`#sisastok${j}`).addClass('is-invalid');
            $(`.errsisastok${j}`).html('sisa stok tidak boleh kurang dari 0');
            $(`#jmlkeluar${j}`).addClass('is-invalid');
            $(`.errjmlkeluar${j}`).html('input jumlah transfer barang sudah melebihi kapasitas sisa stok');
          } else {
            $(`sisa_stok${j}`).val(sisa_stok_baru)
            $(`#sisastok${j}`).removeClass('is-invalid');
            $(`.errsisastok${j}`).html('');
            $(`#jmlkeluar${j}`).removeClass('is-invalid');
            $(`.errjmlkeluar${j}`).html('');
          }
        })
      })(i);
    }
  }
</script>