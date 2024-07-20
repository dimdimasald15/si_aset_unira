<?= helper('converter_helper'); ?>

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
            <tr>
              <td class="text-right" colspan="6" style="font-style:'bold';text-align: right;">Total pengeluaran bulan <?= $key1 ?></td>
              <td class="td_uang">
                <?php
                $total = 0;
                foreach ($row1 as $key2 => $row2) {
                  $total += (int) $row2["total_val"];
                }
                echo format_uang($total);
                ?>
              </td>
            </tr>
          <?php
        } ?>
          <tr>
            <td class="text-right" colspan="6" style="font-style:'bold';text-align: right;">Total pengeluaran keseluruhan</td>
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
      <p class="text-center mt-5" style="font-size: 20px;">Data Kosong! Belum Ada Permintaan pada <?= $haritanggal ?></p>
    <?php } ?>
  </div>
  <div id="footer">
    <p class="page"></p>
  </div>
</body>

</html>