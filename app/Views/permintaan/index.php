<?= $this->extend('/layouts/template') ?>
<?= $this->section('styles') ?>
<style>
  img {
    display: block;
    max-width: 100%;
  }

  .preview {
    overflow: hidden;
    width: 160px;
    height: 160px;
    margin: 10px;
    border: 1px solid red;
  }

  .modal-lg {
    max-width: 1000px !important;
  }

  .img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
    /* sesuaikan dengan tinggi gambar yang ingin di crop */
    overflow: hidden;
  }

  .img-container img {
    display: block;
    max-width: 100%;
    max-height: 100%;
    margin: auto;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar <?= $title; ?></h3>
        <p class="text-subtitle text-muted">Kelola menu <?= strtolower($title) ?> di Universitas Islam Raden Rahmat Malang</p>
      </div>
      <div class="col-12 col-md-4 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <?php foreach ($breadcrumb as $crumb) : ?>
              <?php if (end($breadcrumb) == $crumb) : ?>
                <div class="breadcrumb-item"><?= $crumb['name'] ?></div>
              <?php else : ?>
                <div class="breadcrumb-item active"><a href="#"><?= $crumb['name'] ?></a></div>
              <?php endif ?>
            <?php endforeach ?>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<section class="section">
  <div class="viewform" style="display:none;"></div>
  <div class="card shadow mb-3 datalist-minta">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-md-auto btn-dataminta">
            <button type="button" class="btn btn-primary" id="btn-restore"><i class="fa fa-recycle"></i> Recycle Bin</button>
          </div>
          <div class="col-lg-auto btn-datarestoreminta" style="display:none;">
            <button class="btn btn-success" onclick="restoreall()"><i class="fa fa-undo"></i> Pulihkan semua</button>
            <button class="btn btn-danger" onclick="hapuspermanenall()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body table-restore" style="display:none;">
      <div class="table-responsive py-4">
        <table class="table table-flush" id="table-restore" width="100%">
          <thead class=" thead-light">
            <tr>
              <th>No.</th>
              <th>Nama Peminta</th>
              <th>Asal</th>
              <th>Nama Barang</th>
              <th>Jumlah Barang</th>
              <th>Satuan</th>
              <th>Deleted By</th>
              <th>Deleted At </th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-body table-minta">
      <form class="formmultipledelete">
        <div class="row m-1">
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
            <div class="btn-group">
              <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                Input Peminta
              </button>
              <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" onclick="singleform()"><i class="fa fa-plus-square-o"></i> Tambah Peminta
                  </a>
                </li>
                <li><a class="dropdown-item" onclick="multipleinsert()"><i class="fa fa-file-text"></i> Input Multiple</a>
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
                <th>No.</th>
                <th>Nama Peminta</th>
                <th>Asal</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Satuan</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </form>
    </div>
    <div class="row m-2 btn-datarestoreminta" style="display:none;">
      <a href="<?= $nav; ?>">&laquo; Kembali ke data <?= strtolower($title); ?></a>
    </div>
  </div>

  <div class="viewmodal" style="display:none;"></div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  let jenistrx = "Permintaan <?= $jenis_kat ?>";
  let jenis_kat = "<?= $jenis_kat ?>";
  let dataminta = "";
  let datarestore = "";

  $(document).ready(function() {
    dataminta = $('#table-minta').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= $nav ?>/listdatapermintaan?jenis_kat=${jenis_kat}&isRestore=0`,
        dataSrc: function(json) {
          json.data.forEach(function(item) {
            item.id = item.id;
          });
          return json.data;
        }
      },
      order: [],
      columns: [{
          data: 'checkrow',
          orderable: false
        },
        {
          data: 'no',
          orderable: false
        },
        {
          data: 'nama_anggota'
        },
        {
          data: 'singkatan'
        },
        {
          data: 'nama_brg',
        },
        {
          data: 'jml_barang'
        },
        {
          data: 'kd_satuan'
        },
        {
          data: 'created_by'
        },
        {
          data: 'created_at',
          render: function(data, type, full, meta) {
            var dateParts = data.split(/[- :]/);
            var year = parseInt(dateParts[0]);
            var month = parseInt(dateParts[1]) - 1;
            var day = parseInt(dateParts[2]);
            var hours = parseInt(dateParts[3]);
            var minutes = parseInt(dateParts[4]);
            var seconds = parseInt(dateParts[5]);
            var options = {
              weekday: 'long',
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            };
            var formattedDate = new Date(year, month, day, hours, minutes, seconds).toLocaleDateString('id-ID', options);
            return formattedDate;
          }
        },
        {
          data: 'action',
          orderable: false
        },
      ]
    });

  });

  function singleform() {
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/permintaancontroller/tampilsingleform",
      data: {
        saveMethod: "add",
        nav: "<?= $nav ?>",
        jenis_kat: "<?= $jenis_kat ?>",
      },
      dataType: "json",
      success: function(response) {
        $('.viewform').show().html(response.data);
      }
    });
  }
</script>
<?= $this->endSection() ?>