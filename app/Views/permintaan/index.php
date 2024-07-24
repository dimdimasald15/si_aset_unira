<?= $this->extend('/layouts/template') ?>
<?= $this->section('content') ?>
<?php
function renderTable($isRestore = false)
{
  $columns = [
    "No.",
    "Nama Peminta",
    "Asal",
    "Nama Barang",
    "Jumlah Barang",
    "Waktu Permintaan",
    "Keterangan",
    $isRestore ? "Deleted By" : "Created By",
    $isRestore ? "Deleted At" : "Created At",
    "Action"
  ];
  return $columns;
}
?>
<section class="section">
  <div class="viewdata" style="display:none;"></div>
  <div class="card shadow mb-3 datalist-minta">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-md-auto btn-dataminta">
            <button type="button" class="btn btn-primary" id="btn-restore" onClick="minta.viewTableRestore()">
              <i class="fa fa-recycle"></i> Recycle Bin
            </button>
          </div>
          <div class="col-lg-auto btn-datarestoreminta" style="display:none;">
            <button class="btn btn-success" onclick="minta.restoreAll()"><i class="fa fa-undo"></i> Pulihkan semua</button>
            <button class="btn btn-danger" onclick="minta.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
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
              foreach (renderTable(true) as $row) :
              ?>
                <th><?= $row ?></th>
              <?php endforeach ?>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-body table-minta">
      <form class="formmultipledelete" onSubmit="minta.multipleDelete(this, event)">
        <div class="row m-1">
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
            <div class="mx-1">
              <button class="btn btn-success" type="button" onclick="minta.getForm('add')"><i class="fa fa-plus-square-o"></i> Input Permintaan</button>
            </div>
            <div class="btn-group">
              <button type="button" class="btn dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #6610f2!important;color:white !important;">
                <i class="fa fa-print"></i> Ekspor Pdf
              </button>
              <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" onclick="minta.printPdf('opsi1')"> Berdasarkan tanggal
                  </a>
                </li>
                <li><a class="dropdown-item" onclick="minta.printPdf('opsi2')">Berdasarkan bulan & tahun
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex justify-content-end">
            <button type="submit" class="btn btn-danger btn-multipledelete">
              <i class="fa fa-trash-o"></i> Multiple Delete
            </button>
          </div>
        </div>
        <div class="table-responsive py-4">
          <table class="table table-flush" id="table-minta" width="100%">
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
    <div class="row m-2 btn-datarestoreminta" style="display:none;">
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
  let jenistrx = "Permintaan <?= $jenis_kat ?>";
  let jenis_kat = "<?= $jenis_kat ?>";
  let tableMinta = "";

  $(document).ready(function() {
    util.handleCheckAll('#checkall', `.checkrow`);
    tableMinta = minta.listData('table-minta', `${nav}/listdatapermintaan?jenis_kat=${jenis_kat}&isRestore=0`, false);
  });
</script>
<?= $this->endSection() ?>