<div class="card mb-3 shadow" id="tampilsingleform">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="formpeminjaman py-4">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="idanggota" class="form-label">Nama Peminjam</label>
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
              <input type="datetime-local" class="form-control" id="tglpinjam" name="tgl_pinjam">
              <div class="invalid-feedback errtglpinjam"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row mb-1">
          <label for="keterangan">Keterangan <?= $title; ?></label>
        </div>
        <div class="row mb-1">
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
            <div class="invalid-feedback errketerangan"></div>
          </div>
        </div>
      </div>
      <?php $no = 1; ?>
      <div class="table-responsive">
        <table class="table table-borderless">
          <thead>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Sisa Stok</th>
            <th>Jumlah peminjaman</th>
            <th>Satuan</th>
            <th <?= $saveMethod == 'update' ? 'hidden' : '' ?>>#</th>
          </thead>
          <tbody id="tambahrow">
            <tr>
              <td><?= $no ?></td>
              <td>
                <select name="barang_id<?= $no ?>" class="form-select p-2" id="idbrg<?= $no ?>" style="width: 400px;"></select>
                <div class="invalid-feedback erridbrg<?= $no ?>"></div>
              </td>
              <td> <input type="number" class="form-control" id="sisastok<?= $no ?>" placeholder="Sisa Stok" disabled>
                <div class="invalid-feedback errsisastok<?= $no ?>"></div>
              </td>
              <td> <input type="number" min="1" class="form-control" id="jumlah<?= $no ?>" placeholder="Masukkan Jumlah Barang" name="jml_barang<?= $no ?>">
                <div class="invalid-feedback errjumlah<?= $no ?>"></div>
              </td>
              <td>
                <select name="satuan_id<?= $no ?>" class="form-select p-2" id="satuan<?= $no ?>"></select>
                <div class="invalid-feedback errsatuan<?= $no ?>"></div>
              </td>
              <td style="width:1px; white-space:nowrap;" <?= $saveMethod == 'update' ? 'hidden' : '' ?>>
                <button type="button" class="btn btn-primary btn-sm btntambahrow"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-danger btn-sm btnhapusrow" style="display:none;"><i class="fa fa-times"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="viewalert" style="display:none;"></div>
      <div class=" row">
        <div class="col-12 d-flex justify-content-end">
          <button type="button" class="btn btn-white my-4 back-form">&laquo; Kembali</button>
          <button type="submit" class="btn btn-success my-4 btnsimpan"><?= $saveMethod == 'update' ? 'Ubah' : 'Simpan' ?></button>
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

  function disabledinput() {
    // Menambahkan atribut disabled
    $('input[name="nama_anggota"]').prop('disabled', true);
    $('input[name="no_hp"]').prop('disabled', true);
    $('select[name="unit_id"]').prop('disabled', true);
    $('select[name="level"]').prop('disabled', true);
  }

  function removedisabledinput() {
    // Menghilangkan atribut disabled
    $('input[name="nama_anggota"]').prop('disabled', false);
    $('input[name="no_hp"]').prop('disabled', false);
    $('select[name="unit_id"]').prop('disabled', false);
    $('select[name="level"]').prop('disabled', false);
  }

  $(document).ready(function() {
    let saveMethod = "<?= $saveMethod ?>";
    rowCount = $('#tambahrow tr').length;
    $('.anggotabaru').hide();
    disabledinput();

    looping(rowCount);

    $('.noanggota').hide();
    $('.viewalert').hide();
    $('.back-form').on('click', function() {
      $('#tampilsingleform').hide(500);
      $('.viewform').hide(500)
    });

    $(`#idanggota`).select2({
      placeholder: 'Piih Nama Anggota',
      minimumInputLength: 1,
      allowClear: true,
      width: "80%",
      ajax: {
        url: `<?= $nav ?>/pilihanggota`,
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

    $('#tglpinjam').on('input', function(e) {
      e.preventDefault();
      $('#tglpinjam').removeClass('is-invalid');
      $('.errortglpinjam').html('');
    })

    $('#keterangan').on('input', function(e) {
      e.preventDefault();
      $('#keterangan').removeClass('is-invalid');
      $('.errorketerangan').html('');
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
        <td> <input type="number" class="form-control" id="sisastok${index}" placeholder="Sisa Stok" disabled>
          <div class="invalid-feedback errsisastok${index}"></div>
        </td>
        <td> <input type="number" min="1" class="form-control" id="jumlah${index}" placeholder="Masukkan Jumlah Barang" name="jml_barang${index}">
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

    if (saveMethod == "update") {
      $('#tampilsingleform').find('.card-title').html('Ubah Data <?= $title ?>');
      $('.viewalert').show().html(`
      <div class="alert alert-info" role="alert">
        <div class="row">
          <div class="col-sm-1 d-flex align-items-center justify-content-end">
            <p class="fs-1"><i class="bi bi-info-circle"></i></p>
          </div>
          <div class="col-sm-10 p-0">
          <p>Jika anda mencoba mengubah nama barang sesuai dengan nama barang yang sudah ada di dalam table peminjaman, maka perintah update akan terus dilanjutkan dengan menghapus data peminjaman ini, lalu menambahkan jumlah peminjaman data barang yang sudah ada.</p>
          </div>
          <div class="col-sm-1">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
      </div>
      `)
      var globalId = "<?= $globalId ?>";

      $.ajax({
        type: "get",
        url: "<?= $nav ?>/getpeminjamanbyid",
        data: {
          id: globalId
        },
        dataType: "json",
        success: function(response) {
          isiForm(response.data, response.jmldata);
        }
      });
    }

    $('.formpeminjaman').submit(function(e) {
      e.preventDefault();

      if (saveMethod == "add") {
        url = "<?= $nav ?>/simpan";
      } else if (saveMethod == "update") {
        url = "<?= $nav ?>/update/" + globalId;
      }

      var formdata = new FormData(this);
      formdata.append('jmlbrg', rowCount);
      formdata.append('jenistrx', "Peminjaman Barang");

      $.ajax({
        type: "post",
        url: url,
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
            erranggotaid = response.error.anggota_id;
            errnamaanggota = response.error.nama_anggota;
            errlevel = response.error.level;
            errnoanggota = response.error.no_anggota;
            errunit = response.error.unit_id;
            errtglpinjam = response.error.tgl_pinjam;
            errketerangan = response.error.keterangan;

            if (errtglpinjam) {
              $('#tglpinjam').addClass('is-invalid');
              $('.errtglpinjam').html(errtglpinjam);
            } else {
              $('#tglpinjam').removeClass('is-invalid');
              $('.errtglpinjam').html('');
            }
            if (erranggotaid) {
              $('#idanggota').addClass('is-invalid');
              $('.erridanggota').html(erranggotaid);
            } else {
              $('#idanggota').removeClass('is-invalid');
              $('.erridanggota').html('');
            }
            if (errnamaanggota) {
              $('#namaanggota').addClass('is-invalid');
              $('.errnamaanggota').html(errnamaanggota);
            } else {
              $('#namaanggota').removeClass('is-invalid');
              $('.errnamaanggota').html('');
            }
            if (errlevel) {
              $('#level').addClass('is-invalid');
              $('.errlevel').html(errlevel);
            } else {
              $('#level').removeClass('is-invalid');
              $('.errlevel').html('');
            }
            if (errnoanggota) {
              $('#noanggota').addClass('is-invalid');
              $('.errnoanggota').html(errnoanggota);
            } else {
              $('#noanggota').removeClass('is-invalid');
              $('.errnoanggota').html('');
            }
            if (errunit) {
              $('#unit').addClass('is-invalid');
              $('.errunit').html(errunit);
            } else {
              $('#unit').removeClass('is-invalid');
              $('.errunit').html('');
            }
            if (errketerangan) {
              $('#keterangan').addClass('is-invalid');
              $('.errketerangan').html(errketerangan);
            } else {
              $('#keterangan').removeClass('is-invalid');
              $('.errketerangan').html('');
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
              datapinjam.ajax.reload();
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
        url: "<?= $nav ?>/pilihunit",
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

  var sisa_stok_lama = [];
  var jumlah_lama = [];

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
              url: "<?= $nav ?>/cekbrgdanruang",
              data: {
                barang_id: b_id,
                ruang_id: r_id,
              },
              dataType: "json",
              success: function(response) {
                if (response) {
                  $(`#satuan${j}`).prop('disabled', true);
                  $(`#satuan${j}`).html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
                  $(`#sisastok${j}`).val(response.sisa_stok);
                  if ("<?= $saveMethod ?>" == "update") {
                    sisa_stok_lama.pop();
                    $(`#jumlah${j}`).val('');
                  }
                  sisa_stok_lama.push(response.sisa_stok);
                }
              }
            });
          } else {
            $(`#sisastok${j}`).html('');
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

        $(`#satuan${j}`).on('change', function(e) {
          e.preventDefault();
          $(`#satuan${j}`).removeClass('is-invalid');
          $(`.errorsatuan${j}`).html('');
        })
        $(`#jumlah${j}`).on('input', function(e) {
          $(`#jumlah${j}`).removeClass('is-invalid');
          $(`.errorjumlah${j}`).html('');
          if ($(this).val() == '') {
            if ("<?= $saveMethod ?>" == "update") {
              var sisa_stok_update = parseInt(sisa_stok_lama[j - 1]) + parseInt(jumlah_lama[j - 1]);
              $('.formpeminjaman').find(`input[name='sisa_stok${j}']`).val(sisa_stok_update);
            } else {
              $('.formpeminjaman').find(`input[name='sisa_stok${j}']`).val(sisa_stok_lama[j - 1]);
            }
          } else {
            var jml_minta = $(this).val();
            if ("<?= $saveMethod ?>" == "update") {
              var sisa_stok_baru = parseInt(sisa_stok_lama[j - 1]) + parseInt(jumlah_lama[j - 1]) - parseInt(jml_minta);
            } else {
              var sisa_stok_baru = parseInt(sisa_stok_lama[j - 1]) - parseInt(jml_minta);
            }
            $(`#sisastok${j}`).val(sisa_stok_baru);
          }
          if ($(`#sisastok${j}`).val() < 0) {
            $(`#sisastok${j}`).val(0)
            $(`#sisastok${j}`).addClass('is-invalid');
            $(`.errsisastok${j}`).html('sisa stok tidak boleh kurang dari 0');
            $(`#jumlah${j}`).addClass('is-invalid');
            $(`.errjumlah${j}`).html('input tidak boleh lebih dari ' + sisa_stok_lama[j - 1]);
          } else {
            $(`#sisastok${j}`).val(sisa_stok_baru)
            $(`#sisastok${j}`).removeClass('is-invalid');
            $(`.errsisastok${j}`).html('');
            $(`#jmlkeluar${j}`).removeClass('is-invalid');
            $(`.errjmlkeluar${j}`).html('');
          }
        })
      })(i)

    }
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
        $(`#sisastok${row}`).html('');
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

    var result;
    if (data.no !== undefined) {
      $result = $(
        `<span><i class="bi bi-person"> </i>${data.no} - ${data.text} (${data.unit})</span>`
      );
    } else {
      $result = $(
        `<span><i class="bi bi-circle-square"> </i>${data.text}</span>`
      );
    }

    return $result;
  }

  function isiForm({
    id,
    anggota_id,
    nama_anggota,
    tgl_pinjam,
    barang_id,
    keterangan,
    jml_barang,
    nama_brg,
    sisa_stok,
    satuan_id,
    kd_satuan
  }, jmldata) {
    $('#idanggota').html(`
        <option value="${anggota_id}">${nama_anggota}</option>
      `);
    $('#tglpinjam').val(tgl_pinjam);
    $('#keterangan').val(keterangan);
    for (let i = 1; i <= jmldata; i++) {
      $(`#idbrg${i}`).html(`
        <option value="${barang_id}">${nama_brg}</option>
      `);
      sisa_stok_lama.push(parseInt(sisa_stok));
      jumlah_lama.push(parseInt(jml_barang));
      $(`#sisastok${i}`).val(sisa_stok);
      $(`#jumlah${i}`).val(jml_barang);
      $(`#satuan${i}`).prop('disabled', true);
      $(`#satuan${i}`).html(`
        <option value="${satuan_id}">${kd_satuan}</option>
      `);
    }
  }
</script>