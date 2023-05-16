<div class="card mb-3 shadow" id="tampilformkembai">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Form <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form action="<?= $nav ?>/pengembalian" class="formkembali py-4">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="namaanggota" class="form-label">Nama Peminjam</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <select class="form-select" name="anggota_id" id="idanggota"></select>
              <div class="invalid-feedback erridanggota"></div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="tglpinjam" class="form-label">Tanggal Peminjaman</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
              <input type="date" class="form-control" id="tglpinjam" name="tgl_pinjam">
              <div class="invalid-feedback errtglpinjam"></div>
            </div>
          </div>
        </div>
      </div>
      <div id="tabledatabrg" style="display:none;">
        <table class="table table-responsive-sm table-borderless">
          <thead class="text-center">
            <th style="display:none;">Id</th>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah Peminjaman</th>
            <th>Tanggal Kembali</th>
            <th>Kondisi Kembali</th>
            <th>Status</th>
          </thead>
          <tbody id="tambahrow">
          </tbody>
        </table>
      </div>
      <div class=" row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4 back-form">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan"> Kembalikan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('#tabledatabrg').hide();
    $('.back-form').on('click', function() {
      $('#tampilsingleform').hide(500);
      $('.viewform').hide(500)
    });

    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/peminjamancontroller/pilihanggota",
      dataType: "json",
      success: function(response) {
        $('#idanggota').empty();
        $('#idanggota').append('<option value="">Pilih Anggota</option>');
        $.each(response, function(key, value) {
          $('#idanggota').append('<option value="' + value.id + '">' + value.nama_anggota + '</option>');
        });
      }
    });

    $('#idanggota').on('change', function(e) {
      e.preventDefault();
      $(`#idanggota`).removeClass('is-invalid')
      $('.erridanggota').html('');
    })
    $('#tglpinjam').on('change', function(e) {
      e.preventDefault();
      $(`#tglpinjam`).removeClass('is-invalid')
      $('.errtglpinjam').html('');
    })

    $(document).on('change', '#idanggota, #tglpinjam', function(e) {
      e.preventDefault();
      var idanggota = $('#idanggota').val();
      var tglpinjam = $('#tglpinjam').val();
      if (idanggota !== "" && tglpinjam !== "") {
        $.ajax({
          type: "get",
          url: "<?= base_url() ?>/peminjamancontroller/getdatapeminjaman",
          data: {
            anggota_id: idanggota,
            tglpinjam: tglpinjam,
          },
          dataType: "json",
          success: function(response) {
            $('#tabledatabrg').show();
            $('#tambahrow').empty();
            if (response.jmldata != 0) {
              $.each(response.data, function(i, val) {
                var isChecked = val.status == 1 ? 'checked disabled' : '';
                var isBack = val.tgl_kembali == null ? '' : 'disabled';
                var checkboxVal = val.status == 1 ? '1' : '0';
                var bgtext = val.status == 1 ? '<span class="badge bg-primary">Sudah Kembali</span>' : '<span class="badge bg-danger">Belum Kembali</span>'
                $('#tambahrow').append(`
                  <tr>
                    <td style="display:none;">
                      <input name="id[]" id="id${i}" value='${val.id}'>
                    </td>
                    <td>${i+1}</td>
                    <td>
                      <input type="hidden" name="barang_id[]" id="idbrg${i}" value='${val.barang_id}'>${val.nama_brg}
                    </td>
                    <td class=align-center">
                        <input type="hidden" name="jml_barang[]" id="idbrg${i}" value='${val.jml_barang}'>${val.jml_barang} ${val.kd_satuan}</td>
                    <td>
                      <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                        <input type="date" class="form-control" id="tglkembali${i}" name="tgl_kembali${i}" value="${val.tgl_kembali}" ${isBack}>
                        <div class="invalid-feedback errtglkembali${i}"></div>
                      </div>
                    </td>   
                    <td>
                    <select class="form-select" name="kondisi_kembali${i}" id="kondisi${i}">
                      <option value="" selected disabled>Pilih kondisi</option>
                      <option value="Baik">Baik</option>
                      <option value="Rusak ringan">Rusak ringan</option>
                      <option value="Rusak berat">Rusak berat</option>
                    </select>
                    <div class="invalid-feedback errkondisi${i}"></div>
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input mt-0" type="checkbox" name="status[]" id="status${i}" value="${checkboxVal}" ${isChecked}>
                        <label for="status">${bgtext}</label>
                      </div>
                    </td>
                  </tr>
                `);

                $(`#tglkembali${i}`).on('input', function(e) {
                  e.preventDefault();
                  $(`#tglkembali${i}`).removeClass(`is-invalid`)
                  $(`.errtglkembali${i}`).html(``);
                  $(`#status${i}`).prop('checked', true);
                  $(`#status${i}`).val(1);
                  $(`#status${i}`).siblings('label').html('<span class="badge bg-primary">Sudah Kembali</span>');
                })
                $(`#kondisi${i}`).on('change', function(e) {
                  e.preventDefault();
                  $(`#kondisi${i}`).removeClass(`is-invalid`)
                  $(`.errkondisi${i}`).html(``);
                })

                $(`#status${i}`).on('change', function(e) {
                  e.preventDefault();
                  if ($(this).prop('checked')) {
                    $(this).val(1);
                    $(this).siblings('label').html('<span class="badge bg-primary">Sudah Kembali</span>');
                    $(`#tglkembali${i}`).val();
                  } else {
                    $(this).val(0);
                    $(this).siblings('label').html('<span class="badge bg-danger">Belum Kembali</span>');
                    $(`#tglkembali${i}`).val('');
                  }
                })

              });
            } else {
              swal.fire('Data Kosong', `${response.nama_anggota} tidak melakukan peminjaman pada tanggal ${tglpinjam}`, 'info');
              $('#tabledatabrg').hide();
              $('#tambahrow').empty();
            }
          }
        });
      } else {
        $('#tabledatabrg').hide();
        $('#tambahrow').empty();
      }
    })

    $('.formkembali').submit(function(e) {
      e.preventDefault();
      var rowCount = $('#tambahrow tr').length;

      var formdata = new FormData(this);
      formdata.append('jenistrx', "Pengembalian Barang");
      formdata.append('jmldata', rowCount);

      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: formdata,
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
          if (response.error) {
            var erridanggota = response.error.anggota_id;
            var errtglpinjam = response.error.tgl_pinjam;
            if (erridanggota) {
              $(`#idanggota`).addClass('is-invalid')
              $('.erridanggota').html(erridanggota);
            } else {
              $(`#idanggota`).removeClass('is-invalid')
              $('.erridanggota').html('');
            }
            if (errtglpinjam) {
              $(`#tglpinjam`).addClass('is-invalid')
              $('.errtglpinjam').html(errtglpinjam);
            } else {
              $(`#tglpinjam`).removeClass('is-invalid')
              $('.errtglpinjam').html('');
            }
            jmldata = response.jmldata;
            for (i = 0; i < jmldata; i++) {
              var errkondisi = response.error[`kondisi_kembali${i}`];
              var errtglkembali = response.error[`tgl_kembali${i}`];
              if (errkondisi) {
                $(`#kondisi${i}`).addClass('is-invalid')
                $(`.errkondisi${i}`).html(errkondisi);
              } else {
                $(`#kondisi${i}`).removeClass(`is-invalid`)
                $(`.errkondisi${i}`).html(``);
              }
              if (errtglkembali) {
                $(`#tglkembali${i}`).addClass(`is-invalid`)
                $(`.errtglkembali${i}`).html(errtglkembali);
              } else {
                $(`#tglkembali${i}`).removeClass(`is-invalid`)
                $(`.errtglkembali${i}`).html(``);
              }
            }
          } else {
            $('#tampilformkembali').hide(500);
            $('.viewform').hide(500)
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              datapinjam.ajax.reload();
            })
          }
        }
      });
    });
  });
</script>