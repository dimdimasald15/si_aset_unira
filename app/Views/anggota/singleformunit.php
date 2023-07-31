<div class="card mb-3 shadow" id="tampilsingleformunit">
  <div class="card-header shadow-sm">
    <div class="row">
      <h4 class="card-title">Tambah Data <?= $title; ?></h4>
    </div>
  </div>
  <div class="card-body">
    <form class="formunit py-4">
      <?= csrf_field() ?>
      <div class="col-md-12">
        <input type="hidden" name="id" id="id">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <label for="namaunit" class="form-label">Nama <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-circle-square"></i></span>
              <input type="text" class="form-control" placeholder="Masukkan Nama Unit" id="namaunit" name="nama_unit">
              <div class="invalid-feedback errnamaunit"></div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="singkatan" class="form-label">Singkatan <?= $title ?></label>
            <div class="input-group mb-3">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control" placeholder="Masukkan Singkatan" id="singkatan" name="singkatan">
              <div class="invalid-feedback errsingkatan"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row g-2 mb-1">
          <div class="col-md-6">
            <div class="row mb-2">
              <label for="kat_unit">Kategori <?= $title ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-text"></i></span>
                <select name="kategori_unit" class="form-select p-2" id="kat_unit" style="width: 100px;"></select>
                <div class="invalid-feedback errkat_unit"></div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row mb-1">
              <label for="deskripsi">Deskripsi <?= $title; ?></label>
            </div>
            <div class="row mb-1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
                <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                <div class="invalid-feedback errdeskripsi"></div>
              </div>
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
    var globalId;
    $("#tampilsingleformunit").show(500);
    $(".back-form").on("click", function() {
      $("#tampilsingleformunit").hide(500);
      $(".viewform").hide(500)
    });
    $.ajax({
      type: "get",
      url: "<?= $nav . '/getkategoriunit' ?>",
      dataType: "json",
      success: function(response) {
        $("#kat_unit").empty();
        $("#kat_unit").append(`<option value="">Pilih Kategori Unit</option>`);
        $.each(response, function(key, value) {
          $("#kat_unit").append(`<option value="${value.kategori_unit}">${value.kategori_unit}</option>`)
        })
      }
    });
    if (saveMethod == "update") {
      $("#tampilsingleformunit").find(".card-title").html("Ubah Data Unit");
      globalId = "<?= $globalId ?>";
      $.ajax({
        type: "post",
        url: "<?= $nav . '/getdataunitbyid' ?>",
        data: {
          id: globalId
        },
        dataType: "json",
        success: function(response) {
          $(".formunit").find("input").val("");
          $(".formunit").find("select").val("");
          isiForm(response)
        }
      })
    }
    $("#namaunit").on("input", function(e) {
      e.preventDefault();
      $(this).removeClass("is-invalid");
      $(`.errnamaunit`).html("")
    });
    $("#singkatan").on("input", function(e) {
      e.preventDefault();
      $(this).removeClass("is-invalid");
      $(`.errsingkatan`).html("")
    });
    $("#kat_unit").on("change", function(e) {
      e.preventDefault();
      $(this).removeClass("is-invalid");
      $(`.errkat_unit`).html("")
    });
    $(".formunit").submit(function(e) {
      e.preventDefault();
      let url = "";
      if (saveMethod == "update") {
        url = "<?= $nav ?>/updateunit/" + globalId
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpanunit"
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
            var namaunit = response.error.nama_unit;
            var singkatan = response.error.singkatan;
            var kat_unit = response.error.kategori_unit;
            if (namaunit) {
              $(`#namaunit`).addClass("is-invalid");
              $(`.errnamaunit`).html(namaunit)
            } else {
              $(`#namaunit`).removeClass("is-invalid");
              $(`.errnamaunit`).html("")
            }
            if (singkatan) {
              $(`#singkatan`).addClass("is-invalid");
              $(`.errsingkatan`).html(singkatan)
            } else {
              $(`#singkatan`).removeClass("is-invalid");
              $(`.errsingkatan`).html("")
            }
            if (kat_unit) {
              $(`#kat_unit`).addClass("is-invalid");
              $(`.errkat_unit`).html(kat_unit)
            } else {
              $(`#kat_unit`).removeClass("is-invalid");
              $(`.errkat_unit`).html("")
            }
          } else {
            $("#tampilsingleformunit").hide(500);
            Swal.fire("Berhasil!", response.sukses, "success").then(result => {
              dataunit.ajax.reload()
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError)
        }
      });
      return false
    })
  });

  function isiForm({
    id,
    nama_unit,
    singkatan,
    kategori_unit,
    deskripsi
  }) {
    $(`#id`).val(id);
    $(`#namaunit`).val(nama_unit);
    $(`#singkatan`).val(singkatan);
    $(`#kat_unit`).val(kategori_unit);
    $(`#deskripsi`).val(deskripsi)
  }
</script>