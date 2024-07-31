<div class="media-body" id="detail_laporan_kerusakan">
  <div class="email-scroll-area ps ps--active-y">
    <!-- email details  -->
    <div class="row" style="height: 100%;">
      <div class="col-12">
        <div class="email-detail-head">
          <div class="card" role="tablist">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div class="collapse-title media">
                <div class="pr-1">
                  <div class="avatar mr-75">
                    <img src="<?= base_url('uploads/default.jpg') ?>" alt="avtar img holder" width="30" height="30">
                  </div>
                </div>
                <div class="media-body-text mt-25">
                  <span class="text-primary nama"><?= $pelaporan->nama_anggota ?></span>
                  <span class="d-sm-inline d-none" id="noanggota">&lt; <?= $pelaporan->no_anggota ?> &gt;</span>
                  <small class="text-muted d-block" id="level"><?= $pelaporan->level ?></small>
                </div>
              </div>
              <div class="information d-sm-flex align-items-center">
                <small class="text-muted me-3" id="created_at"><?= $pelaporan->created_at ?></small>
                <span class="favorite text-secondary">
                  <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                    <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#star" />
                  </svg>
                </span>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body py-3" style="overflow-y: scroll; height:50vh;">
                <p class="fw-bolder" id="title"><?= $pelaporan->title ?></p>
                <p class="subject">
                  Subject : <?= $pelaporan->jml_barang . ' ' . $pelaporan->kd_satuan . ' ' . $pelaporan->nama_brg ?>
                </p>
                <p id='deskripsi'>
                  <?= $pelaporan->deskripsi ?>
                </p>
                <p class="mb-0">Hormat kami,</p>
                <br>
                <p class="text-bold-500 nama"><?= $pelaporan->nama_anggota ?></p>
              </div>
              <div class="card-footer pt-0 border-top">
                <label class="sidebar-label">File foto kerusakan</label>
                <ul class="list-unstyled mb-0">
                  <?php foreach (json_decode($pelaporan->foto) as $index => $foto) { ?>
                    <li class="cursor-pointer mb-1" id="foto-<?= $index; ?>">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#modalDetail" onClick="util.viewModalPhotos('<?= $no_laporan; ?>', <?= $index; ?>)">
                        <img data-bs-target="#lightboxCarousel" data-bs-slide-to="<?= $index; ?>" src="<?= base_url('assets/imgext/File-JPG-Image-icon.png'); ?>">
                        <small class="text-muted ms-1 attchement-text"><?= $foto; ?></small>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>