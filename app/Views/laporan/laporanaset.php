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
      <p class="mb-1 mt-3">Tabel 1. Laporan Barang Tetap</p>
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
    <p class="mb-1 mt-3">Tabel 2. Laporan Pembelian Barang Tetap</p>
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
              <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total pengeluaran bulan <?= $key1 ?></td>
              <td class="td_uang">
                <?php
                $t_bulanan = 0;
                foreach ($row1 as $key2 => $row2) {
                  $t_bulanan += (int) $row2["total_harga"];
                }
                echo format_uang($t_bulanan);
                ?>
              </td>
            </tr>
          <?php
        } ?>
          <tr>
            <td class="text-right" colspan="5" style="font-style:'bold';text-align: right;">Total pengeluaran keseluruhan</td>
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
    <p class="mb-1 mt-3">Tabel 3. Laporan Permintaan Barang Persediaan</p>
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
                foreach ($row1 as $key2 => $row2) {
                  $t_bulanan += (int) $row2["total_val"];
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
    <!-- <p class="mb-1 mt-3">the fourth page</p> -->
  </div>
  <div id="footer">
    <p class="page"></p>
  </div>
  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>