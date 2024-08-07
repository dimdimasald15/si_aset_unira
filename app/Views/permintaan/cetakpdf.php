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
      <table>
        <caption>Tabel 1. <?= $title ?></caption>
        <?php
        foreach ($permintaan as $key1 => $row1) {
          // echo isBulanTahun($key1);
          if (isBulanTahun($key1)) {
        ?>
            <tr>
              <td class="text-center" colspan="8"><b>Permintaan Bulan <?= $key1 ?></b></td>
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
              <th>Tanggal</th>
              <th>Harga Beli</th>
              <th>Total Valuasi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Gabungkan data berdasarkan nama peminta dan unit
            $groupedData = [];
            foreach ($row1 as $row2) {
              $key = $row2['nama_anggota'] . '|' . $row2['singkatan'];
              if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                  'nama_anggota' => $row2['nama_anggota'],
                  'singkatan' => $row2['singkatan'],
                  'tgl_minta' => $row2['tgl_minta'],
                  'barang' => [],
                  'total_val' => 0
                ];
              }
              $groupedData[$key]['barang'][] = $row2;
              $groupedData[$key]['total_val'] += (int)$row2['totalval'];
            }

            $no = 1;
            foreach ($groupedData as $group) {
              foreach ($group['barang'] as $index => $barang) {
            ?>
                <tr>
                  <?php if ($index == 0) { ?>
                    <td class="text-center" rowspan="<?= count($group['barang']) ?>"><?= $no++ ?></td>
                    <td rowspan="<?= count($group['barang']) ?>"><?= $group['nama_anggota'] ?></td>
                    <td rowspan="<?= count($group['barang']) ?>"><?= $group['singkatan'] ?></td>
                  <?php } ?>
                  <td><?= $barang['nama_brg'] ?></td>
                  <td><?= $barang['jml_barang'] . ' ' . $barang['kd_satuan'] ?></td>
                  <td><?= date('d/m/Y', strtotime($row2['tgl_minta'])) ?></td>
                  <td class="td_uang"><?= $barang['hargabeli'] ?></td>
                  <td class="td_uang"><?= $barang['totalval'] ?></td>
                </tr>
            <?php
              }
            }
            ?>
            <tr>
              <td class="text-right" colspan="7" style="text-align: right;"><b>Total pengeluaran bulan <?= $key1 ?></b></td>
              <td class="td_uang"><b>
                  <?php
                  $total = 0;
                  foreach ($row1 as $key2 => $row2) {
                    $total += (int) $row2["total_val"];
                  }
                  echo format_uang($total);
                  ?>
                </b>
              </td>
            </tr>
          <?php
        } ?>
          <tr>
            <td class="text-right" colspan="7" style="text-align: right;"><b>Total pengeluaran keseluruhan</b></td>
            <td class="td_uang"><b>
                <?php
                $total = 0;
                foreach ($permintaan as $key1 => $row1) {
                  foreach ($row1 as $key2 => $row2) {
                    $total += (int) $row2["total_val"];
                  }
                }
                echo format_uang($total);
                ?>
              </b>
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