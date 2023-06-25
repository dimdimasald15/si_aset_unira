<div class="card mb-3 shadow" id="tampilsingleformanggota">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="formanggota py-4">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="namaanggota" class="form-label">Nama <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" placeholder="Masukkan Nama Anggota" id="namaanggota" name="nama_anggota">
              <div class="invalid-feedback errnamaanggota"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="level">Level <?= $title ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-badge-fill"></i></span>
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
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6 noanggota" style="display:none;">
          </div>
          <div class="col-md-6">
            <label for="unit" class="form-label">Unit <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
              <select name="unit_id" class="form-select p-2" id="unit"></select>
              <div class="invalid-feedback errunit"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="nohp" class="form-label">No Hp <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-telephone-plus"></i></span>
              <input type="text" class="form-control" placeholder="Masukkan No Handphone" id="nohp" name="no_hp">
              <div class="invalid-feedback errnohp"></div>
            </div>
          </div>
        </div>
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
  $(document).ready(function() {
    var saveMethod = "<?= $saveMethod ?>";
    var globalId, level = '';
    $('#tampilsingleformanggota').show(500);
    $('.back-form').on('click', function() {
      $('#tampilsingleformanggota').hide(500);
      $('.viewform').hide(500)
    });

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

    if (saveMethod == "update") {
      globalId = "<?= $globalId ?>";
      $.ajax({
        type: "post",
        url: "<?= $nav ?>/getdataanggotabyid",
        data: {
          id: globalId,
        },
        dataType: "json",
        success: function(response) {
          isiForm(response);
        }
      });
    }

    $('.formanggota').submit(function(e) {
      e.preventDefault();
      let url = ""
      if (saveMethod == "update") {
        console.log(globalId);
        url = "<?= $nav ?>/updateanggota/" + globalId;
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpananggota";
      }

      var formdata = new FormData(this);
      $.ajax({
        type: "post",
        url: url,
        data: formdata,
        processData: false,
        contentType: false,
        success: function(result) {
          var response = JSON.parse(result);
          if (response.error) {
            var namaanggota = response.error.nama_anggota;
            var level = response.error.level;
            var noanggota = response.error.no_anggota;
            var unit = response.error.unit;
            if (namaanggota) {
              $(`#namaanggota`).addClass('is-invalid');
              $(`.errnamaanggota`).html(namaanggota);
            } else {
              $(`#namaanggota`).removeClass('is-invalid');
              $(`.errnamaanggota`).html(namaanggota);
            }
            if (level) {
              $(`#level`).addClass('is-invalid');
              $(`.errlevel`).html(level);
            } else {
              $(`#level`).removeClass('is-invalid');
              $(`.errlevel`).html(level);
            }
            if (noanggota) {
              $(`#noanggota`).addClass('is-invalid');
              $(`.errnoanggota`).html(noanggota);
            } else {
              $(`#noanggota`).removeClass('is-invalid');
              $(`.errnoanggota`).html(noanggota);
            }
            if (unit) {
              $(`#unit`).addClass('is-invalid');
              $(`.errunit`).html(unit);
            } else {
              $(`#unit`).removeClass('is-invalid');
              $(`.errunit`).html(unit);
            }
          } else {
            $('#tampilsingleformanggota').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              dataanggota.ajax.reload();
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
    nama_anggota,
    no_anggota,
    unit_id,
    level,
    singkatan,
    no_hp
  }) {
    $('#id').val(id);
    $('#namaanggota').val(nama_anggota);
    $('#level').val(level);
    $('.noanggota').hide().html('');
    if (level == 'Mahasiswa') {
      $('.noanggota').show().append(
        `<label class="form-label">NIM</label>
        <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input type="text" class="form-control" placeholder="Masukkan NIM" id="noanggota" name="no_anggota" value="${no_anggota}">
        <div class="invalid-feedback errnoanggota"></div>
        </div>`
      );
    } else if (level == 'Karyawan') {
      $('.noanggota').show().append(
        `<label class="form-label">Nomor Pegawai</label>
          <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" class="form-control" placeholder="Masukkan Nomor Pegawai" id="noanggota" name="no_anggota" value="${no_anggota}">
          <div class="invalid-feedback errnoanggota"></div>
          </div>`
      );
    } else {
      $('.noanggota').hide().html('');
    }
    pilihunit(level);
    $('#unit').html(`
      <option value="${unit_id}">${singkatan}</option>
    `);
    $('#nohp').val(no_hp);
  }

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

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-circle-square"> </i>${data.text}</span>`
    );

    return $result;
  }
</script>