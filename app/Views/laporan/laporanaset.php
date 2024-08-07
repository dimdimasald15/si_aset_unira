<?= helper('converter_helper') ?>
<html>

<head>
  <title><?= $title; ?> | SI-ASET UNIRA MALANG</title>
  <style>
    <?= $css ?>
  </style>
</head>

<body>
  <div id="header">
    <div class="absolute logo">
      <img src="<?= $logo ?>">
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
    <?php if (count($brgtetap) > 0) { ?>
      <table style="page-break-after: always;">
        <caption>Tabel 1. Laporan Barang Tetap</caption>
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
          <?php
          $total = 0;
          foreach ($brgtetap as $key => $row) :
          ?>
            <tr>
              <td class="text-center"><?= $key + 1 ?></td>
              <td><?= $row['kode_brg'] ?></td>
              <td style="width:210px"><?= $row['nama_brg'] . " (" . format_warna($row['warna']) . ")" ?></td>
              <td><?= $row['stok_terbaru'] . ' ' . $row['kd_satuan'] ?></td>
              <td class="td_uang"><?= $row['hargajual'] ?></td>
              <td class="td_uang"><?= $row['totalval'] ?></td>
            </tr>
          <?php
            $total += (int) $row["total_val"];
          endforeach;
          ?>
          <tr>
            <td class="text-right" colspan="5" style="text-align: right;"><b>Total Kekayaan Aset</b></td>
            <td class="td_uang"><b><?= format_uang($total) ?></b></td>
          </tr>
        </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-style: italic bold;">Data Kosong! Barang tidak tersedia</p>
    <?php } ?>
    <?php if (count($belibrgtetap) > 0) { ?>
      <table style="page-break-after: always;">
        <caption>Tabel 2. Laporan Pembelian Barang Tetap</caption>
        <?php
        $t_tahunan = 0; // Inisialisasi total tahunan di luar loop bulan
        foreach ($belibrgtetap as $key1 => $row1) :
          $t_bulanan = 0; // Inisialisasi total bulanan untuk setiap bulan
          if (isBulanTahun($key1)) :  ?>
            <tr>
              <td class="text-center" style="font-weight: bold;" colspan="6">Pembelian Bulan <?= $key1 ?></td>
            </tr>
          <?php endif; ?>
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
            <?php foreach ($row1 as $key2 => $row2) { ?>
              <tr>
                <td class="text-center"><?= $key2 + 1 ?></td>
                <td><?= $row2['kode_brg'] ?></td>
                <td style="width:210px;"><?= $row2['nama_brg'] . " (" . format_warna($row2['warna']) . ")" ?></td>
                <td><?= $row2['jml_msk'] . ' ' . $row2['kd_satuan'] ?></td>
                <td class="td_uang"><?= format_uang($row2['hrg_beli_brg']) ?></td>
                <td class="td_uang"><?= format_uang($row2['total_harga']) ?></td>
              </tr>
            <?php
              $t_bulanan += (int)$row2["total_harga"]; // Tambahkan ke total bulanan
              $t_tahunan += (int)$row2["total_harga"]; // Tambahkan ke total tahunan
            }
            ?>
            <!-- <tr>
              <td class="text-right" colspan="5" style="font-weight: bold;text-align: right;">Total Pengeluaran bulan <?= $key1 ?></td>
              <td class="td_uang"><b><?php // format_uang($t_bulanan); 
                                      ?></b></td>
            </tr> -->
          <?php endforeach ?>
          <tr>
            <td class="text-right" colspan="5" style="font-weight: bold;text-align: right;">Total Pengeluaran Keseluruhan</td>
            <td class="td_uang"><b><?= format_uang($t_tahunan); ?></b></td>
          </tr>
          </tbody>
      </table>

    <?php } else { ?>
      <p class="text-center mt-5" style="font-style: italic bold;">Data Kosong! Tidak ada pembelian barang tetap pada <?= $bulantahun ?></p>
    <?php } ?>
    <?php if (count($permintaan) > 0) { ?>
      <table>
        <caption>Tabel 3. Laporan Permintaan Barang Persediaan</caption>
        <?php
        $t_tahunan2 = 0;
        foreach ($permintaan as $key1 => $row1) {
          $t_bulanan2 = 0;
          if (isBulanTahun($key1)) { ?>
            <tr>
              <td class="text-center" colspan="6"><b>Permintaan Bulan <?= $key1 ?></b></td>
            </tr>
          <?php } ?>
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
            <?php foreach ($row1 as $key2 => $row2) { ?>
              <tr>
                <td class="text-center"><?= $key2 + 1 ?></td>
                <td><?= $row2['kode_brg'] ?></td>
                <td style="width:210px;"><?= $row2['nama_brg'] . " (" . format_warna($row['warna']) . ")"  ?></td>
                <td><?= $row2['jml_barang'] . ' ' . $row2['kd_satuan'] ?></td>
                <td class="td_uang"><?= $row2['hargabeli'] ?></td>
                <td class="td_uang"><?= $row2['totalval'] ?></td>
              </tr>
            <?php
              $t_bulanan2 += (int)$row2["total_val"]; // Tambahkan ke total bulanan
              $t_tahunan2 += (int)$row2["total_val"]; // Tambahkan ke total tahunan
            }
            ?>
            <tr>
              <td class="text-right" colspan="5" style="font-weight: bold;text-align: right;">Total Pengeluaran bulan <?= $key1 ?></td>
              <td class="td_uang"><b><?= format_uang($t_bulanan2); ?></b></td>
            </tr>
          <?php } ?>
          <tr>
            <td class="text-right" colspan="5" style="font-weight: bold;text-align: right;">Total Pengeluaran Keseluruhan</td>
            <td class="td_uang"><b><?= format_uang($t_tahunan2); ?></b></td>
          </tr>
          </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-style: italic bold;">Data Kosong! Tidak ada permintaan barang persediaan pada <?= $bulantahun ?></p>
    <?php } ?>
    <!-- <n>the fourth page</p> -->
  </div>
  <div id="footer">
    <p class="page"></p>
  </div>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>