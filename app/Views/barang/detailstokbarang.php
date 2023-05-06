<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Manajemen Aset UNIRA MALANG">
  <meta name="author" content="DimasAldiSallam">
  <title><?= $title; ?> | SI-ASET UNIRA MALANG</title>

  <!--  Social tags      -->
  <meta name="keywords" content="sistem informasi, manajemen aset, labelling assets, qr code, perguruan tinggi, UNIRA, malang, universitas">
  <meta name="description" content="Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang">
  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="Sistem Informasi Manajemen Aset">
  <meta itemprop="description" content="Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang">
  <meta itemprop="image" content="<?= base_url('assets/images/unira.png') ?>">
  <!-- Favicon -->
  <link rel="icon" href="<?= base_url('assets/images/logo/logounira.jpg') ?>" type="image/png">

  <link rel="preconnect" href="https://fonts.gstatic.com">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css">
  <?= $this->renderSection('styles') ?>
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/iconly/bold.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.css">
  <!-- sweetalert2 -->
  <link href="<?= base_url() ?>/assets/vendors/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

  <!-- fontawesome -->
  <link href="<?= base_url() ?>/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="<?= base_url() ?>/assets/vendors/jquery/jquery.min.js"></script>
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">

  <!-- Cropper.js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-cyzxRvewl+FOKTtpBzYjW6x6IAYUCZy3sGP40hn+DQkqeluGRCax7qztK2ImL64SA+C7kVWdLI6wvdlStawhyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6lplKUSl86rUVprDIjiW8DuOniNX8UDoRATqZSds/7t6zCQZfaCe3e5zcGaQwxa8Kpn5RTM9Fvl3X2lLV4grPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- HTML2Canvasjs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

  <!-- HTML2PDFJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <style>
    #circle {
      width: 50px;
      height: 25px;
      border-radius: 10%;
      border: 2px solid rgba(0, 0, 0, 0.5);
      background-color: <?= $barang->warna; ?>;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    }
  </style>

</head>

<body class="bg-success mt-3">
  <div class="main-content">
    <div class="header bg-success pt-4 pb-5 py-lg-4">
      <div class="container">
        <div class="header-body text-center mb-3">
          <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 col-md-8 px-5">
              <div class="text-center mb-3">
                <img src="<?= base_url('assets/images/logo/logounira.jpg') ?>" style="max-width: 60px;border:2px solid white;">
              </div>
              <p class="text-lead text-white">Sistem Informasi Manajemen Aset UNIRA Malang</p>
            </div>
          </div>
        </div>
        <div class="row" id="laporanaset" style="display:none;"></div>
        <?php if ($barang) { ?>
          <div class="row justify-content-center" id="detailbrg">
            <div class="col-lg-9 col-md-9 col-12">
              <div class="card shadow border-0 mb-0">
                <div class="card-header shadow_sm bg-transparent pb-1">
                  <div class="card-title text-center text-muted">
                    <h3 class="mb-2"><?= $barang->nama_brg; ?></h3>
                    <hr>
                  </div>
                </div>
                <div class="card-body" style="padding: 0.5rem 5rem 1rem 5rem;">
                  <div class="row">
                    <?php if ($barang->foto_barang) { ?>
                      <img src="<?= base_url() ?>/assets/images/foto_barang/<?= $barang->foto_barang ?>" alt="Gambar Barang" class="rounded mx-auto d-block shadow-sm" style="width:300px; height:auto;">
                    <?php } else { ?>
                      <img src="https://via.placeholder.com/150x150.png?text=No+Image" alt="No Image" class="rounded mx-auto d-block shadow-sm" style="width:150px; height:auto;">
                    <?php } ?>
                  </div>
                  <div class="row mt-5">
                    <div class="col-lg-12">
                      <div class="table-responsive">
                        <table class="table table-responsive-sm table-borderless ">
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Kode Barang</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?= $barang->kode_brg ?></td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Kategori Barang</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?= $barang->nama_kategori ?></td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Jumlah Barang</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?= $barang->sisa_stok . ' ' . $barang->kd_satuan ?></td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Lokasi Barang</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?= $barang->nama_ruang ?></td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row" colspan="3">Deskripsi Barang</th>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Asal Barang</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <?php if ($barang->toko) { ?>
                              <td><?= $barang->asal . ' di ' . $barang->toko; ?></td>
                            <?php } else if ($barang->instansi) { ?>
                              <td><?= $barang->asal . ' di ' . $barang->instansi; ?></td>
                            <?php }  ?>
                          </tr>
                          <?php if ($barang->no_seri !== "" && $barang->no_dokumen !== "" && $barang->no_seri !== null && $barang->no_dokumen !== null) { ?>
                            <tr>
                              <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Nomor Seri</th>
                              <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                              <td><?= $barang->no_seri ?></td>
                            </tr>
                            <tr>
                              <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Nomor Dokumen</th>
                              <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                              <td><?= $barang->no_dokumen ?></td>
                            </tr>
                          <?php } else '' ?>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Merk</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?= $barang->merk ?></td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Warna</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td>
                              <div id="circle"></div>
                            </td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Harga Beli</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?php
                                $harga_beli = $barang->harga_beli;
                                $harga_beli_formatted = 'Rp ' . number_format($harga_beli, 0, ',', '.') . ',-';
                                echo $harga_beli_formatted;
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Harga Jual</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td><?php
                                $harga_jual = $barang->harga_jual;
                                $harga_jual_formatted = 'Rp ' . number_format($harga_jual, 0, ',', '.') . ',-';
                                echo $harga_jual_formatted;
                                ?></td>
                          </tr>
                          <tr>
                            <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Tanggal Pembelian</th>
                            <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                            <td>
                              <?php
                              $tglbrgtetap = $barang->tgl_pembelian;
                              $tglbrgpersediaan = $barang->tgl_beli;
                              $tanggal_beli = '';
                              if ($barang->tgl_beli) {
                                $tanggal_beli = date('j F Y', strtotime($tglbrgpersediaan));
                                echo $tanggal_beli;
                              } else if ($barang->tgl_pembelian) {
                                $tanggal = $barang->tgl_pembelian;
                                $tanggal_beli = date('j F Y', strtotime($tglbrgtetap));
                                echo $tanggal_beli;
                              }
                              ?>
                            </td>
                          </tr>
                          <?php if ($barang->updated_at !== null) { ?>
                            <tr>
                              <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Updated at</th>
                              <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                              <td><?php $tanggal = $barang->updated_at;
                                  $tanggal_update = date('j F Y', strtotime($tanggal));
                                  echo 'Diperbarui oleh ' . $barang->updated_by . ' pada ' . $tanggal_update;
                                  ?></td>
                            </tr>
                          <?php } else { ?>
                            <tr>
                              <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Created at</th>
                              <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                              <td><?php $tanggal = $barang->created_at;
                                  $tanggal_create = date('j F Y', strtotime($tanggal));
                                  echo 'Dibuat oleh ' . $barang->created_by . ' pada ' . $tanggal_create;
                                  ?></td>
                            </tr>
                          <?php } ?>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer shadow-sm">
                  <div class="row text-center">
                    <div class="col-lg-12">
                      Apakah barang dalam kondisi baik? Jika tidak, maka silahkan <a href="#" class="text-decoration-underline"> Lapor Kerusakan Aset</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } else { ?>
          <div class="card">
            <div class="card-title text-center">
              <div class="row m-3">
                <h4>Mohon maaf, stok Barang Tidak Ada</h4>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>
  </div>
  </div>
  </div>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>

  <!-- Optional Js -->
  <script src="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.js"></script>
  <!-- <script src="<?= base_url() ?>/assets/vendors/fontawesome/all.min.js"></script> -->
  <script src="<?= base_url() ?>/assets/vendors/DataTables/DataTables-1.13.3/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <?= $this->renderSection('javascript') ?>
</body>

</html>