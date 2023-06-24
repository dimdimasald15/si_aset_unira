<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3><?= $title ?></h3>
        <p class="text-subtitle text-muted">Sistem Informasi Manajemen Aset Universitas Islam Raden Rahmat Malang</p>
      </div>
      <div class="col-12 col-md-4 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item"><a href="dashboard"><i class="fa fa-home"></i></a></li>
            <?php foreach ($breadcrumb as $crumb) : ?>
              <?php if (end($breadcrumb) == $crumb) : ?>
                <li class="breadcrumb-item"><?= $crumb['name'] ?></li>
              <?php else : ?>
                <li class="breadcrumb-item active" aria-current="page"><a href="#"><?= $crumb['name'] ?></a></li>
              <?php endif ?>
            <?php endforeach ?>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
<section class="section">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-6 col-lg-4 col-md-6">
        <div class="card shadow text-white bg-dark">
          <div class="card-body px-3 py-3">
            <div class="row" id="brgttp">
              <div class="col-md-4">
                <div class="stats-icon purple">
                  <i class="fa fa-cubes"></i>
                </div>
              </div>
              <div class="col-md-8">
                <h6 class="text-muted font-semibold">Barang Tetap</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
        <div class="card shadow text-white bg-dark">
          <div class="card-body px-3 py-3">
            <div class="row" id="brgsedia">
              <div class="col-md-4">
                <div class="stats-icon blue">
                  <i class="fa fa-shopping-basket"></i>
                </div>
              </div>
              <div class="col-md-8">
                <h6 class="text-muted font-semibold">Barang Persediaan</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
        <div class="card shadow text-white bg-dark">
          <div class="card-body px-3 py-3">
            <div class="row" id="gedung">
              <div class="col-md-4">
                <div class="stats-icon red">
                  <i class="fa fa-building-o"></i>
                </div>
              </div>
              <div class="col-md-8">
                <h6 class="text-muted font-semibold">Gedung</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
        <div class="card shadow text-white bg-dark">
          <div class="card-body px-3 py-3">
            <div class="row" id="peminjaman">
              <div class="col-md-4">
                <div class="stats-icon pink">
                  <i class="fa fa-handshake-o"></i>
                </div>
              </div>
              <div class="col-md-8">
                <h6 class="text-muted font-semibold">Total Peminjam</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
        <div class="card shadow text-white bg-dark">
          <div class="card-body px-3 py-3">
            <div class="row" id="permintaan">
              <div class="col-md-4">
                <div class="stats-icon orange">
                  <i class="fa fa-file-text-o"></i>
                </div>
              </div>
              <div class="col-md-8">
                <h6 class="text-muted font-semibold">Total Peminta</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
        <div class="card shadow text-white bg-dark">
          <div class="card-body px-3 py-3">
            <div class="row" id="ruang">
              <div class="col-md-4">
                <div class="stats-icon green">
                  <i class="fa fa-map-marker"></i>
                </div>
              </div>
              <div class="col-md-8">
                <h6 class="text-muted font-semibold">Ruang</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    // Ambil nilai dari #brgttp dan #brgsedia
    const brgtetap = $('#brgttp h6').html();
    const brgpersediaan = $('#brgsedia h6').html();

    // Panggil fungsi getCountBarang untuk masing-masing jenis barang
    getCountBarang('getcountbrg', brgtetap, '#brgttp', 'barang-tetap-masuk');
    getCountBarang('getcountbrg', brgpersediaan, '#brgsedia', 'barang-persediaan-masuk');
    getCountProp('getcountgedung', '#gedung', 'gedung');
    getCountProp('getcountruang', '#ruang', 'ruang');
    getCountBrgKeluar('Peminjaman', '#peminjaman', 'peminjaman-barang-tetap');
    getCountBrgKeluar('Permintaan', '#permintaan', 'permintaan-barang-persediaan');
  });

  function getCountBrgKeluar(jenistrx, targetId, hrefLink) {
    $.ajax({
      type: "get",
      url: `dashboard/getcountbrgkeluar`,
      data: {
        jenistrx: jenistrx,
      },
      dataType: "json",
      success: function(response) {
        if (response.jenistrx == "Peminjaman") {
          $(targetId).find('h6').after(`
          <h6 class="font-extrabold">${response.data.pengguna}</h6>
          <h6 class="text-muted font-semibold">Barang dipinjam</h6>
          <h6 class="font-extrabold">${response.data.total_brg}</h6>
        `);
        } else if (response.jenistrx == "Permintaan") {
          $(targetId).find('h6').after(`
          <h6 class="font-extrabold">${response.data.pengguna}</h6>
          <h6 class="text-muted font-semibold">Barang yang diminta</h6>
          <h6 class="font-extrabold">${response.data.total_brg}</h6>
        `);
        }

        $(targetId).after(`
        <div class="col-md-12 mt-0">
          <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
        </div>
      `);
      }
    });
  }

  function getCountProp(method, targetId, hrefLink) {
    $.ajax({
      type: "get",
      url: `dashboard/${method}`,
      dataType: "json",
      success: function(response) {
        $(targetId).find('h6').after(`
        <h6 class="font-extrabold">${response.result}</h6>
      `);

        $(targetId).after(`
        <div class="col-md-12 mt-5">
          <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
        </div>
      `);
      }
    });
  }

  function getCountBarang(method, jenis_kat, targetId, hrefLink) {
    $.ajax({
      url: `dashboard/${method}`,
      data: {
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        let totalval = Number(response.total_valuasi);
        let valuasiFormatted = 'Rp ' + totalval.toLocaleString('id-ID') + ',-';

        $(targetId).find('h6').after(`
        <h6 class="font-extrabold">${response.result}</h6>
        <h6 class="text-muted font-semibold">Total Valuasi</h6>
        <h6 class="font-extrabold">${valuasiFormatted}</h6>
      `);

        $(targetId).after(`
        <div class="col-md-12 mt-0">
          <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
        </div>
      `);
      }
    });
  }
</script>
<?= $this->endSection() ?>