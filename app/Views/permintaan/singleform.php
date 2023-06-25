<div class="card mb-3 shadow" id="tampilsingleform">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="formpermintaan py-4">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <!-- <input type="hidden" name="id" id="id"> -->
        <div class="row g-2 mb-1">
          <div class="col-md-4">
            <label for="namaanggota" class="form-label">Nama Peminta</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <select class="form-select" name="anggota_id" id="idanggota"></select>
              <div class="invalid-feedback erridanggota"></div>
            </div>
          </div>
          <div class="col-md-4 anggotabaru">
            <label for="namaanggota" class="form-label">Nama Peminta Baru</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control anggotabaru" placeholder="Masukkan Nama Anggota" style="display:none;" id="namaanggota" name="nama_anggota" disabled>
              <div class="invalid-feedback errnamaanggota"></div>
            </div>
          </div>
          <div class="col-md-4 anggotabaru">
            <label for="level" class="form-label">Level Peminta Baru</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
              <select name="level" class="form-select p-2" id="level" disabled>
                <option value="" disabled selected>Pilih Level</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Mahasiswa">Mahasiswa</option>
              </select>
              <div class="invalid-feedback errlevel"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 anggotabaru">
        <div class="row g-2 mb-1">
          <div class="col-md-6 noanggota" style="display:none;"></div>
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="unit">Unit Asal Peminta Baru</label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
                <select name="unit_id" class="form-select p-2" id="unit" style="width: 400px;" disabled></select>
                <div class="invalid-feedback errunit"></div>
              </div>
            </div>
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
            <th>Jumlah Permintaan</th>
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
              <td> <input type="text" class="form-control" id="sisastok<?= $no ?>" placeholder="Sisa Stok Barang" name="sisa_stok<?= $no ?>" readonly>
                <div class="invalid-feedback errsisastok<?= $no ?>"></div>
              </td>
              <td> <input type="number" min="1" class="form-control" id="jumlah<?= $no ?>" placeholder="Masukkan Jumlah Permintaan Barang" name="jml_barang<?= $no ?>">
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
  var sisa_stok_lama = [];
  var jumlah_lama = [];

  function disabledinput() {
    // Menambahkan atribut disabled
    $('input[name="nama_anggota"]').prop('disabled', true);
    $('select[name="unit_id"]').prop('disabled', true);
    $('select[name="level"]').prop('disabled', true);
  }

  function removedisabledinput() {
    // Menghilangkan atribut disabled
    $('input[name="nama_anggota"]').prop('disabled', false);
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

    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihanggota",
      dataType: "json",
      success: function(response) {
        $('#idanggota').empty();
        $('#idanggota').append('<option value="">Pilih Anggota</option>');
        $.each(response, function(key, val) {
          $('#idanggota').append(`
          <option value="${val.id}">${val.nama_anggota} - ${val.level == "Mahasiswa"? `NIM ${val.no_anggota}`:`NIDN/NIY ${val.no_anggota}`} - ${val.singkatan}</option>
          `);
        });
        if ("<?= $saveMethod !== "update" ?>") {
          $('#idanggota').append('<option value="other">Lainnya</option>');
        }
      }
    });

    $('#idanggota').on('change', function(e) {
      e.preventDefault();
      $('#idanggota').removeClass('is-invalid');
      $('.erridanggota').html('');

      if ($(this).val() == "") {
        $('.anggotabaru').hide();
      } else if ($(this).val() == "other") {
        $('.anggotabaru').show();
        removedisabledinput();
      } else {
        $('.anggotabaru').hide();
      }
    })

    $('#level').on('change', function(e) {
      e.preventDefault();
      $('#level').removeClass('is-invalid');
      $('.errlevel').html('');

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
        <td> <input type="number" class="form-control" id="sisastok${index}" placeholder="Sisa Stok Barang"  name="sisa_stok${index}" readonly>
          <div class="invalid-feedback errsisastok${index}"></div>
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
      sisa_stok_lama.pop();
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
          <p>Jika anda mencoba mengubah nama barang sesuai dengan nama barang yang sudah ada di dalam table permintaan, maka perintah update akan terus dilanjutkan dengan menghapus data permintaan ini, lalu menambahkan jumlah permintaan data barang yang sudah ada.</p>
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
        url: "<?= $nav ?>/getpermintaanbyid",
        data: {
          id: globalId,
        },
        dataType: "json",
        success: function(response) {
          isiForm(response.data, response.jmldata);
        }
      });
    }

    $('.formpermintaan').submit(function(e) {
      e.preventDefault();

      if (saveMethod == "add") {
        url = "<?= $nav ?>/simpan";
      } else if (saveMethod == "update") {
        url = "<?= $nav . "/update/" ?>" + globalId;
      }

      var formdata = new FormData(this);
      formdata.append('jmlbrg', rowCount);
      formdata.append('jenistrx', "Permintaan Barang");

      $.ajax({
        type: "post",
        url: url,
        data: formdata,
        processData: false,
        contentType: false,
        cache: false,
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
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire(
            'Terjadi Kesalahan!',
            response.error,
            'error'
          )
        },
      });

      return false;
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
          e.preventDefault();
          $(`#jumlah${j}`).removeClass('is-invalid');
          $(`.errorjumlah${j}`).html('');
          if ($(this).val() == '') {
            if ("<?= $saveMethod == "update" ?>") {
              var sisa_stok_update = parseInt(sisa_stok_lama[j - 1]) + parseInt(jumlah_lama[j - 1]);
              $('.formpermintaan').find(`input[name='sisa_stok${j}']`).val(sisa_stok_update);
            } else {
              $('.formpermintaan').find(`input[name='sisa_stok${j}']`).val(sisa_stok_lama[j - 1]);
            }
          } else {
            var jml_minta = $(this).val();
            if ("<?= $saveMethod == "update" ?>") {
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
      `<span><i class="bi bi-circle-square"> </i>${data.text}</span>`
    );

    return $result;
  }

  function isiForm({
    nama_anggota,
    no_anggota,
    unit_id,
    level,
    singkatan,
    barang_id,
    jml_barang,
    anggota_id,
    nama_brg,
    satuan_id,
    kd_satuan,
    sisa_stok
  }, jmldata) {
    $('#idanggota').val(anggota_id);
    for (let i = 1; i <= jmldata; i++) {
      $(`#idbrg${i}`).html(`
        <option value="${barang_id}">${nama_brg}</option>
      `);
      sisa_stok_lama.push(sisa_stok);
      jumlah_lama.push(jml_barang);
      $(`#sisastok${i}`).val(sisa_stok);
      $(`#jumlah${i}`).val(jml_barang);
      $(`#satuan${i}`).prop('disabled', true);
      $(`#satuan${i}`).html(`
        <option value="${satuan_id}">${kd_satuan}</option>
      `);
    }
  }
</script>