<?= $this->extend('/layouts/template') ?>
<?= $this->section('content') ?>
<?php
function renderTable($isRestore = false)
{
  $columns = [
    "No.",
    "Nama Peminjam",
    "Asal",
    "Nama Barang",
    "Jumlah Barang",
    "Keterangan",
    "Tanggal Pinjam",
    "Tanggal Kembali",
    "Status",
    $isRestore ? "Deleted By" : "Created By",
    $isRestore ? "Deleted At" : "Created At",
    "Action"
  ];
  return $columns;
}
?>
<section class="section">
  <div class="col-12 col-md-12 viewdata shadow-sm" style="display:none;"></div>
  <div class="card shadow mb-3 datalist-pinjam">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-md-auto btn-datapinjam">
            <button type="button" class="btn btn-primary" id="btn-restore" onClick="pinjam.viewTableRestore()">
              <i class="fa fa-recycle"></i> Recycle Bin
            </button>
          </div>
          <div class="col-lg-auto btn-datarestorepinjam" style="display:none;">
            <button class="btn btn-success" onclick="pinjam.restoreAll()"><i class="fa fa-undo"></i> Pulihkan semua</button>
            <button class="btn btn-danger" onclick="pinjam.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body table-restore" style="display:none;">
      <div class="table-responsive py-4">
        <table class="table table-flush" id="table-restore" width="100%">
          <thead class=" thead-light">
            <tr>
              <?php
              $columnsRestore = renderTable(true);
              $columnsSplice = array_splice($columnsRestore, 6, 3);
              foreach ($columnsRestore as $row) :
              ?>
                <th><?= $row ?></th>
              <?php endforeach ?>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
    <div class="card-body table-pinjam">
      <form id="formmultipledelete" onSubmit="pinjam.multipleDelete(this, event)">
        <div class="row m-1">
          <div class="col-md-9 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
            <div class="mx-1">
              <button class="btn btn-success" type="button" onclick="pinjam.getForm('add')"><i class="fa fa-plus-square-o"></i> Input Peminjaman</button>
            </div>
            <div class="mx-1">
              <button class="btn btn-warning" type="button" onClick="pinjam.getReturnForm('updateKembali')"><i class="fa fa-edit"></i> Form Pengembalian</button>
            </div>
            <div class="btn-group">
              <button type="button" class="btn dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6610f2!important;color:white !important;">
                <i class="fa fa-print"></i> Ekspor Pdf
              </button>
              <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" onclick="pinjam.printPdf('opsi1')"> Berdasarkan tanggal
                  </a>
                </li>
                <li><a class="dropdown-item" onclick="pinjam.printPdf('opsi2')">Berdasarkan bulan & tahun
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-3 pb-0 pt-3 px-0 d-flex justify-content-end">
            <button type="submit" class="btn btn-danger btn-multipledelete">
              <i class="fa fa-trash-o"></i> Multiple Delete
            </button>
          </div>
        </div>
        <div class="table-responsive py-4">
          <table class="table table-flush" id="table-pinjam" width="100%">
            <thead class=" thead-light">
              <tr>
                <th><input type="checkbox" id="checkall"></th>
                <?php foreach (renderTable(false) as $row) : ?>
                  <th><?= $row ?></th>
                <?php endforeach ?>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </form>
    </div>
    <div class="row m-2 btn-datarestorepinjam" style="display:none;">
      <h6>
        <a href="<?= $nav; ?>">&laquo; Kembali ke data <?= strtolower($title); ?></a>
      </h6>
    </div>
  </div>

  <div class="viewmodal" style="display:none;"></div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  let jenistrx = "Peminjaman <?= $jenis_kat ?>";
  let jenis_kat = "<?= $jenis_kat ?>";
  let tablePinjam = "";

  $(document).ready(function() {
    util.handleCheckAll('#checkall', `.checkrow`);
    tablePinjam = pinjam.listData('table-pinjam', `${nav}/listdatapeminjaman?jenis_kat=${jenis_kat}&isRestore=0`, false);
  });
</script>
<?= $this->endSection() ?>