<?= helper('converter_helper'); ?>

<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistem Manajemen Aset UNIRA MALANG">
  <meta name="author" content="Dimas Aldi Sallam">
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Poppins:wght@300;400;500;600;700;800&family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css"> -->
  <?= $this->renderSection('styles') ?>
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/iconly/bold.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/pdfstyle.css">
</head>

<body>
  <div id="header">
    <div class="absolute logo">
      <img src="<?= base_url('assets/images/logo/logounira.jpg') ?>">
    </div>
    <div class="absolute txt1">
      <h4 class="text-left">YAYASAN PERGURUAN TINGGI ISLAM RADEN RAHMAT</h4>
    </div>
    <div class="absolute txt2">
      <h2 class="text-left">UNIVERSITAS ISLAM RADEN RAHMAT</h2>
    </div>
    <div class="absolute txt3">
      <h3 class="text-left">BAGIAN UMUM DAN KERUMAHTANGGAN</h3>
      <div class="line"></div>
    </div>
    <div class="absolute txt4">
      <p>inspiring, excelent, humble</p>
    </div>
  </div>
  <div id="content">
    <h2 class="text-center"><?= $title ?> (<?= $haritanggal ?>)</h2>
    <?php if (count($permintaan) > 0) { ?>
      <p>Tabel 1. <?= $title ?></p>
      <table>
        <?php
        foreach ($permintaan as $key1 => $row1) {
          // echo isBulanTahun($key1);
          if (isBulanTahun($key1)) {
        ?>
            <tr>
              <td class="text-center" style="font-style : bold;" colspan="7">Permintaan Bulan <?= $key1 ?></td>
            </tr>
          <?php
          }
          ?>
          <thead class="text-center">
            <tr>
              <th>No.</th>
              <th>Nama Peminta</th>
              <th>Unit</th>
              <th>Nama Barang</th>
              <th>Jumlah</th>
              <th>Harga Beli</th>
              <th>Total Valuasi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($row1 as $key2 => $row2) {
            ?>
              <tr>
                <td class="text-center"><?= $key2 + 1 ?></td>
                <td><?= $row2['nama_anggota'] ?></td>
                <td><?= $row2['singkatan'] ?></td>
                <td><?= $row2['nama_brg'] ?></td>
                <td><?= $row2['jml_barang'] . ' ' . $row2['kd_satuan'] ?></td>
                <td class="td_uang"><?= $row2['hargabeli'] ?></td>
                <td class="td_uang"><?= $row2['totalval'] ?></td>
              </tr>
            <?php
            }
            ?>
          <?php
        } ?>
          <tr>
            <td class="text-right" colspan="6" style="font-style:'bold';text-align: right;">Total Pengeluaran</td>
            <td class="td_uang">
              <?php
              $total = 0;
              foreach ($permintaan as $key1 => $row1) {
                foreach ($row1 as $key2 => $row2) {
                  $total += (int) $row2["total_val"];
                }
              }
              echo format_uang($total);
              ?>
            </td>
          </tr>
          </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-size: 20px;">Data Kosong! Tidak Ada Permintaan pada <?= $haritanggal ?></p>
    <?php } ?>
    <!-- <p style="page-break-before: always;">the second page</p>
    <p style="page-break-before: always;">the third page</p> -->
  </div>
  <div id="footer">
    <p class="page"></p>
  </div>

  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>