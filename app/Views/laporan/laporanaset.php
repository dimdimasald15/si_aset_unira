<?= helper('converter_helper') ?>
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
  <style>

  </style>
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
    <h2 class="text-center">Laporan Aset Universitas Islam Raden Rahmat</h2>
    <p class="mb-1 mt-3">Table 1. Pengkategorian Aset Tetap</p>
    <table class="tablekategori">
      <thead class="text-center">
        <tr>
          <th>No.</th>
          <th>Kode Kategori</th>
          <th>Nama Kategori</th>
          <th>Deskripsi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($kat_tetap as $key => $row) : ?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td><?= $row->kd_kategori ?></td>
            <td><?= $row->nama_kategori ?></td>
            <td><?= ($row->deskripsi) ? $row->deskripsi : "tidak ada deskripsi" ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p style="page-break-before: always;">Tabel 2. Pengkategorian Barang Persediaan</p>
    <?php
    $halfLength = ceil(count($kat_sedia) / 2);
    $data1 = array_slice($kat_sedia, 0, $halfLength);
    $data2 = array_slice($kat_sedia, $halfLength);
    ?>
    <table class="tblpersediaan">
      <thead class="text-center">
        <tr>
          <th>No.</th>
          <th>Kode Kategori</th>
          <th>Nama Kategori</th>
          <th style="border-color: #ffffff #000000 #ffffff #000000;"></th>
          <th>No.</th>
          <th>Kode Kategori</th>
          <th>Nama Kategori</th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i = 0; $i < count($data1); $i++) :
        ?>
          <tr>
            <td class="text-center"><?= $i + 1 ?></td>
            <td><?= $data1[$i]->kd_kategori ?></td>
            <td><?= $data1[$i]->nama_kategori ?></td>
            <td class="celah"></td>
            <td class="text-center"><?= $i + $halfLength + 1 ?></td>
            <td><?= $data2[$i]->kd_kategori ?></td>
            <td><?= $data2[$i]->nama_kategori ?></td>
          </tr>
        <?php endfor; ?>

      </tbody>
    </table>
    <p class="mb-1 mt-3">Tabel 3. Laporan Barang Tetap</p>
    <?php if (count($brgtetap) > 0) { ?>
      <table>
        <thead class="text-center">
          <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Sisa Stok</th>
            <th>Harga Jual</th>
            <th>Total Valuasi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($brgtetap as $key => $row) :
          ?>
            <tr>
              <td class="text-center"><?= $key + 1 ?></td>
              <td><?= $row['kode_brg'] ?></td>
              <td style="width:210px"><?= $row['nama_brg'] . " (" . format_warna($row['warna']) . ")" ?></td>
              <td><?= $row['stok_terbaru'] . ' ' . $row['kd_satuan'] ?></td>
              <td class="td_uang"><?= $row['hargajual'] ?></td>
              <td class="td_uang"><?= $row['totalval'] ?></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total Kekayaan Aset</td>
            <td class="td_uang">
              <?php
              $total = 0;
              foreach ($brgtetap as $key => $row) {
                $total += (int) $row["total_val"];
              }
              echo format_uang($total);
              ?>
            </td>
          </tr>
        </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-style: italic bold;">Data Kosong! Barang tidak tersedia</p>
    <?php } ?>
    <p class="mb-1 mt-3">Table 4. Laporan Pembelian Barang Tetap</p>
    <?php if (count($belibrgtetap) > 0) { ?>
      <table>
        <?php
        foreach ($belibrgtetap as $key1 => $row1) {
          // echo isBulanTahun($key1);
          if (isBulanTahun($key1)) {
        ?>
            <tr>
              <td class="text-center" style="font-style : bold;" colspan="6">Pembelian Bulan <?= $key1 ?></td>
            </tr>
          <?php
          }
          ?>
          <thead class="text-center">
            <tr>
              <th>No.</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Jumlah</th>
              <th>Harga Beli</th>
              <th>Total Harga</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($row1 as $key2 => $row2) {
            ?>
              <tr>
                <td class="text-center"><?= $key2 + 1 ?></td>
                <td><?= $row2['kode_brg'] ?></td>
                <td style="width:210px;"><?= $row2['nama_brg'] . " (" . format_warna($row['warna']) . ")"  ?></td>
                <td><?= $row2['jml_msk'] . ' ' . $row2['kd_satuan'] ?></td>
                <td class="td_uang"><?=
                                    format_uang($row2['hrg_beli_brg'])
                                    ?></td>
                <td class="td_uang"><?= format_uang($row2['total_harga']) ?></td>
              </tr>
            <?php
            }
            ?>
            <tr>
              <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total Pengeluaran bulan <?= $key1 ?></td>
              <td class="td_uang">
                <?php
                $t_bulanan = 0;
                foreach ($belibrgtetap as $key1 => $row1) {
                  foreach ($row1 as $key2 => $row2) {
                    $t_bulanan += (int) $row2["total_harga"];
                  }
                }
                echo format_uang($t_bulanan);
                ?>
              </td>
            </tr>
          <?php
        } ?>
          <tr>
            <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total Pengeluaran Keseluruhan</td>
            <td class="td_uang">
              <?php
              $t_tahunan = 0;
              foreach ($belibrgtetap as $key1 => $row1) {
                foreach ($row1 as $key2 => $row2) {
                  $t_tahunan += (int) $row2["total_harga"];
                }
              }
              echo format_uang($t_tahunan);
              ?>
            </td>
          </tr>
          </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-style: italic bold;">Data Kosong! Tidak ada pembelian barang tetap pada <?= $bulantahun ?></p>
    <?php } ?>
    <p class="mb-1 mt-3">Table 5. Laporan Permintaan Barang Persediaan</p>
    <?php if (count($permintaan) > 0) { ?>
      <table>
        <?php
        foreach ($permintaan as $key1 => $row1) {
          // echo isBulanTahun($key1);
          if (isBulanTahun($key1)) {
        ?>
            <tr>
              <td class="text-center" style="font-style : bold;" colspan="6">Permintaan Bulan <?= $key1 ?></td>
            </tr>
          <?php
          }
          ?>
          <thead class="text-center">
            <tr>
              <th>No.</th>
              <th>Kode Barang</th>
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
                <td><?= $row2['kode_brg'] ?></td>
                <td style="width:210px;"><?= $row2['nama_brg'] . " (" . format_warna($row['warna']) . ")"  ?></td>
                <td><?= $row2['jml_barang'] . ' ' . $row2['kd_satuan'] ?></td>
                <td class="td_uang"><?= $row2['hargabeli'] ?></td>
                <td class="td_uang"><?= $row2['totalval'] ?></td>
              </tr>
            <?php
            }
            ?>
            <tr>
              <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total Pengeluaran bulan <?= $key1 ?></td>
              <td class="td_uang">
                <?php
                $t_bulanan = 0;
                foreach ($permintaan as $key1 => $row1) {
                  foreach ($row1 as $key2 => $row2) {
                    $t_bulanan += (int) $row2["total_val"];
                  }
                }
                echo format_uang($t_bulanan);
                ?>
              </td>
            </tr>
          <?php
        } ?>
          <tr>
            <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total Pengeluaran Keseluruhan</td>
            <td class="td_uang">
              <?php
              $t_tahunan = 0;
              foreach ($permintaan as $key1 => $row1) {
                foreach ($row1 as $key2 => $row2) {
                  $t_tahunan += (int) $row2["total_val"];
                }
              }
              echo format_uang($t_tahunan);
              ?>
            </td>
          </tr>
          </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-style: italic bold;">Data Kosong! Tidak ada permintaan barang persediaan pada <?= $bulantahun ?></p>
    <?php } ?>
    <p class="mb-1 mt-3">the fourth page</p>
  </div>
  <div id="footer">
    <p class="page"></p>
  </div>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>