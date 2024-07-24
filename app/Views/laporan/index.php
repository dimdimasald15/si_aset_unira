<?= $this->extend('/layouts/template') ?>

<?= $this->section('styles') ?>
<style>
  .stats-icon {
    width: 3.2rem;
    height: 3.2rem;
    border-radius: 0.5rem;
    background-color: #000;
    float: right;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .stats-icon i {
    color: #fff;
    font-size: 2.0rem;
  }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="section">
  <div class="card mb-3 bg-dark text-white shadow">
    <div class="card-header bg-dark text-white shadow-sm">
      <h4 class="card-title">Custom Filters</h4>
    </div>
    <div class="card-body bg-dark text-white">
      <form action="<?= $nav ?>/cetak" method="post" id="cetak-laporan">
        <?= csrf_field() ?>
        <div class="row mt-3">
          <input type="text" name="keterangan" id="keterangan" value="Semua Laporan" hidden>
          <div class="col-sm-4 d-flex justify-content-start">
            <label class="col-sm-3 col-form-label" for="selectbulan">Bulan</label>
            <div class="col-sm-9">
              <select id="selectbulan" name="bulan" class="form-select"></select>
            </div>
          </div>
          <div class="col-sm-4 d-flex justify-content-start">
            <label class="col-sm-3 col-form-label" for="selecttahun">Tahun</label>
            <div class="col-sm-9">
              <select id="selecttahun" name="tahun" class="form-select"></select>
            </div>
          </div>
          <div class="col-sm-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btncetak"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="row">
      <?php foreach ($cards as $card) : ?>
        <div class="col-6 col-lg-3 col-md-6">
          <div class="card shadow text-white bg-dark">
            <div class="card-body px-3 py-3">
              <div class="row" id="<?= $card['id'] ?>">
                <div class="col-md-4">
                  <div class="stats-icon <?= $card['color'] ?>">
                    <i class="fa <?= $card['icon'] ?>"></i>
                  </div>
                </div>
                <div class="col-md-8">
                  <h6 class="text-muted font-semibold"><?= $card['title'] ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="card mb-3 bg-dark text-white shadow datalist-barang">
    <div class="card-header bg-dark text-white shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-md-7">
          <h4 class="card-title">Analisa Alokasi Barang Tetap</h4>
        </div>
      </div>
    </div>
    <div class="card-body bg-dark text-white table-lokasibrg">
      <div class="table-responsive py-4">
        <table class="table table-flush cell-border mb-3" id="table-lokasibrg" width="100%">
          <thead class="thead-dark">
            <tr>
              <th class="text-center">Detail</th>
              <th class="text-center">Ruang</th>
              <th class="text-center">Jumlah Barang</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="card mb-3 bg-dark text-white shadow">
        <div class="card-header bg-dark text-white shadow-sm">
          <div class="col-md-12">
            <h6 class="surtitle">Analisa Permintaan Barang</h6>
            <h4 class="card-title">Chart Permintaan Barang Berdasarkan Unit</h4>
          </div>
        </div>
        <div class="card-body bg-dark text-white mt-5">
          <canvas id="chart-permintaan"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-3 bg-dark text-white shadow">
        <div class="card-header bg-dark text-white shadow-sm">
          <div class="col-md-12">
            <h6 class="surtitle">Analisa Permintaan Barang</h6>
            <h4 class="card-title">Table Permintaan Barang</h4>
          </div>
        </div>
        <div class="card-body bg-dark text-white">
          <div class="table-responsive py-4">
            <table class="table table-flush cell-border mb-3" id="table-permintaan" width="100%">
              <thead class="thead-dark">
                <tr>
                  <th class="text-center">Detail</th>
                  <th class="text-center">Unit Peminta</th>
                  <th class="text-center">Jumlah Barang</th>
                  <th class="text-center">Periode</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  const arrayColumn = (arr, n) => arr.map(x => x[n]);
  var namaBulan = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];
  var myline = '';

  $(document).ready(function() {
    // Get initial values of month and year
    let bulan = $('#selectbulan').val();
    let tahun = $('#selecttahun').val();
    let cards = <?= json_encode($cards) ?>;
    initializeMonthAndYears()
    // Initialize dashboard cards and data tables
    aset.initializeDashboard(cards, bulan, tahun);
    aset.setupChangeListener(cards);
    aset.refreshAllChart(bulan, tahun)
  });
</script>
<?= $this->endSection() ?>