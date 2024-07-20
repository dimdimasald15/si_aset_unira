<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="row">
    <div class="col-12 col-md-12 bg-dark viewdata shadow bg-dark shadow" style="display:none;"></div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="card shadow mb-3 datalist-unit">
        <div class="card-header shadow-sm">
          <div class="row justify-content-between align-items-center">
            <div class="col-lg-7">
              <h4 class="card-title">Data Unit</h4>
            </div>
            <div class="col-lg-5 d-flex flex-row justify-content-end">
              <div class="col-lg-auto btn-dataunit">
                <button type="button" class="btn btn-success" id="btn-tambahunit" onClick="util.getForm('add','','<?= $nav . '/tampilformunit' ?>')">
                  <i class="bi bi-circle-square"></i>
                  Tambah unit
                </button>
                <button type="button" class="btn btn-primary" id="btn-restoreunit" onClick="unit.viewTableRestore()">
                  <i class="fa fa-recycle"></i> Recycle Bin
                </button>
              </div>
              <div class="col-lg-auto btn-datarestoreunit" style="display:none;">
                <button class="btn btn-success" onclick="unit.restoreAll()"><i class="fa fa-undo"></i> Pulihkan semua</button>
                <button class="btn btn-danger" onclick="unit.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body table-restoreunit" style="display:none;">
          <div class="table-responsive py-4">
            <table class="table table-flush" id="table-restoreunit" width="100%">
              <thead class=" thead-light">
                <tr>
                  <th></th>
                  <th>Nama unit</th>
                  <th>Singkatan</th>
                  <th>Deleted By</th>
                  <th>Deleted At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-body table-unit">
          <form id="formDeleteUnit" onSubmit="unit.multipleDelete(this, event)">
            <div class="row m-1">
              <div class="col-md-12 pb-0 pt-3 px-0 d-flex justify-content-end">
                <button type="submit" class="btn btn-danger btn-DeleteUnit">
                  <i class="fa fa-trash-o"></i> Multiple Delete
                </button>
              </div>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="table-unit" width="100%">
                <thead class=" thead-light">
                  <tr>
                    <th><input type="checkbox" id="checkAllUnit"></th>
                    <th></th>
                    <th>Nama unit</th>
                    <th>Singkatan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </form>
        </div>
        <div class="row m-2 btn-datarestoreunit" style="display:none;">
          <h6>
            <a href="<?= $nav ?>">&laquo; Kembali ke data unit</a>
          </h6>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card shadow mb-3 datalist-anggota">
        <div class="card-header shadow-sm">
          <div class="row justify-content-between align-items-center">
            <div class="col-lg-7">
              <h4 class="card-title">Data Anggota</h4>
            </div>
            <div class="col-lg-5 d-flex flex-row justify-content-end">
              <div class="col-lg-auto btn-dataanggota">
                <button type="button" class="btn btn-success" id="btn-tambahanggota" onClick="util.getForm('add','','<?= $nav . '/tampilformanggota' ?>')">
                  <i class="bi bi-people"></i>
                  Tambah Anggota
                </button>
                <button type="button" class="btn btn-primary" id="btn-restoreanggota" onClick="anggota.viewTableRestore()">
                  <i class="fa fa-recycle"></i> Recycle Bin
                </button>
              </div>
              <div class="col-lg-auto btn-datarestoreanggota" style="display:none;">
                <button class="btn btn-success" onclick="anggota.restoreAll()"><i class="fa fa-undo"></i> Pulihkan semua</button>
                <button class="btn btn-danger" onclick="anggota.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body table-restoreanggota" style="display:none;">
          <div class="table-responsive py-4">
            <table class="table table-flush text-white table-dark" id="table-restoreanggota" width="100%">
              <thead class=" thead-light">
                <tr>
                  <th></th>
                  <th>Nama Anggota</th>
                  <th>No Anggota</th>
                  <th>Nama Unit</th>
                  <th>Deleted at</th>
                  <th>Deleted by</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-body table-anggota">
          <form id="formDeleteAnggota" onSubmit="anggota.multipleDelete(this, event)">
            <div class="row m-1">
              <div class="col-md-12 pb-0 pt-3 px-0 d-flex justify-content-end">
                <button type="submit" class="btn btn-danger btn-DeleteAnggota">
                  <i class="fa fa-trash-o"></i> Multiple Delete
                </button>
              </div>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush text-white table-dark" id="table-anggota" width="100%">
                <thead class=" thead-light">
                  <tr>
                    <th><input type="checkbox" id="checkAllAnggota"></th>
                    <th></th>
                    <th>Nama Anggota</th>
                    <th>No Anggota</th>
                    <th>Nama Unit</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </form>
        </div>
        <div class="row m-2 btn-datarestoreanggota" style="display:none;">
          <h6>
            <a href="<?= $nav ?>">&laquo; Kembali ke data anggota</a>
          </h6>
        </div>
      </div>
    </div>
  </div>


</section>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let tableAnggota, tableUnit;
  $(document).ready(function() {
    tableUnit = unit.listData("table-unit", `${nav}/listdataunit?isRestore=0`);
    unit.viewdtcontrol('table-unit', tableUnit);
    tableAnggota = anggota.listData("table-anggota", `${nav}/listdataanggota?isRestore=0`);
    anggota.viewdtcontrol('table-anggota', tableAnggota);
    util.handleCheckAll('#checkAllUnit', `.checkRowUnit`);
    util.handleCheckAll('#checkAllAnggota', `.checkRowAnggota`);
  });

  function format(d) {
    var formattedDate = renderFormatTime(d.created_at);

    let addunit = `<table class="table" style="padding:20px;">
    <tr>
          <th>${d.kategori_unit}</th>
          <td class="align-top">:</td>
            <td class="align-top">${(d.singkatan)? `
                ${d.singkatan}
              `:`-`}
              </td>
          </tr>
          <th>Deskripsi</th>
          <td class="align-top">:</td>
            <td class="align-top">${(d.deskripsi)? `
                ${d.deskripsi}
              `:`-`}
              </td>
          </tr>
          </tr>
          <tr>
          <th>Keterangan</th>
          <td class="align-top">:</td>
            <td class="align-top">dibuat tanggal ${formattedDate} oleh ${d.created_by}
              </td>
          </tr>
      </table>`;

    let addanggota = `<table class="table" style="padding:20px;">
            <tr>
            <th>Nomor Handphone</th>
              <td>:</td>
              <td>${(d.no_hp)? `
                  ${d.no_hp}
                `:`-`}
                </td>
            </tr>
            <tr>
              <th>Level</th>
              <td>:</td>
              <td>${d.level}</td>
          </tr>
          <tr>
          <th>Keterangan</th>
            <td class="align-top">:</td>
              <td class="align-top">dibuat tanggal ${formattedDate} oleh ${d.created_by}
                </td>
            </tr>
        </table>`;
    return (`${(d.deskripsi)? `
        ${addunit}`:`${addanggota}`}`);
  }
</script>
<?= $this->endSection() ?>