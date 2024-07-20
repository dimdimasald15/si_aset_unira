<?= $this->extend('/layouts/template'); ?>
<?= $this->section('content') ?>
<section class="section">
  <div class="col-12 col-md-12 bg-dark viewdata shadow bg-dark shadow" style="display:none;"></div>
  <div class="card shadow mb-3 datalist-gedung">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-9">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-3 d-flex flex-row-reverse">
          <button type="button" class="btn btn-success" onClick="util.getForm('create')">
            <i class="bi bi-building"></i>
            Tambah <?= $title ?>
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive py-4">
        <table class="table table-flush" id="table-gedung" width="100%">
          <thead class=" thead-light">
            <tr>
              <!-- <th style="width: 50px;">No.</th> -->
              <th>No.</th>
              <th>Nama Gedung</th>
              <th>Prefix Gedung</th>
              <th>Kategori</th>
              <th>Created By</th>
              <th>Created At </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    gedung.listData('table-gedung', `${nav}/listdatagedung`)
  });
</script>
<?= $this->endSection() ?>