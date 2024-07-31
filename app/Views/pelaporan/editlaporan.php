<?= $this->extend('/layouts/template2') ?>

<?= $this->section('content') ?>

<form class="form form-vertical py-2" id="formeditlaporan" onSubmit="formbrg.updateReport(this, event, '<?= $url_detail_brg ?>')">
  <?= csrf_field() ?>
  <input type="hidden" name="id" id="id" value="<?= $laporan->id ?>">
  <input type="hidden" name="stokbrg_id" id="stok_id" value="<?= $laporan->stokbrg_id ?>">
  <div class="row justify-content-center" id="formbrgrusak">
    <div class="col-lg-9 col-md-9 col-12">
      <div class="card shadow">
        <div class="card-header bg-transparent pb-1">
          <div class="text-center text-muted">
            <h3 class="mb-2 text-muted"><?= $title ?> Kerusakan Barang</h3>
          </div>
        </div>
        <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
          <div class="row mt-1">
            <div class="col-lg-12">
              <div class="form-body">
                <div class="row d-flex justify-content-between">
                  <div class="col-lg-12">
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-12">
                          <div class="row mb-1 oldmember">
                            <label for="anggota_id">Nama Pelapor</label>
                            <div class="row mb-1">
                              <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <select name="anggota_id" class="form-select p-2" id="anggota_id" readonly>
                                  <option value="<?= $laporan->anggota_id ?>" selected><?= $laporan->no_anggota . " - " . $laporan->nama_anggota . " (" . $laporan->singkatan . ")"   ?></option>
                                </select>
                                <div class="invalid-feedback erranggota_id"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="row mb-1">
                            <label for="barang_id">Nama Barang</label>
                            <div class="row mb-1">
                              <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                                <select name="barang_id" class="form-select p-2" id="barang_id" readonly>
                                  <option value="<?= $laporan->barang_id ?>" selected><?= $laporan->nama_brg ?></option>
                                </select>
                                <div class="invalid-feedback errbarang_id"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-6">
                          <div class="row mb-1">
                            <label for="lokasi">Lokasi Penempatan</label>
                          </div>
                          <div class="row mb-1">
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                              <select class="form-select" id="lokasi" name="ruang_id" disabled>
                                <option value="<?= $laporan->ruang_id ?>" selected><?= $laporan->nama_ruang ?></option>
                              </select>
                              <div class="invalid-feedback errlokasi"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label for="jml_barang" class="mb-1">Jumlah Barang Rusak</label>
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                            <input type="number" min="1" class="form-control" id="jml_barang" placeholder="Masukkan Jumlah Barang rusak" name="jml_barang" value="<?= $laporan->jml_barang ?>">
                            <div class="invalid-feedback errjml_barang"></div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label for="satuan" class="mb-1">Satuan</label>
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-dice-5"></i></span>
                            <select name="satuan_id" class="form-select p-2" id="satuan" disabled>
                              <option value="<?= $laporan->satuan_id ?>" selected><?= $laporan->kd_satuan ?></option>
                            </select>
                            <div class="invalid-feedback errsatuan"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="row g-2 mb-1">
                      <div class="col-md-12">
                        <label class="mb-1" for="title">Title laporan</label>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-earmark-text"></i></span>
                          <input type="text" class="form-control" placeholder="Title Laporan" name="title" id="title" value="Laporan kerusakan aset <?= $laporan->nama_brg ?> di <?= $laporan->nama_ruang ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <label for="files">Foto kerusakan barang</label>
                        <div id="imageLoader" class="row gap-2" style="margin-left: 10px;">
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
                          <div class="form-group row">
                            <div class="input-group">
                              <!--Hidden file input for images-->
                              <input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label class="deskripsi" for="deskripsi">Deskripsi Kerusakan Barang</label>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-pencil"></i></span>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"><?= $laporan->deskripsi ?></textarea>
                        <div class="invalid-feedback errdeskripsi"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row btngroup2">
            <div class="col-12 d-flex justify-content-end">
              <a type="button" class="btn btn-white my-4 btn-cancel1" href="<?= base_url() ?>detail-barang/<?= str_replace(".", "-", $laporan->kode_brg) . "-" . $laporan->ruang_id ?>">&laquo; Kembali</a>
              <button type="submit" class="btn btn-success my-4 btnsimpan">Update</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="row justify-content-center" id="opsiubahlaporan" style="display:none;"></div>
<?= $this->endSection(); ?>
<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    let imagesToLoad = <?= $photos ?>;
    formbrg.initUploadPhotos(imagesToLoad);
    const fields = ["jml_barang", "files"];
    util.initializeValidationHandlers(fields);
  });
</script>
<?= $this->endSection(); ?>