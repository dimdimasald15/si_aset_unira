<?= $this->extend('/layouts/template2') ?>

<?= $this->section('content') ?>
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
        <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
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
                      <?= format_warna($barang->warna) ?>
                    </td>
                  </tr>
                  <tr>
                    <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Harga Beli</th>
                    <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                    <td><?=
                        format_uang($barang->harga_beli);

                        ?>
                    </td>
                  </tr>
                  <tr>
                    <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Harga Jual</th>
                    <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                    <td><?=
                        format_uang($barang->harga_jual)
                        ?></td>
                  </tr>
                  <tr>
                    <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Tanggal Pembelian</th>
                    <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                    <td>
                      <?= format_tanggal($barang->tgl_pembelian)
                      ?>
                    </td>
                  </tr>
                  <?php if ($barang->updated_at !== null) { ?>
                    <tr>
                      <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Updated at</th>
                      <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                      <td><?=
                          'Diperbarui oleh ' . $barang->updated_by . ' pada ' . format_tanggal($barang->updated_at);
                          ?></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <th class="table-light" style="max-width:150px;pointer-events: none;" scope="row">Created at</th>
                      <td class="table-light" style="width:10px"> <strong>:</strong> </td>
                      <td><?= 'Dibuat oleh ' . $barang->created_by . ' pada ' . format_tanggal($barang->created_at);
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
              Apakah barang dalam kondisi baik? Jika tidak, maka silahkan <a href="<?= base_url() ?>laporan-kerusakan-aset/<?= str_replace(".", "-", $barang->kode_brg) . "-" . $barang->ruang_id ?>" class="text-decoration-underline"> Lapor Kerusakan Aset</a>
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
<?= $this->endSection() ?>