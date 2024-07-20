<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
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
    getCountBarang('getcountbrg', brgtetap, '#brgttp', 'kelola-barang#brgtetap');
    getCountBarang('getcountbrg', brgpersediaan, '#brgsedia', 'kelola-barang#brgpersediaan');
    getCountProp('getcountgedung', '#gedung', 'gedung');
    getCountProp('getcountruang', '#ruang', 'ruang');
    getCountBrgKeluar('Peminjaman', '#peminjaman', 'peminjaman-barang');
    getCountBrgKeluar('Permintaan', '#permintaan', 'permintaan-barang-persediaan');
  });

  function getCountBrgKeluar(jenistrx, targetId, hrefLink) {
    $.ajax({
      type: "get",
      url: `dashboard/getcountbrgkeluar`,
      data: {
        jenistrx,
      },
      dataType: "json",
      success: function(response) {
        if (response.jenistrx == "Peminjaman") {
          $(targetId).find('h6').after(`
          <h6 class="count font-extrabold">${response.data.pengguna}</h6>
          <h6 class="text-muted font-semibold">Barang dipinjam</h6>
          <h6 class="count2 font-extrabold">${response.data.total_brg? `${response.data.total_brg}`:`0`}</h6>
        `);
        } else if (response.jenistrx == "Permintaan") {
          $(targetId).find('h6').after(`
          <h6 class="count font-extrabold">${response.data.pengguna}</h6>
          <h6 class="text-muted font-semibold">Barang yang diminta</h6>
          <h6 class="count2 font-extrabold">${response.data.total_brg}</h6>
        `);
        }

        counterNumber(`${targetId} .count`, response.data.pengguna, response.data.pengguna);
        counterNumber(`${targetId} .count2`, response.data.total_brg, response.data.total_brg);

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
        <h6 class="count font-extrabold">${response.result}</h6>
      `);
        counterNumber(`${targetId} .count`, response.result, response.result);
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
        jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        let totalval = Number(response.total_valuasi);
        let valuasiFormatted = 'Rp ' + totalval.toLocaleString('id-ID') + ',-';

        $(targetId).find('h6').after(`
        <h6 class="count font-extrabold">${response.result}</h6>
        <h6 class="text-muted font-semibold">Total Valuasi</h6>
        <h6 class="count2 font-extrabold"></h6>
      `);

        counterNumber(`${targetId} .count`, response.result, response.result);
        counterNumber(`${targetId} .count2`, totalval, valuasiFormatted);

        $(targetId).after(`
        <div class="col-md-12 mt-0">
          <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
        </div>
      `);
      }
    });
  }


  function counterNumber(targetId, angka, fixvalue) {
    $(targetId)
      .prop('Counter', 0)
      .animate({
        Counter: angka,
      }, {
        duration: 3000,
        easing: 'swing',
        step: function(now) {
          $(this).text(Math.ceil(now));
        },
        complete: function() {
          $(this).text(fixvalue); // Menggantikan teks dengan valuasiFormatted setelah selesai melakukan counter
        },
      });
  }
</script>
<?= $this->endSection() ?>