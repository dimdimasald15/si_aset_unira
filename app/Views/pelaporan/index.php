<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="viewdata" style="display: none;"></div>
<div class="page-heading email-application">
  <section class="section content-area-wrapper shadow">
    <div class="sidebar-left bg-dark text-white">
      <div class="sidebar" id="sidebar2">
        <div class="sidebar-content email-app-sidebar d-flex">
          <div class="email-app-menu bg-dark text-white">
            <div class="sidebar-header my-3">
              <div class="d-flex justify-content-between align-items-center">
                <div id="logo-unira" style="padding: 0px 0px 0px 20px;">
                  <a href="#"><img src="<?= base_url() ?>assets/images/logo/logouniralandscape.png" alt="Logo" style="max-height:35px;max-width: 120px;"></a>
                </div>
                <div class="toggler" style="padding: 0px 20px;">
                  <a href="#" class="sidebar2-x fs-2" onclick="report.toggleSidebar(true)"><i class="bi bi-x bi-middle"></i></a>
                  <a href="#" class="sidebar2-burger fs-1" onclick="report.toggleSidebar(false)" style="display: none;"><i class="bi bi-justify fs-3"></i></a>
                </div>
              </div>
            </div>
            <div class="sidebar-menu-list ps">
              <!-- sidebar menu  -->
              <div class="list-group list-group-messages">
                <a href="#" class="list-group-item pt-0 active" id="inbox-menu" onclick="report.inboxMenu(this, '<?= $no_laporan ?>')">
                  <div class="fonticon-wrap d-inline me-3">
                    <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                      <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#envelope" />
                    </svg>
                    </i>
                  </div>
                  <span class="sidebar-text">Inbox</span>
                  <span class="sidebar-text badge badge-sm badge-notification bg-light-success text-success"><?= $belumdibaca ?></span>
                </a>
                <a href="#" class="list-group-item" onclick="report.trashMenu('<?= $no_laporan ?>')" id="trash-menu">
                  <div class="fonticon-wrap d-inline me-3">
                    <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                      <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#trash" />
                    </svg>
                  </div>
                  <span class="sidebar-text">Trash</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-right bg-dark text-white">
      <div class="content-overlay bg-dark text-white"></div>
      <div class="content-wrapper bg-dark text-white">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <!-- email app overlay -->
          <div class="app-content-overlay"></div>
          <div class="email-app-area">
            <!-- Email list Area -->
            <div class="email-app-list-wrapper">
              <div class="email-app-list">
                <div class="email-action <?= $no_laporan !== '' ? 'd-none' : '' ?>">
                  <!-- action left start here -->
                  <div class="action-left d-flex align-items-center">
                    <!-- select All checkbox -->
                    <div class="checkbox checkbox-shadow checkbox-sm selectAll me-3">
                      <input type="checkbox" id="checkall" class='form-check-input'>
                      <label for="checkall"></label>
                    </div>
                    <!-- delete unread dropdown -->
                    <ul class="list-inline m-0 d-flex">
                      <li class="list-inline-item mail-delete" id="multipledelete">
                        <button type="submit" form="formmultipledelete" class="btn btn-icon action-icon" data-toggle="tooltip" data-trigger="manual" data-placement="top" data-title="Hapus data temporary">
                          <span class="fonticon-wrap">
                            <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                              <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#trash" />
                            </svg>
                          </span>
                          Hapus Sementara
                        </button>
                      </li>
                      <li class="list-inline-item mail-delete" id="multipledeletepermanen" style="display:none;">
                        <button type="submit" class="btn btn-icon action-icon" data-toggle="tooltip" form="formrecyclebin" onclick="report.setActionType('delete permanent')">
                          <span class="fonticon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                          </span>
                          Hapus Permanen
                        </button>
                      </li>
                      <li class="list-inline-item recycle" id="restoredata" style="display:none;">
                        <button type="submit" class="btn btn-icon action-icon" form="formrecyclebin" onclick="report.setActionType('restore')">
                          <span class="fonticon-wrap d-inline">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16">
                              <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z" />
                            </svg>
                          </span>
                          Pulihkan Data
                        </button>
                      </li>
                    </ul>
                  </div>
                  <!-- action left end here -->

                  <!-- action right start here -->
                  <div class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                    <!-- search bar  -->
                    <div class="email-fixed-search flex-grow-1">
                      <div class="sidebar-toggle d-block d-lg-none">
                        <i class="bx bx-menu"></i>
                      </div>
                      <div class="form-group position-relative  mb-0 has-icon-left">
                        <input type="text" onkeyup="report.searchFilter(0);" class="form-control keywords" id="search1" placeholder="Cari laporan kerusakan aset..">
                        <input type="text" onkeyup="report.searchFilter(1);" class="form-control keywords" id="search2" style="display:none;" placeholder="Cari laporan kerusakan aset..">
                        <div class="form-control-icon">
                          <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                            <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#search" />
                          </svg>
                        </div>
                      </div>
                    </div>
                    <!-- pagination and page count -->
                    <?php if ($pager !== null) { ?>
                      <span class="d-sm-block pagination" style="margin-top:-10px;">
                        <?php echo $pager->links('pelaporan', 'bootstrap_pagination'); ?>
                      </span>
                    <?php } else { ?>
                      <span class="d-sm-block pagination" style="margin-top:-10px;">
                      </span>
                    <?php } ?>
                  </div>
                </div>
                <?php if ($no_laporan !== '') { ?>
                  <div id="semuapelaporan"></div>
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
                <?php } else { ?>
                  <!-- email user list start -->
                  <div class="pelaporan-detail">
                    <div class="row loading" style="display:none;">
                      <div class="col d-flex justify-content-center mt-5">
                        <img src="<?= base_url('assets/images/samples/Loading_icon.gif') ?>" class="loading" alt="loading">
                      </div>
                    </div>
                  </div>
                  <div class="email-user-list list-group ps ps--active-y bg-dark text-white">
                    <?php if (count($pelaporan) > 0) { ?>
                      <form id="formmultipledelete" onSubmit="report.multipleDelete(this, event)">
                        <?= csrf_field() ?>
                        <ul class="users-list-wrapper media-list data_pelaporan">
                          <?php
                          $no = 1;
                          foreach ($pelaporan as $row) :
                            $isRestore = $row["deleted_at"] == null ?? false;
                          ?>
                            <li class="media <?= (!$row['viewed_by_admin']) ? '' : 'mail-read' ?>">
                              <div class="user-action">
                                <div class="checkbox-con me-3">
                                  <div class="checkbox checkbox-shadow checkbox-sm">
                                    <input type="checkbox" data-restore="<?= $isRestore ?>" name="id[]" class='form-check-input checkrow' value="<?= $row['id'] ?>" id="checkboxsmall<?= $no ?>">
                                    <label for="checkboxsmall<?= $no ?>"></label>
                                  </div>
                                </div>
                                <span class="favorite <?= !$row['viewed_by_admin'] ? 'text-warning' : '' ?>">
                                  <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                                    <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#<?= !$row['viewed_by_admin'] ? 'envelope-fill' : 'envelope-open' ?>" />
                                  </svg>
                                </span>
                              </div>
                              <div class="pr-50">
                                <div class="avatar">
                                  <img class="rounded-circle" src="<?= base_url('uploads/default.jpg') ?>" alt="Generic placeholder image">
                                </div>
                              </div>
                              <div class="media-body" onclick="report.detailLaporan('<?= $row['no_laporan'] ?>', <?= $row['viewed_by_admin'] ?>)">
                                <div class="user-details">
                                  <div class="mail-items">
                                    <?php if ($row['level'] == 'Mahasiswa') { ?>
                                      <span class="list-group-item-text"><?= $row['nama_anggota'] . " (NIM. " . $row['no_anggota'] . ")" ?></span>
                                    <?php } else { ?>
                                      <span class="list-group-item-text"><?= $row['nama_anggota'] . " (NIDN/NIY. " . $row['no_anggota'] . ")" ?></span>
                                    <?php } ?>
                                  </div>
                                  <div class="mail-meta-item">
                                    <span class="float-right">
                                      <span class="mail-date text-black"><?= ubahTanggal($row['created_at']) ?></span>
                                    </span>
                                  </div>
                                </div>
                                <div class="mail-message">
                                  <p class="list-group-item-text mb-0 text-black">
                                    <?= $row['title'] ?>
                                  </p>
                                  <div class="mail-meta-item">
                                    <span class="float-right">
                                      <span class="bullet bullet-danger bullet-sm"></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </li>
                          <?php endforeach; ?>
                          <!-- email user list end -->
                        </ul>
                      </form>
                    <?php } else { ?>
                      <div class="users-list-wrapper media-list">
                        <div class="container" style="text-align: center !important;color:#607080 !important;margin-top:150px;">
                          <i class="bi bi-folder-x fs-1"></i>
                          <br>
                          <h5 style="color: #607080 !important;">Data tidak ada!</h5>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/pages/email.css">
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    var no_laporan = "<?= $no_laporan ?>";
    report.initDocReady();
  });
</script>
<?= $this->endSection() ?>