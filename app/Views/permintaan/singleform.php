<div class="card mb-3 shadow" id="tampilsingleform">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form action="<?= $nav ?>/simpandata" class="formpermintaan py-4">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="namaanggota" class="form-label">Nama <?= $title == "Permintaan Barang" ? 'Peminta' : 'Peminjam' ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" placeholder="Masukkan Nama Anggota" id="namaanggota" name="nama_anggota">
              <div class="invalid-feedback errnamaanggota"></div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="level" class="form-label">Level <?= $title == "Permintaan Barang" ? 'Peminta' : 'Peminjam' ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
              <select name="level" class="form-select p-2" id="level">
                <option value="" disabled selected>Pilih Level</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Mahasiswa">Mahasiswa</option>
              </select>
              <div class="invalid-feedback errlevel"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6 noanggota" style="display:none;"></div>
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="unit mb-2">Unit Asal</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
                <select name="unit_id" class="form-select p-2" id="unit" style="width: 400px;"></select>
                <div class="invalid-feedback errunit"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $no = 1; ?>
      <table class="table table-responsive-sm table-borderless">
        <thead>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Jumlah Permintaan</th>
          <th>Satuan</th>
          <th>#</th>
        </thead>
        <tbody id="tambahrow">
          <tr>
            <td><?= $no ?></td>
            <td>
              <select name="barang_id<?= $no ?>" class="form-select p-2" id="idbrg<?= $no ?>" style="width: 400px;"></select>
              <div class="invalid-feedback erridbrg<?= $no ?>"></div>
            </td>
            <td> <input type="number" min="1" class="form-control" id="jumlah<?= $no ?>" placeholder="Masukkan Jumlah Permintaan Barang" name="jml_barang<?= $no ?>">
              <div class="invalid-feedback errjumlah<?= $no ?>"></div>
            </td>
            <td>
              <select name="satuan_id<?= $no ?>" class="form-select p-2" id="satuan<?= $no ?>"></select>
              <div class="invalid-feedback errsatuan<?= $no ?>"></div>
            </td>
            <td style="width:1px; white-space:nowrap;">
              <button type="button" class="btn btn-primary btn-sm btntambahrow"><i class="fa fa-plus"></i></button>
              <button type="button" class="btn btn-danger btn-sm btnhapusrow" style="display:none;"><i class="fa fa-times"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4 back-form">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  lastNumb = parseInt("<?= $no ?>");
  currIndex = lastNumb + 1;
  var rowCount = '';
  var level = '';

  $(document).ready(function() {
    rowCount = $('#tambahrow tr').length;
    looping(rowCount);
    $('.noanggota').hide()
    $('.back-form').on('click', function() {
      $('#tampilsingleform').hide(500);
      $('.viewform').hide(500)
    });

    $('#level').on('change', function(e) {
      e.preventDefault();
      $('#level').removeClass('is-invalid');
      $('.errorlevel').html('');

      level = $('#level').val();
      pilihunit(level);

      $('.noanggota').hide().html('');
      if (level == 'Mahasiswa') {
        $('.noanggota').show().append(
          `<label for="noanggota" class="form-label">NIM</label>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control" placeholder="Masukkan NIM" id="noanggota" name="no_anggota">
            <div class="invalid-feedback errnoanggota"></div>
          </div>`
        );
      } else if (level == 'Karyawan') {
        $('.noanggota').show().append(
          `<label for="noanggota" class="form-label">Nomor Pegawai</label>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control" placeholder="Masukkan Nomor Pegawai" id="noanggota" name="no_anggota">
            <div class="invalid-feedback errnoanggota"></div>
          </div>`
        );
      } else {
        $('.noanggota').hide().html('');
      }
    })

    pilihunit(level);

    $('#unit').on('change', function(e) {
      e.preventDefault();
      $('#unit').removeClass('is-invalid');
      $('.errorunit').html('');
    })

    $('#namaanggota').on('input', function(e) {
      e.preventDefault();
      $('#namaanggota').removeClass('is-invalid');
      $('.errornamaanggota').html('');
    })

    $('#noanggota').on('input', function(e) {
      e.preventDefault();
      $('#noanggota').removeClass('is-invalid');
      $('.errornoanggota').html('');
    })

    $('.btntambahrow').on('click', function(e) {
      e.preventDefault();
      var index = currIndex++;
      $("#tambahrow").append(`
      <tr>
        <td>${index}</td>
        <td>
          <select name="barang_id${index}" class="form-select p-2" id="idbrg${index}" style="width: 400px;"></select>
          <div class="invalid-feedback erridbrg${index}"></div>
        </td>
        <td> <input type="number" min="1" class="form-control" id="jumlah${index}" placeholder="Masukkan Jumlah Permintaan Barang" name="jml_barang${index}">
          <div class="invalid-feedback errjumlah${index}"></div>
        </td>
        <td>
          <select name="satuan_id${index}" class="form-select p-2" id="satuan${index}"></select>
          <div class="invalid-feedback errsatuan${index}"></div>
        </td>
        <td style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger btn-sm btnhapusrow"><i class="fa fa-times"></i></button>
        </td>
      </tr>
    `);
      rowCount = $('#tambahrow tr').length;

      looping(rowCount);

      $("#tambahrow tr:last-child .btnhapusrow").show();
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
      rowCount = $('#tambahrow tr').length;
      for (var i = 0; i < rowCount; i++) {
        $('#tambahrow tr').find('.btnhapusrow').hide();
      }

      rowCount === 1 ? $('#tambahrow tr').find('.btnhapusrow').hide() :
        $("#tambahrow tr:last-child .btnhapusrow").show();
    })

    $('.formpermintaan').submit(function(e) {
      e.preventDefault();

      var formdata = new FormData(this);
      formdata.append('jmlbrg', rowCount);
      formdata.append('jenistrx', "Permintaan Barang");

      $.ajax({
        type: "post",
        url: "<?= $nav ?>/simpan",
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
          console.log(response);
          if (response.error) {
            if (response.error.namaanggota) {
              $('#namaanggota').addClass('is-invalid');
              $('.errnamaanggota').html(response.error.namaanggota);
            } else {
              $('#namaanggota').removeClass('is-invalid');
              $('.errnamaanggota').html('');
            }
            if (response.error.level) {
              $('#level').addClass('is-invalid');
              $('.errlevel').html(response.error.level);
            } else {
              $('#level').removeClass('is-invalid');
              $('.errlevel').html('');
            }
            if (response.error.noanggota) {
              $('#noanggota').addClass('is-invalid');
              $('.errnoanggota').html(response.error.noanggota);
            } else {
              $('#noanggota').removeClass('is-invalid');
              $('.errnoanggota').html('');
            }
            if (response.error.unit) {
              $('#unit').addClass('is-invalid');
              $('.errunit').html(response.error.unit);
            } else {
              $('#unit').removeClass('is-invalid');
              $('.errunit').html('');
            }

            jmldata = parseInt(response.jmldata);
            for (i = 1; i <= jmldata; i++) {
              var erridbrg = response.error[`barang_id${i}`];
              var errsatuan = response.error[`satuan_id${i}`];
              var errjumlah = response.error[`jml_barang${i}`];
              if (erridbrg) {
                $(`#idbrg${i}`).addClass(`is-invalid`);
                $(`.erridbrg${i}`).html(erridbrg);
              } else {
                $(`#idbrg${i}`).removeClass(`is-invalid`);
                $(`.erridbrg${i}`).html(``);
              }
              if (errsatuan) {
                $(`#satuan${i}`).addClass(`is-invalid`);
                $(`.errsatuan${i}`).html(errsatuan);
              } else {
                $(`#satuan${i}`).removeClass(`is-invalid`);
                $(`.errsatuan${i}`).html(``);
              }
              if (errjumlah) {
                $(`#jumlah${i}`).addClass(`is-invalid`);
                $(`.errjumlah${i}`).html(errjumlah);
              } else {
                $(`#jumlah${i}`).removeClass(`is-invalid`);
                $(`.errjumlah${i}`).html(``);
              }
            }
          } else {
            $('#tampilsingleform').hide(500);
            $('.viewform').hide(500)
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              dataminta.ajax.reload();
            })
          }
        }
      });
    })
  });

  function pilihunit(level) {
    $('#unit').select2({
      placeholder: 'Piih Unit',
      minimumInputLength: 1,
      allowClear: true,
      width: "70%",
      ajax: {
        url: "<?= base_url() ?>/permintaancontroller/pilihunit",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
            level: level,
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
  }

  function looping(row) {
    for (var i = 1; i <= row; i++) {
      $('#tambahrow tr').find('.btnhapusrow').hide();

      (function(j) {
        $(`#idbrg${j}`).select2({
          placeholder: 'Piih Nama Barang',
          minimumInputLength: 1,
          allowClear: true,
          width: "100%",
          ajax: {
            url: `<?= base_url() ?>/barangcontroller/pilihbarang`,
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

        $(`#idbrg${j}`).on('change', function(e) {
          e.preventDefault();
          $(`#idbrg${j}`).removeClass('is-invalid');
          $(`.erroridbrg${j}`).html('');
          $(`#satuan${j}`).removeClass('is-invalid');
          $(`.errorsatuan${j}`).html('');

          checkBarangDuplikat(j);

          var b_id = $(`#idbrg${j}`).val();
          var r_id = 54;

          if (b_id != null && r_id != null) {
            $.ajax({
              type: "post",
              url: "<?= base_url() ?>/barangcontroller/cekbrgdanruang",
              data: {
                barang_id: b_id,
                ruang_id: r_id,
              },
              dataType: "json",
              success: function(response) {
                if (response) {
                  // $(`#satuan${j}`).prop('disabled', true);
                  $(`#satuan${j}`).html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
                }
              }
            });
          } else {
            $(`#jumlah${j}`).html('');
            $(`#satuan${j}`).prop('disabled', false);
            $(`#satuan${j}`).html('');
          }
        });


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
        $(`#jumlah${j}`).on('input', function(e) {
          e.preventDefault();
          $(`#jumlah${j}`).removeClass('is-invalid');
          $(`.errorjumlah${j}`).html('');
        })
      })(i)

    }
  }

  //check duplikat barang
  idbrgSet = new Set();

  function checkBarangDuplikat(row) {
    let idbrg = $(`#idbrg${row}`).val();
    console.log(idbrg);

    if (idbrgSet.has(idbrg)) {
      Swal.fire({
        icon: 'info',
        text: 'Nama barang sudah dimasukkan sebelumnya! Sistem akan mengosongkan input barang.',
      }).then((result) => {
        $(`#idbrg${row}`).html('');
        $(`#satuan${row}`).html('');
        $(`#jumlah${row}`).val("");
      });
    } else {
      idbrgSet.add(idbrg);
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