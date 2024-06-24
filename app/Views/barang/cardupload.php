<div class="card mb-3 shadow" id="cardupload">
  <div class="card-header shadow-sm">
    <h5 class="card-title">Upload Gambar <?= $title; ?></h5>
  </div>
  <div class="card-content">
    <div class="card-body">
      <form class="form form-vertical py-1" id="formUpload">
        <?= csrf_field() ?>
        <div class="row g-2 mb-1">
          <div class="col-md-auto">
            <label for="fotobrg" class="mb-1">Gambar <?= $nama_brg; ?></label>
            <?php if ($fotobrg) { ?>
              <img src="<?= base_url() ?>assets/images/foto_barang/<?= $fotobrg ?>" alt="Gambar Barang" class="rounded mx-auto d-block shadow-sm mb-3" style="width:300px; height:auto;">
            <?php } else { ?>
              <img src="https://via.placeholder.com/150x150.png?text=No+Image" alt="No Image" class="rounded mx-auto d-block shadow-sm mb-3" style="width:150px; height:auto;">
            <?php } ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-image"></i></span>
              <input type="file" class="form-control" placeholder="Upload gambar barang" id="fotobrg" name="foto_barang">
              <input id="cropped_image" name="cropped_image" style="display:none;">
              <div class="invalid-feedback errfotobrg"></div>
            </div>
          </div>
          <div class="col-md-auto d-flex align-content-center justify-content-center">
            <div class="previewresult" style="display:none;"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-white my-2" onClick="util.closeBtn('#cardupload')">Batal</button>
            <button type="submit" class="btn btn-success my-2 btnupload">Upload Foto</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_crop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pangkas gambar sebelum upload</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="img-container">
          <div class="row d-flex justify-content-between">
            <div class="col-md-7">
              <img src="" id="sample_image" class="mx-auto d-block">
            </div>
            <div class="col-md-5">
              <div class="preview"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="crop_and_upload" class="btn btn-success">Crop</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    var $modal = $('#modal_crop');
    var crop_image = document.getElementById('sample_image');
    var cropper;

    $('#fotobrg').change(function(event) {
      var files = event.target.files;
      var done = function(url) {
        crop_image.src = url;
        $modal.modal('show');
      };
      if (files && files.length > 0) {
        reader = new FileReader();
        reader.onload = function(event) {
          done(reader.result);
        };
        reader.readAsDataURL(files[0]);
      }
    });
    $modal.on('shown.bs.modal', function() {
      // var aspectRatio = '';
      // if (jenis_kat === 'Barang Tetap') {
      //   aspectRatio = 2;
      // } else if (jenis_kat === 'Barang Persediaan') {
      //   aspectRatio = 1;
      // }
      cropper = new Cropper(crop_image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview'
      });
    }).on('hidden.bs.modal', function() {
      cropper.destroy();
      cropper = null;
    });
    $('#crop_and_upload').click(function() {
      canvas = cropper.getCroppedCanvas({
        width: 1200,
        height: 1200
      });
      canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function() {
          var base64data = reader.result;
          $('.previewresult').show(500);
          // $('#fotobrg').hide();
          // $('#cropped_image').show();
          $('#cropped_image').val(base64data);
          $('.preview').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang</label><img src="' + base64data + '" class="img-thumbnail rounded mx-auto d-block" style="width: 400px; height: 400px;">'); // tampilkan gambar preview
          $('.previewresult').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang <?= $nama_brg ?></label><img src="' + base64data + '" class="img-thumbnail rounded mx-auto d-block" style="width: 400px; height: auto;">'); // tampilkan gambar preview
          $modal.modal('hide');
        };
      });
    });

    $('.btnupload').on('click', function(e) {
      e.preventDefault();

      let formupload = $('#formUpload')[0];

      let data = new FormData(formupload);
      $.ajax({
        type: "post",
        url: "<?= $nav ?>/simpanupload",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
        beforeSend: function() {
          $('.btnupload').attr('disable', 'disabled');
          $('.btnupload').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnupload').removeAttr('disable');
          $('.btnupload').html('Update');
        },
        success: function(response) {
          if (response.error) {
            if (response.error.fotobrg) {
              $('#fotobrg').addClass('is-invalid');
              $('.errfotobrg').html(response.error.fotobrg);
            } else {
              $('#fotobrg').removeClass('is-invalid');
              $('.errfotobrg').html('');
            }
          } else {
            $('#cardupload').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              tableBrgTetap.ajax.reload();
              tableBrgPersediaan.ajax.reload();
              tableAlokasiBrg.ajax.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });

    })
  });
</script>