<div class="modal fade" id="modalForm" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="title">
          Upload Gambar <?= $nama_brg; ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-label">
        <div class="container">
          <form class="form form-vertical py-1" id="formUpload" onsubmit="formbrg.submitUpload(this, event)">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="id" value="<?= $id ?>">
            <div id="imageLoader" class="row gap-2">
              <!-- Progress bar -->
              <div class="col-12 order-1 mt-2">
                <div data-type="progress" class="progress" style="height: 25px; display:none;">
                  <div data-type="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%;">Load in progress...</div>
                </div>
              </div>
              <!-- Model -->
              <div data-type="image-model" class="col-4 pl-2 pr-2 pt-2" style="max-width:150px; display:none;">
                <div class="ratio-box text-center" data-type="image-ratio-box">
                  <img data-type="noimage" class="btn btn-light ratio-img img-fluid p-2 image border dashed rounded" src="<?= base_url() ?>assets/images/photo-camera-gray.svg" style="cursor:pointer;">
                  <div data-type="loading" class="img-loading" style="color:#218838; display:none;">
                    <span class="fa fa-2x fa-spin fa-spinner"></span>
                  </div>
                  <img data-type="preview" class="btn btn-light ratio-img img-fluid p-2 image border dashed rounded" src="" style="display: none; cursor: default;">
                  <span class="badge rounded-pill bg-success p-2 w-50 main-tag" style="display:none;">Main</span>
                </div>
                <!-- Buttons -->
                <div data-type="image-buttons" class="row justify-content-center mt-2">
                  <button data-type="add" class="btn btn-outline-success" type="button"><span class="fa fa-camera mr-2"></span> Add</button>
                  <button data-type="btn-modify" type="button" class="btn btn-outline-success m-0" data-toggle="popover" data-placement="right" style="display:none;">
                    <span class="fa fa-pencil mr-2"></span> Modify
                  </button>
                </div>
              </div>
              <!-- Popover operations -->
              <div data-type="popover-model" style="display:none">
                <div data-type="popover" class="ml-3 mr-3" style="min-width:150px;">
                  <div class="row">
                    <div class="col p-0">
                      <button data-operation="main" class="btn btn-block btn-success btn-sm rounded-pill" type="button"><span class="fa fa-angle-double-up mr-2"></span> Main</button>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-6 p-0 pr-1">
                      <button data-operation="left" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">&laquo; left</button>
                    </div>
                    <div class="col-6 p-0 pl-1">
                      <button data-operation="right" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">right &raquo;</button>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-6 p-0 pr-1">
                      <button data-operation="rotateanticlockwise" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button"><span class="fa fa-undo mr-2"></span> Rotasi</button>
                    </div>
                    <div class="col-6 p-0 pl-1">
                      <button data-operation="rotateclockwise" class="btn btn-block btn-outline-success btn-sm rounded-pill" type="button">Rotasi <span class="fa fa-repeat ml-2"></span></button>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <button data-operation="remove" class="btn btn-outline-danger btn-sm btn-block" type="button"><span class="fa fa-times mr-2"></span> Hapus</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="input-group">
                <!--Hidden file input for images-->
                <input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button id="btnContinue" type="submit" form="formUpload" class="btn btn-block btn-outline-success float-right" data-toggle="tooltip" data-trigger="manual" data-placement="top" data-title="Continue">
            Upload <span id="btnContinueIcon" class="fa fa-upload ml-2"></span><span id="btnContinueLoading" class="fa fa-spin fa-spinner ml-2" style="display:none"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="modal_crop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
</div> -->


<script>
  $(document).ready(function() {
    let imagesToLoad = <?= $photos ?>;
    formbrg.initUploadPhotos(imagesToLoad)

    // var $modal = $('#modal_crop');
    // var crop_image = document.getElementById('sample_image');
    // var cropper;

    // $('#fotobrg').change(function(event) {
    //   var files = event.target.files;
    //   var done = function(url) {
    //     crop_image.src = url;
    //     $modal.modal('show');
    //   };
    //   if (files && files.length > 0) {
    //     reader = new FileReader();
    //     reader.onload = function(event) {
    //       done(reader.result);
    //     };
    //     reader.readAsDataURL(files[0]);
    //   }
    // });
    // $modal.on('shown.bs.modal', function() {
    //   cropper = new Cropper(crop_image, {
    //     aspectRatio: 1,
    //     viewMode: 3,
    //     preview: '.preview'
    //   });
    // }).on('hidden.bs.modal', function() {
    //   cropper.destroy();
    //   cropper = null;
    // });
    // $('#crop_and_upload').click(function() {
    //   canvas = cropper.getCroppedCanvas({
    //     width: 1200,
    //     height: 1200
    //   });
    //   canvas.toBlob(function(blob) {
    //     url = URL.createObjectURL(blob);
    //     var reader = new FileReader();
    //     reader.readAsDataURL(blob);
    //     reader.onloadend = function() {
    //       var base64data = reader.result;
    //       $('.previewresult').show(500);
    //       $('#cropped_image').val(base64data);
    //       $('.preview').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang</label><img src="' + base64data + '" class="img-thumbnail rounded mx-auto d-block" style="width: 400px; height: 400px;">'); // tampilkan gambar preview
    //       $('.previewresult').html('<label for="fotobrg" class="mb-1">Preview Gambar Barang <?= $nama_brg ?></label><img src="' + base64data + '" class="img-thumbnail rounded mx-auto d-block" style="width: 400px; height: auto;">'); // tampilkan gambar preview
    //       $modal.modal('hide');
    //     };
    //   });
    // });

    // $('.btnupload').on('click', function(e) {
    //   e.preventDefault();

    //   let formupload = $('#formUpload')[0];

    //   let data = new FormData(formupload);
    //   $.ajax({
    //     type: "post",
    //     url: `${nav}/simpanupload`,
    //     data: data,
    //     enctype: 'multipart/form-data',
    //     processData: false,
    //     contentType: false,
    //     cache: false,
    //     dataType: "json",
    //     beforeSend: function() {
    //       $('.btnupload').attr('disable', 'disabled');
    //       $('.btnupload').html('<i class="fa fa-spin fa-spinner"></i>');
    //     },
    //     complete: function() {
    //       $('.btnupload').removeAttr('disable');
    //       $('.btnupload').html('Update');
    //     },
    //     success: function(response) {
    //       const fields = ["fotobrg"];
    //       if (response.error) {
    //         util.handleValidationErrors(fields, response.error);
    //       } else {
    //         $('#cardupload').hide(500);
    //         Swal.fire(
    //           'Berhasil!',
    //           response.sukses,
    //           'success'
    //         ).then((result) => {
    //           tableBrgTetap.ajax.reload();
    //           tableBrgPersediaan.ajax.reload();
    //           tableAlokasiBrg.ajax.reload();
    //         })
    //       }
    //     },
    //     error: function(xhr, ajaxOptions, thrownError) {
    //       alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
    //     }
    //   });

    // })
  });
</script>