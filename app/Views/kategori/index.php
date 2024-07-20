<?= $this->extend('/layouts/template'); ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="col-12 col-md-12 bg-dark viewdata shadow bg-dark shadow" style="display:none;"></div>
  <div class="card shadow mb-3 datalist-kategori">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-lg-auto btn-datakategori">
            <button type="button" class="btn btn-primary" id="btn-restore" onClick="kategori.viewTableRestore()"><i class="fa fa-recycle"></i> Recycle Bin</button>
          </div>
          <div class="col-lg-auto btn-datarestorekategori" style="display:none;">
            <button class="btn btn-success" onclick="kategori.restoreAll()"><i class="fa fa-undo"></i> Pulihkan semua</button>
            <button class="btn btn-danger" onclick="kategori.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
          </div>
        </div>
      </div>
    </div>
    <?php function renderTable($isRestore = false)
    {
      $columns = [
        "No.",
        "Kode Kategori",
        "Nama Kategori",
        "Deskripsi",
        $isRestore ? "Deleted By" : "Created By",
        $isRestore ? "Deleted At" : "Created At",
        "Action"
      ];
      return $columns;
    } ?>
    <div class="card-body table-restore" style="display:none;">
      <div class="table-responsive py-4">
        <table class="table table-flush" id="table-restore" width="100%">
          <thead class=" thead-light">
            <tr>
              <?php foreach (renderTable(true) as $col) : ?>
                <th><?= $col ?></th>
              <?php endforeach ?>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-body table-kategori">
      <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
        <?php foreach ($tabId as $i => $row) : ?>
          <li class="nav-item" role="presentation">
            <a onclick="kategori.handleNavLink()" class="nav-link <?= $row === 'ktetap' ? 'active' : '' ?>" id="<?= $row ?>-tab" data-bs-toggle="tab" href="#<?= $row ?>" role="tab" aria-controls="<?= $row ?>" aria-selected="true">
              Kategori <?= $categoryName[$i] ?>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
      <div class="tab-content" id="myTabContent">
        <?php foreach ($tabId as $i => $row) : ?>
          <div class="tab-pane fade show  <?= $row === 'ktetap' ? 'show active' : '' ?>" id="<?= $row ?>" role="tabpanel" aria-labelledby="<?= $row ?>-tab">
            <div class="row mt-3">
              <div class="col-sm-12 d">
                <button type="button" class="btn btn-success" onclick="kategori.getForm('add','<?= $categoryName[$i] ?>')" id="btn-add<?= $row ?>">
                  <i class="bi bi-layers"></i>
                  Tambah Kategori <?= $categoryName[$i] ?>
                </button>
              </div>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="table-<?= $row ?>" width="100%">
                <thead class=" thead-light">
                  <tr>
                    <?php foreach (renderTable(false) as $col) : ?>
                      <th><?= $col ?></th>
                    <?php endforeach ?>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="row m-2 btn-datarestorekategori" style="display:none;">
      <h6>
        <a href="<?= $nav ?>">&laquo; Kembali ke data <?= strtolower($title) ?></a>
      </h6>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let tableKatTetap, tableKatPersediaan;

  $(document).ready(function() {
    // Initialize DataTables for each tab content
    tableKatTetap = kategori.listData('table-ktetap', `${nav}/listdata?jenis=Barang%20Tetap&isRestore=0`);
    tableKatPersediaan = kategori.listData('table-kpersediaan', `${nav}/listdata?jenis=Barang%20Persediaan&isRestore=0`);
  });
</script>
<?= $this->endSection() ?>