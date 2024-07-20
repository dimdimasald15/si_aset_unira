<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="col-12 col-md-12 bg-dark viewdata shadow bg-dark shadow" style="display:none;"></div>
  <div class="card shadow mb-3 datalist-ruang">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-lg-auto btn-dataruang">
            <button type="button" class="btn btn-success" id="btn-tambahruang" onClick="util.getForm('add')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"></path>
                <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"></path>
              </svg>
              Tambah Ruangan
            </button>
            <button type="button" class="btn btn-primary" id="btn-restore" onClick="ruang.viewTableRestore()"><i class="fa fa-recycle"></i> Recycle Bin</button>
          </div>
          <div class="col-lg-auto btn-datarestoreruang" style="display:none;">
            <button class="btn btn-success" onclick="ruang.restoreAll()"><i class="fa fa-undo"></i> Pulihkan semua</button>
            <button class="btn btn-danger" onclick="ruang.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    function generateTable($id, $isRestore)
    {
      $columns = [
        "No.",
        "Nama Ruangan",
        "Nama Lantai",
        "Prefix Gedung",
        "Nama Gedung",
        $isRestore ? "Deleted By" : "Created By",
        $isRestore ? "Deleted At" : "Created At",
        "Action"
      ];
    ?>
      <div class="card-body table-<?= $isRestore ? 'restore' : 'ruang' ?>" <?= $isRestore ? 'style="display:none;"' : '' ?>>
        <div class="table-responsive py-4">
          <table class="table table-flush" id="<?= $id ?>" width="100%">
            <thead class="thead-light">
              <tr>
                <?php foreach ($columns as $column) : ?>
                  <th><?= $column ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    <?php
    }
    generateTable('table-restore', true);
    generateTable('table-ruang', false);
    ?>
    <div class="row m-2 btn-datarestoreruang" style="display:none;">
      <h6>
        <a href="<?= $nav ?>">&laquo; Kembali ke data <?= strtolower($title) ?></a>
      </h6>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    ruang.listData('table-ruang', `${nav}/listdata?isRestore=0`)
  });
</script>
<?= $this->endSection() ?>