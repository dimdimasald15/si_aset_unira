<?= $this->extend('/layouts/template2') ?>

<?= $this->section('style') ?>
<style>
  input[type=number] {
    -moz-appearance: textfield;
    /* Firefox */
  }

  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    /* May be needed depending on the styling */
  }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php if ($barang) { ?>
  <form class="form form-vertical py-2" id="formlaporbrg" onSubmit="formbrg.submitReport(this, event, '<?= $url_detail_brg ?>')">
    <?= csrf_field() ?>
    <div class="row justify-content-center" id="intro">
      <div class="col-lg-9 col-md-9 col-12">
        <div class="card shadow border-0 mb-0">
          <div class="card-header bg-transparent pb-1">
            <div class="text-center text-muted">
              <h3 class="mb-2 text-muted">Form Pelaporan Kerusakan Barang</h3>
            </div>
          </div>
          <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
            <div class="row px-4 py-0 option">
              <div class="col-md-12 d-flex justify-content-center">
                <h6>Apakah anda sudah pernah melaporkan kerusakan aset?</h6>
              </div>
              <div class="col-md-12">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pilihan" id="opsi1" value="anggota baru">
                  <label class="form-check-label" for="opsi1">
                    Tidak, saya belum pernah melaporkan kerusakan aset.
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pilihan" id="opsi2" value="anggota lama">
                  <label class="form-check-label" for="opsi2">
                    Ya, saya sudah pernah melaporkan kerusakan aset.
                  </label>
                  <div class="invalid-feedback erroption"></div>
                </div>
                <input type="hidden" name="no_laporan" id="nolaporan" value="<?= $no_laporan ?>">
              </div>
            </div>
            <div class="row option">
              <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn btn-success mx-4 my-4 btn-block" id="btn-next1" onClick="report.handleBtnNext1()">
                  Lanjutkan isi form</button>
              </div>
            </div>
          </div>
          <div class="card-footer shadow-sm">
            <div class="row text-center">
              <div class="col-lg-12">
                <a href="<?= site_url() . $url_detail_brg ?>" class="text-decoration-underline"> Kembali ke halaman sebelumnya</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" id="newmember" style="display:none;">
      <div class="col-lg-9 col-md-9 col-12">
        <div class="card shadow">
          <div class="card-header bg-transparent pb-1">
            <div class="text-center text-muted">
              <h3 class="mb-2 text-muted">Form Pendaftaran Pelapor Baru</h3>
            </div>
          </div>
          <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
            <div class="row mt-1">
              <div class="form-body">
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <div class="row mb-2">
                        <label for="level">Level Pelapor</label>
                      </div>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-badge-fill"></i></span>
                        <select name="level" class="form-select p-2" id="level" onchange="anggota.handleLevel(this)">
                          <option value="" disabled selected>Pilih Level</option>
                          <option value="Karyawan">Karyawan</option>
                          <option value="Mahasiswa">Mahasiswa</option>
                        </select>
                        <div class="invalid-feedback errlevel"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="nama_anggota" class="form-label">Nama Pelapor</label>
                      <div class="input-group mb-1">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Anggota" id="nama_anggota" name="nama_anggota">
                        <div class="invalid-feedback errnama_anggota"></div>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6 no_anggota" style="display:none;">
                    </div>
                    <div class="col-md-6">
                      <label for="unit_id" class="form-label">Unit Pelapor</label>
                      <div class="input-group">
                        <!-- <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span> -->
                        <select name="unit_id" class="form-select p-2" id="unit_id"></select>
                        <div class="invalid-feedback errunit_id"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="nohp" class="form-label">No Hp Pelapor</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan No Handphone" id="nohp" name="no_hp">
                        <div class="invalid-feedback errnohp"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row btngroup1" style="display: none;">
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-white my-4 btn-cancel1" style="display:none;">&laquo; Kembali</button>
                    <button type="button" class="btn btn-success my-4" id="btn-next2">Lanjutkan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" id="formbrgrusak" style="display:none;">
      <div class="col-lg-9 col-md-9 col-12">
        <div class="card shadow">
          <div class="card-header bg-transparent pb-1">
            <div class="text-center text-muted">
              <h3 class="mb-2 text-muted">Form Kerusakan Barang</h3>
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
                          <!-- LEVEL2 -->
                          <div class="col-md-6 level2">
                            <label for="level2">Level Pelapor</label>
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-badge-fill"></i></span>
                              <select name="level2" class="form-select p-2" id="level2">
                                <option value="" disabled selected>Pilih Level</option>
                                <option value="Karyawan">Karyawan</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                              </select>
                              <div class="invalid-feedback errlevel"></div>
                            </div>
                          </div>
                          <!-- OLD MEMBER -->
                          <div class="col-md-6">
                            <div class="row mb-1 oldmember" style="display:none;">
                              <label for="anggota_id">Nama Pelapor</label>
                              <div class="row mb-1">
                                <div class="input-group">
                                  <!-- <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span> -->
                                  <select name="anggota_id" class="form-select p-2" id="anggota_id" style="display: none;">
                                  </select>
                                  <div class="invalid-feedback erranggota_id"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- NAMA BARANG -->
                          <div class="col-md-12">
                            <input type="hidden" name="stokbrg_id" id="id" value="<?= $barang->id ?>">
                            <div class="row mb-1">
                              <label for="barang_id">Nama Barang</label>
                              <div class="row mb-1">
                                <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                                  <select name="barang_id" class="form-select p-2" id="barang_id" disabled>
                                    <option value="<?= $barang->barang_id ?>" selected><?= $barang->nama_brg ?></option>
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
                          <!-- LOKASI PENEMPATAN -->
                          <div class="col-md-6">
                            <div class="row mb-1">
                              <label for="lokasi">Lokasi Penempatan</label>
                            </div>
                            <div class="row mb-1">
                              <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                <select class="form-select" id="lokasi" name="ruang_id" disabled>
                                  <option value="<?= $barang->ruang_id ?>" selected><?= $barang->nama_ruang ?></option>
                                </select>
                                <div class="invalid-feedback errlokasi"></div>
                              </div>
                            </div>
                          </div>
                          <!-- JUMLAH BARANG -->
                          <div class="col-md-3">
                            <label for="jml_barang" class="mb-1">Jumlah Barang Rusak</label>
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                              <input type="number" min="1" class="form-control" id="jml_barang" placeholder="Masukkan Jumlah Barang rusak" name="jml_barang">
                              <div class="invalid-feedback errjml_barang"></div>
                            </div>
                          </div>
                          <!-- SATUAN -->
                          <div class="col-md-3">
                            <label for="satuan" class="mb-1">Satuan</label>
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-dice-5"></i></span>
                              <select name="satuan_id" class="form-select p-2" id="satuan" disabled>
                                <option value="<?= $barang->satuan_id ?>" selected><?= $barang->kd_satuan ?></option>
                              </select>
                              <div class="invalid-feedback errsatuan"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="row g-2 mb-1">
                        <!-- TITLE LAPORAN -->
                        <div class="col-md-12">
                          <label class="mb-1" for="title">Judul laporan</label>
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-earmark-text"></i></span>
                            <input type="text" class="form-control" placeholder="Title Laporan" name="title" id="title" value="Laporan kerusakan aset <?= $barang->nama_brg ?> di <?= $barang->nama_ruang ?>" readonly>
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
                            <div class="form-group row">
                              <div class="input-group">
                                <!--Hidden file input for images-->
                                <input id="files" type="file" name="files[]" data-button="" multiple="" accept="image/jpeg, image/png, image/gif," style="display:none;">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <label class="deskripsi" for="deskripsi">Deskripsi Kerusakan Barang</label>
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-pencil"></i></span>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" name="deskripsi"></textarea>
                            <div class="invalid-feedback errdeskripsi"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row btngroup2" style="display: none;">
                <div class="col-12 d-flex justify-content-end">
                  <button type="button" class="btn btn-white my-4 btn-cancel1" style="display: none;">&laquo; Kembali</button>
                  <button type="button" class="btn btn-white my-4" id="btn-cancel2" onclick="report.handleBtnCancel2()" style="display: none;">&laquo; Kembali</button>
                  <button type="submit" class="btn btn-success my-4 btnsimpan">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div class="row justify-content-center" id="opsiubahlaporan" style="display:none;">
  </div>
<?php } else { ?>
  <div class="card">
    <div class="card-title text-center">
      <div class="row m-3">
        <h4>Mohon maaf, tidak dapat diproses.</h4>
      </div>
    </div>
  </div>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    let imagesToLoad = null;
    formbrg.initUploadPhotos(imagesToLoad);
    report.initializeForm();
  });
</script>
<?= $this->endSection() ?>