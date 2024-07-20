<?= helper(['converter_helper', 'date']); ?>

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
    <?php if (count($peminjaman) > 0) { ?>
      <table>
        <caption>Tabel 1. <?= $title ?></caption>
        <?php
        foreach ($peminjaman as $key1 => $row1) {
          // echo isBulanTahun($key1);
          if (isBulanTahun($key1)) {
        ?>
            <tr>
              <td class="text-center" style="font-style : bold;" colspan="9">Peminjaman Bulan <?= $key1 ?></td>
            </tr>
          <?php
          }
          ?>
          <thead class="text-center">
            <tr>
              <th>No.</th>
              <th>Nama Peminjam</th>
              <th>Unit</th>
              <th>Nama Barang</th>
              <th>Jumlah</th>
              <th>Tanggal Pinjam</th>
              <th>Durasi Pinjam</th>
              <th>Keterangan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $prevNamaAnggota = null;
            $rowspanCount = 0;
            $no = 1;
            foreach ($row1 as $key => $row2) {
              $currNamaAnggota = $row2['nama_anggota'];

              if ($currNamaAnggota !== $prevNamaAnggota) {
                $rowspanCount = countRowsWithSameNamaAnggota($row1, $currNamaAnggota);
            ?>
                <tr>
                  <td class="text-center" rowspan="<?= $rowspanCount ?>"><?= $no++ ?> .</td>
                  <td rowspan="<?= $rowspanCount ?>"><?= $currNamaAnggota ?></td>
                  <td rowspan="<?= $rowspanCount ?>"><?= $row2['singkatan'] ?></td>
                  <td><?= $row2['nama_brg'] ?></td>
                  <td><?= $row2['jml_barang'] . " " . $row2['kd_satuan'] ?></td>
                  <td><?= date('d/m/Y', strtotime($row2['tgl_pinjam'])) ?></td>
                  <td><?php
                      $tgl1 = strtotime($row2['tgl_pinjam']);
                      $tgl2 = $row2['tgl_kembali'] ? strtotime($row2['tgl_kembali']) : now();

                      $jarak = $tgl2 - $tgl1;

                      $hari = floor($jarak / 60 / 60 / 24) + 1;
                      echo $hari == 0 ? '&lt; 1 hari' : "$hari hari";
                      ?>
                  </td>
                  <td><?= $row2['keterangan'] ?></td>
                  <td><?php
                      $status = $row2['status'] == 1 ? 'Sudah kembali' : 'Belum kembali';
                      echo $status;
                      ?>
                  </td>

                </tr>
              <?php
              } else {
              ?>
                <tr>
                  <td><?= $row2['nama_brg'] ?></td>
                  <td><?= $row2['jml_barang'] . " " . $row2['kd_satuan'] ?></td>
                  <td><?= date('d/m/Y', strtotime($row2['tgl_pinjam'])) ?></td>
                  <td><?php
                      $tgl1 = strtotime($row2['tgl_pinjam']);
                      $tgl2 = $row2['tgl_kembali'] ? strtotime($row2['tgl_kembali']) : now();

                      $jarak = $tgl2 - $tgl1;

                      $hari = floor($jarak / 60 / 60 / 24) + 1;
                      echo $hari == 0 ? '&lt; 1 hari' : "$hari hari";
                      ?>
                  </td>
                  <td><?= $row2['keterangan'] ?></td>
                  <td><?php
                      $status = $row2['status'] == 1 ? 'Sudah kembali' : 'Belum kembali';
                      echo $status;
                      ?>
                  </td>
                </tr>
            <?php }

              $prevNamaAnggota = $currNamaAnggota;
            }
            ?>
          <?php } ?>
          </tbody>
      </table>
    <?php } else { ?>
      <p class="text-center mt-5" style="font-size: 20px;">Data Kosong! Belum Ada Permintaan pada <?= $haritanggal ?></p>
    <?php } ?>
  </div>
  <div id="footer">
    <p class="page"></p>
  </div>

  <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>