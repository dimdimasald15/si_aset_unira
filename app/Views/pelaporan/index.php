<?= $this->extend('layouts/template') ?>

<?= $this->section('content') ?>
<?php echo helper('converter_helper');
?>
<div class="page-heading email-application">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3><?= $title; ?></h3>
        <p class="text-subtitle text-muted">Kelola <?= strtolower($title); ?></p>
      </div>
      <div class="col-12 col-md-4 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item"><a href="dashboard"><i class="fa fa-home"></i></a></li>
            <?php foreach ($breadcrumb as $crumb) : ?>
              <?php if (end($breadcrumb) == $crumb) : ?>
                <li class="breadcrumb-item"><?= $crumb['name'] ?></li>
              <?php else : ?>
                <li class="breadcrumb-item active" aria-current="page"><a href="#"><?= $crumb['name'] ?></a></li>
              <?php endif ?>
            <?php endforeach ?>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <section class="section content-area-wrapper bg-dark text-white shadow">
    <div class="sidebar-left bg-dark text-white">
      <div class="sidebar">
        <div class="sidebar-content email-app-sidebar d-flex">
          <!-- sidebar close icon -->
          <span class="sidebar-close-icon">
            <i class="bx bx-x"></i>
          </span>
          <!-- sidebar close icon -->
          <div class="email-app-menu bg-dark text-white">
            <div class="form-group form-group-compose mt-3">
              <img src="<?= base_url() ?>/assets/images/logo/logouniralandscape.jpg" alt="Logo" style="max-width: 150px;">
            </div>
            <div class="sidebar-menu-list ps">
              <!-- sidebar menu  -->
              <div class="list-group list-group-messages">
                <a href="#" class="list-group-item pt-0 active" id="inbox-menu">
                  <div class="fonticon-wrap d-inline me-3">
                    <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                      <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#envelope" />
                    </svg>
                    </i>
                  </div>
                  Inbox
                  <span class="badge badge-sm badge-notification bg-light-success px-1 text-success" style="margin-left: 20px;"><?= $belumdibaca ?></span>
                </a>
                <a href="#" class="list-group-item" onclick="trashmenu()" id="trash-menu">
                  <div class="fonticon-wrap d-inline me-3">
                    <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                      <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#trash" />
                    </svg>
                  </div>
                  Trash
                </a>
              </div>
              <!-- sidebar menu  end-->

              <!-- sidebar label start -->
              <!-- <label class="sidebar-label">Labels</label>
              <div class="list-group list-group-labels">
                <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                  Product
                  <span class="bullet bullet-success bullet-sm"></span>
                </a>
                <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                  Work
                  <span class="bullet bullet-primary bullet-sm"></span>
                </a>
                <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                  Misc
                  <span class="bullet bullet-warning bullet-sm"></span>
                </a>
                <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                  Family
                  <span class="bullet bullet-danger bullet-sm"></span>
                </a>
                <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                  Design
                  <span class="bullet bullet-info bullet-sm"></span>
                </a>
              </div> -->
              <!-- sidebar label end -->
              <!-- <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
              </div>
              <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
              </div> -->
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
                      <label for="checkboxsmall"></label>
                    </div>
                    <!-- delete unread dropdown -->
                    <ul class="list-inline m-0 d-flex">
                      <li class="list-inline-item mail-delete" id="multipledelete">
                        <button type="button" onclick="multipledelete()" class="btn btn-icon action-icon" data-toggle="tooltip">
                          <span class="fonticon-wrap">
                            <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                              <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#trash" />
                            </svg>
                          </span>
                          Hapus Sementara
                        </button>
                      </li>
                      <li class="list-inline-item mail-delete" id="multipledeletepermanen" style="display:none;">
                        <button type="button" onclick="multipledeletepermanen()" class="btn btn-icon action-icon" data-toggle="tooltip">
                          <span class="fonticon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                              <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                          </span>
                          Hapus Permanen
                        </button>
                      </li>
                      <li class="list-inline-item recycle" id="restoredata" style="display:none;">
                        <button type="button" class="btn btn-icon action-icon" onclick="restoredata()">
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
                        <input type="text" onkeyup="searchFilter(0);" class="form-control keywords" id="search1" placeholder="Cari laporan kerusakan aset..">
                        <input type="text" onkeyup="searchFilter(1);" class="form-control keywords" id="search2" style="display:none;" placeholder="Cari laporan kerusakan aset..">
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
                      <div class="row">
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
                              <!-- <div id="collapse7" role="tabpanel" aria-labelledby="headingCollapse7" class="collapse show"> -->
                              <div class="card-content">
                                <div class="card-body py-1">
                                  <p class="text-bold-500" id="title"><?= $pelaporan->title ?></p>
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
                                    <li class="cursor-pointer pb-25" id="foto">
                                      <img src="<?= base_url() ?>assets/images/foto_kerusakan/<?= $pelaporan->foto ?>" alt="<?= $pelaporan->foto ?>.png" width="400">
                                      <small class="text-muted ms-1 attchement-text"><?= $pelaporan->foto ?></small>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <!-- </div> -->
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
                      <ul class="users-list-wrapper media-list data_pelaporan">
                        <?php
                        foreach ($pelaporan as $row) : ?>
                          <li class="media <?= (!$row['viewed_by_admin']) ? '' : 'mail-read' ?>">
                            <div class="user-action">
                              <div class="checkbox-con me-3">
                                <div class="checkbox checkbox-shadow checkbox-sm">
                                  <input type="checkbox" name="id[]" class='form-check-input checkrow' value="<?= $row['id'] ?>">
                                  <label for="checkboxsmall2"></label>
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
                            <div class="media-body" onclick="detaillaporan('<?= $row['no_laporan'] ?>')">
                              <div class="user-details">
                                <div class="mail-items">
                                  <?php if ($row['level'] == 'Mahasiswa') { ?>
                                    <span class="list-group-item-text"><?= $row['nama_anggota'] . " (NIM. " . $row['no_anggota'] . ")" ?></span>
                                  <?php } else { ?>
                                    <span class="list-group-item-text"><?= $row['nama_anggota'] . " (NIDN/NIP. " . $row['no_anggota'] . ")" ?></span>
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
    $('#checkall').prop('checked', false)

    $('#inbox-menu').on('click', function(e) {
      e.preventDefault();
      $('#multipledelete').show();
      $('#multipledeletepermanen').hide();
      $('#restoredata').hide();
      $(this).addClass('active');
      $('#trash-menu').removeClass('active');
      $('#search1').show();
      $('#search2').hide();
      if (no_laporan !== "") {
        // $('.email-action').show(500);
        $('.email-action').removeClass('d-none');
        $.ajax({
          type: "post",
          url: "<?= base_url('pelaporancontroller/tampilcardpelaporan?isRestored=0') ?>",
          dataType: "json",
          success: function(response) {
            $('#detail_laporan_kerusakan').hide(500);
            $('#semuapelaporan').html(response.data).show(500);
          }
        });
      } else {
        $('.pelaporan-detail').hide(500);
        $('.email-user-list').show(500);
        $('.email-action').removeClass('d-none');

      }
    });

    // Check Row
    $('#checkall').click(function() {
      if ($(this).is(':checked')) {
        $('.checkrow').prop('checked', true);
      } else {
        $('.checkrow').prop('checked', false);
      }
    })

    // Check Row
    $(document).on('click', '.checkrow', function() {
      var isAllChecked = true;
      $('.checkrow').each(function() {
        if (!$(this).is(':checked')) {
          isAllChecked = false;
        }
      });
      $('#checkall').prop('checked', isAllChecked);
    });
  });

  function trashmenu() {
    var no_laporan = "<?= $no_laporan ?>";
    $('#trash-menu').addClass('active');
    $('#inbox-menu').removeClass('active');
    $('#multipledelete').hide();
    $('#multipledeletepermanen').show();
    $('#restoredata').show();
    $('#search1').hide();
    $('#search2').show();
    if (no_laporan !== "") {
      // $('.email-action').show(500);
      $('.email-action').removeClass('d-none');
      $.ajax({
        type: "post",
        url: "<?= base_url('pelaporancontroller/tampilcardpelaporan?isRestored=1') ?>",
        dataType: "json",
        success: function(response) {
          $('#detail_laporan_kerusakan').hide(500);
          $('#semuapelaporan').html(response.data).show(500);
        }
      });
    } else {
      $('.email-user-list').hide(500);
      $('.email-action').removeClass('d-none');

      $.ajax({
        type: "post",
        url: "<?= base_url('pelaporancontroller/tampilcardpelaporan?isRestored=1') ?>",
        dataType: "json",
        success: function(response) {
          $('.pelaporan-detail').html('');
          $('.pelaporan-detail').html(response.data).show(500);
        }
      });
    }


  }

  function multipledelete() {
    let selectedRows = $('.data_pelaporan input[type="checkbox"]:checked');

    if (selectedRows.length > 0) {
      // var ids = [];
      var selectedIds = $('input.checkrow:checked').map(function() {
        return $(this).val();
      }).get();
      var jmldata = selectedIds.length;
      Swal.fire({
        title: 'Multiple Delete',
        text: `Apakah kamu yakin ingin menghapus ${jmldata} data <?= strtolower($title); ?> secara temporary?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus saja!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: `<?= $nav ?>/multipledelete`,
            data: {
              ids: selectedIds.join(","),
              jmldata: jmldata,
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  location.href = "<?= site_url('admin/notification') ?>";

                })
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        } else {
          Swal.fire(
            'Gagal', 'Tidak ada data <?= strtolower($title); ?> yang dihapus', 'info'
          )
        }
      });
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Maaf silahkan pilih data <?= strtolower($title); ?> yang mau dihapus'
      })
    }
  }

  function detaillaporan(string) {
    $('.email-user-list').hide(500);
    $('.email-action').addClass('d-none', true);
    $.ajax({
      url: "<?= base_url('pelaporancontroller/tampildetailpelaporan/') ?>" + string,
      dataType: "json",
      success: function(response) {
        $('.pelaporan-detail').empty();
        $('.pelaporan-detail').html(response.data).show(500);
      }
    });
  }

  function restoredata() {
    let selectedRows = $('.data_pelaporan input[type="checkbox"]:checked');

    if (selectedRows.length > 0) {
      // var ids = [];
      var selectedIds = $('input.checkrow:checked').map(function() {
        return $(this).val();
      }).get();
      var jmldata = selectedIds.length;
      Swal.fire({
        title: 'Pulihkan Data',
        text: `Apakah kamu yakin ingin memulihkan ${jmldata} data <?= strtolower($title); ?>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Pulihkan!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: `<?= $nav ?>/restoredata`,
            data: {
              ids: selectedIds.join(","),
              jmldata: jmldata,
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  location.href = "<?= site_url('admin/notification') ?>";
                })
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        } else {
          Swal.fire(
            'Gagal', 'Tidak ada data <?= strtolower($title); ?> yang dipulihkan', 'info'
          )
        }
      });
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Maaf silahkan pilih data <?= strtolower($title); ?> yang mau dipulihkan'
      })
    }
  }

  function multipledeletepermanen() {
    let selectedRows = $('.data_pelaporan input[type="checkbox"]:checked');

    if (selectedRows.length > 0) {
      // var ids = [];
      var selectedIds = $('input.checkrow:checked').map(function() {
        return $(this).val();
      }).get();
      var jmldata = selectedIds.length;
      Swal.fire({
        title: 'Multiple Delete',
        text: `Apakah kamu yakin ingin menghapus ${jmldata} data <?= strtolower($title); ?> secara permanen?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus saja!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: `<?= $nav ?>/multipledeletepermanen`,
            data: {
              ids: selectedIds.join(","),
              jmldata: jmldata,
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  location.href = "<?= site_url('admin/notification') ?>";
                })
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        } else {
          Swal.fire(
            'Gagal', 'Tidak ada data <?= strtolower($title); ?> yang dihapus secara permanen', 'info'
          )
        }
      });
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Perhatian',
        text: 'Maaf silahkan pilih data <?= strtolower($title); ?> yang mau dihapus secara permanen'
      })
    }
  }

  function searchFilter(bool) {
    var keywords = '';
    if ($('#search1').val()) {
      var keywords = $('#search1').val();
    }
    if ($('#search2').val()) {
      var keywords = $('#search2').val();
    }
    $('.email-user-list').hide();
    if (keywords !== '') {
      $.ajax({
        type: 'get',
        url: '<?= base_url('pelaporancontroller/tampilcardpelaporan') ?>',
        data: {
          keywords: keywords,
          isRestored: bool,
        },
        dataType: 'json',
        beforeSend: function() {
          $('.loading').show();
        },
        complete: function() {
          $('.loading').fadeOut("slow");
        },
        success: function(response) {
          $('.pelaporan-detail').html('');
          $('.pelaporan-detail').html(response.data).show();
        }
      });
    } else if (keywords == '' && bool == 0) {
      $('.pelaporan-detail').html('').hide();
      $('.email-user-list').show();
    } else if (keywords == '' && bool == 1) {
      trashmenu();
    }
  }
</script>
<?= $this->endSection() ?>