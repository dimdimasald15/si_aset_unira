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
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3><?= $title ?> Inventaris Barang</h3>
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
  <div class="card mb-3 shadow">
    <div class="card-header shadow-sm">
      <h4 class="card-title">Custom Filters</h4>
    </div>
    <div class=" card-body">
      <form action="<?= $nav ?>/cetak" method="post" id="cetak-laporan">
        <?= csrf_field() ?>
        <div class="row mt-3">
          <input type="text" name="keterangan" id="keterangan" value="Semua Laporan" hidden>
          <div class="col-sm-4 d-flex justify-content-start">
            <label class="col-sm-3 col-form-label" for="inputGroupSelect01">Bulan</label>
            <div class="col-sm-9">
              <select id="selectbulan" name="bulan" class="form-select"></select>
            </div>
          </div>
          <div class="col-sm-4 d-flex justify-content-start">
            <label class="col-sm-3 col-form-label" for="inputGroupSelect01">Tahun</label>
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
    <div class="row mb-0">
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow">
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
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow">
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
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow">
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
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card shadow">
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
    </div>
  </div>

  <div class="card mb-3 shadow datalist-barang">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-md-7">
          <h4 class="card-title">Analisa Alokasi Barang Tetap</h4>
        </div>
      </div>
    </div>
    <div class="card-body table-lokasibrg">
      <div class="table-responsive py-4">
        <table class="table table-light cell-border mb-3" id="table-lokasibrg" width="100%">
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
      <div class="card mb-3 shadow">
        <div class="card-header shadow-sm">
          <div class="col-md-12">
            <h6 class="surtitle">Analisa Permintaan Barang</h6>
            <h4 class="card-title">Chart Permintaan Barang Berdasarkan Unit</h4>
          </div>
        </div>
        <div class="card-body">
          <canvas id="chart-permintaan"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-3 shadow">
        <div class="card-header shadow-sm">
          <div class="col-md-12">
            <h6 class="surtitle">Analisa Permintaan Barang</h6>
            <h4 class="card-title">Table Permintaan Barang</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive py-4">
            <table class="table table-light cell-border mb-3" id="table-permintaan" width="100%">
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

  let tlokasi = '';
  let tpermintaan = '';
  var namaBulan = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];
  var myline = '';

  $(document).ready(function() {
    set_tahun();
    set_bulan();
    // Ambil nilai dari #brgttp dan #brgsedia
    const brgtetap = $('#brgttp h6').html();
    const brgpersediaan = $('#brgsedia h6').html();
    let bulan = $('#selectbulan').val();
    let tahun = $('#selecttahun').val();
    const datalokbrg = $('#table-lokasibrg');

    getLaporanDefault(brgtetap, brgpersediaan);
    tlokasi = datalokbrg.DataTable({
      ajax: `<?= base_url() ?>/laporancontroller/getdatalokasibrg`,
      columns: [{
          className: 'dt-control',
          orderable: false,
          sortable: false,
          data: null,
          defaultContent: '',
        },
        {
          data: 'nama_ruang'
        },
        {
          data: 'count_brg',
          render: function(data) {
            return data + ' brg';
          }
        },
      ],
      order: [
        [1, 'asc']
      ],
      columnDefs: [{
        targets: [2],
        className: 'dt-body-center'
      }]
    });

    tpermintaan = $('#table-permintaan').DataTable({
      ajax: `<?= base_url() ?>/laporancontroller/getdatapermintaan`,
      columns: [{
          className: 'dt-control',
          orderable: false,
          sortable: false,
          data: null,
          defaultContent: '',
        },
        {
          data: 'nama_unit'
        },
        {
          data: 'count_brg',
          render: function(data) {
            return data + ' brg';
          }
        },
        {
          data: 'bulan_tahun',
          render: function(data) {
            let text = data;
            let periode = text.split('/');
            const [m, y] = periode;
            var month = '';
            for (let i = 0; i < namaBulan.length; i++) {
              if (i + 1 == m) {
                month = namaBulan[i];
                break;
              }
            }

            return month + ' ' + y;
          }
        },
      ],
      order: [
        [1, 'asc']
      ],
      columnDefs: [{
        targets: [2, 3],
        className: 'dt-body-center'
      }]
    });

    // Add event listener for opening and closing details
    $('#table-permintaan tbody').on('click', 'td.dt-control', function() {
      var tr = $(this).closest('tr');
      var row = tpermintaan.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      } else {
        // Open this row
        row.child(format(row.data())).show();
        tr.addClass('shown');
      }
    });
    // Add event listener for opening and closing details
    $('#table-lokasibrg tbody').on('click', 'td.dt-control', function() {
      var tr = $(this).closest('tr');
      var row = tlokasi.row(tr);

      if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
      } else {
        // Open this row
        row.child(format(row.data())).show();
        tr.addClass('shown');
      }
    });

    refresh_all_chart(bulan, tahun)

    $(document).on('change', '#selectbulan, #selecttahun', function(e) {
      e.preventDefault();
      let bulan = $('#selectbulan').val();
      let tahun = $('#selecttahun').val();
      if (bulan == '' && tahun !== '') {
        set_empty();
        tlokasi.ajax.reload();

        getCountBarang('getcountbrg', brgtetap, '#brgttp', 'barang-tetap-masuk', bulan, tahun);
        getCountBarang('getcountbrg', brgpersediaan, '#brgsedia', 'barang-persediaan-masuk', bulan, tahun);
        getCountBrgKeluar('Peminjaman', '#peminjaman', 'peminjaman-barang-tetap', bulan, tahun);
        getCountBrgKeluar('Permintaan', '#permintaan', 'permintaan-barang-persediaan', bulan, tahun);
        refresh_all_chart(bulan, tahun)

      } else if (bulan !== '' && tahun !== '') {
        set_empty();
        tlokasi.ajax.reload();

        getCountBarang('getcountbrg', brgtetap, '#brgttp', 'barang-tetap-masuk', bulan, tahun);
        getCountBarang('getcountbrg', brgpersediaan, '#brgsedia', 'barang-persediaan-masuk', bulan, tahun);
        getCountBrgKeluar('Peminjaman', '#peminjaman', 'peminjaman-barang-tetap', bulan, tahun);
        getCountBrgKeluar('Permintaan', '#permintaan', 'permintaan-barang-persediaan', bulan, tahun);
        refresh_all_chart(bulan, tahun)

      } else if (bulan == '' && tahun == '') {
        refresh_all_chart(bulan, tahun)
        getLaporanDefault(brgtetap, brgpersediaan);
        tlokasi.ajax.reload();
      }
    })

    // $('#cetak-laporan').submit(function(e) {
    //   e.preventDefault();
    //   var formData = new FormData(this);

    //   $.ajax({
    //     type: 'post',
    //     url: '<?= $nav ?>/cetak',
    //     data: formData,
    //     processData: false,
    //     contentType: false,
    //     beforeSend: function() {
    //       $('.btncetak').attr('disable', 'disabled');
    //       $('.btncetak').html('<i class="fa fa-spin fa-spinner"></i>');
    //     },
    //     complete: function() {
    //       $('.btncetak').removeAttr('disable');
    //       $('.btncetak').html('<i class="fa fa-file-pdf-o"></i> Cetak Laporan');
    //     },
    //     success: function(result) {
    //       var response = JSON.parse(result);
    //       console.log(response);
    //     },
    //     error: function(xhr, ajaxOptions, thrownError) {
    //       alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
    //     }
    //   });
    //   return false;
    // })
  });

  function refresh_all_chart(m, y) {
    permintaan_chart(m, y);
  }

  function permintaan_chart(m, y) {
    $.ajax({
      type: "get",
      url: `<?= base_url() ?>/laporancontroller/get_data_permintaan?m=${m}&y=${y}`,
      dataType: "json",
      success: function(response) {
        var labels = [];
        var datasets = [];
        var line = document.getElementById("chart-permintaan").getContext("2d");
        if (response.data.length > 0) {
          // Mengambil label bulan dari data query
          var queryData = response.data;
          var bulanTahun = queryData.map(item => item.bulan_tahun);
          var bulan = bulanTahun.map(item => {
            var [bulanIndex, tahun] = item.split('/');
            var month = namaBulan[parseInt(bulanIndex) - 1];
            if (!labels.includes(month)) {
              labels.push(month);
            }
          });
          var baseColor = generateColors(queryData);
          var colors = [];
          for (var i = 0; i < queryData.length; i++) {
            var bgColor = baseColor[i].replace(')', ', 0.6)').replace('rgb', 'rgba');
            var bdColor = baseColor[i].replace(')', ', 1)').replace('rgb', 'rgba');

            colors.push({
              bgColor: bgColor,
              bdColor: bdColor,
            });
          }
          // Mengambil data nama_unit dan total_valuasi dari data query
          datasets = queryData.map((item, index) => {
            return {
              label: item.nama_unit,
              data: [parseInt(item.total_valuasi)],
              backgroundColor: colors[index].bgColor,
              borderWidth: 3,
              borderColor: colors[index].bdColor,
              pointBorderWidth: 0,
              pointBorderColor: colors[index].bdColor,
              pointRadius: 3,
              pointBackgroundColor: colors[index].bdColor,
              pointHoverBackgroundColor: colors[index].bdColor
            };
          });
        } else if (response.data.length === 0) {
          labels = namaBulan;
          datasets = [];
        }

        myline = new Chart(line, {
          type: 'line',
          data: {
            labels: labels,
            datasets: datasets
          },
          options: {
            responsive: true,
            layout: {
              padding: {
                top: 10,
              },
            },
            tooltips: {
              intersect: false,
              titleFontFamily: 'Helvetica',
              titleMarginBottom: 10,
              xPadding: 10,
              yPadding: 10,
              cornerRadius: 3,
            },
            legend: {
              display: true,
              position: 'bottom',
              labels: {
                generateLabels: (chart) => {
                  const datasets = chart.data.datasets;
                  return datasets.map((data, i) => ({
                    text: `${data.label} (${data.data[0]})`,
                    fillStyle: data.backgroundColor,
                  }))
                },
              }
            },
            scales: {
              y: {
                beginAtZero: true
              },
              yAxes: [{
                gridLines: {
                  display: true,
                  drawBorder: true,
                },
                ticks: {
                  display: true,
                },
              }, ],
              xAxes: [{
                gridLines: {
                  drawBorder: true,
                  display: true,
                },
                ticks: {
                  display: true,
                },
              }, ],
            },
          }
        });
      }
    });
  }

  function generateColors(query) {
    var baseColor = [];

    for (var i = 0; i < query.length; i++) {
      var r = Math.floor(Math.random() * 256);
      var g = Math.floor(Math.random() * 256);
      var b = Math.floor(Math.random() * 256);

      var color = `rgb(${r}, ${g}, ${b})`;
      baseColor.push(color);
    }
    return baseColor;
  }
  /* Formatting function for row details - modify as you need */
  function format(d) {
    // `d` is the original data object for the row
    const number = d.total_valuasi;
    const total_val = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    }).format(number);

    let text = d.nama_brg;
    let nama_brg = text.split(', ');
    let lastItem = nama_brg.pop();
    if (nama_brg.length > 0) {
      nama_brg = nama_brg.join(', ') + ', dan ' + lastItem;
    } else {
      nama_brg = lastItem;
    }

    let nama_anggota = '';
    if (d.hasOwnProperty('nama_anggota')) {
      let nm = d.nama_anggota;
      let nama_anggota_arr = nm.split(',');
      let lastItem2 = nama_anggota_arr.pop();
      if (nama_anggota_arr.length > 0) {
        nama_anggota = nama_anggota_arr.join(', ') + ', dan ' + lastItem2;
      } else {
        nama_anggota = lastItem2;
      }
    }

    return (
      `<table class="table table-light cell-border" cellpadding="5" cellspacing="0" border="0" style="padding:20px;">
        ${(nama_anggota !== '')? `
          <tr>
            <th>Nama Anggota</th>
              <td>${nama_anggota}</td>
          </tr>
        `:``}
        <tr>
          <th>Nama Barang</th>
            <td>${nama_brg}</td>
        </tr>
        <tr>
          <th>Total valuasi</th>
            <td>${total_val}</td>
        </tr>
      </table>`
    );
  }

  function set_empty() {
    $(".getpeminjaman").empty();
    $(".getpermintaan").empty();
    $(".getbarang").empty();
    if (myline) {
      myline.destroy();
    }
  }

  function getLaporanDefault(brgtetap, brgpersediaan) {
    getCountBarang('getcountbrg', brgtetap, '#brgttp', 'barang-tetap-masuk');
    getCountBarang('getcountbrg', brgpersediaan, '#brgsedia', 'barang-persediaan-masuk');
    getCountBrgKeluar('Peminjaman', '#peminjaman', 'peminjaman-barang-tetap');
    getCountBrgKeluar('Permintaan', '#permintaan', 'permintaan-barang-persediaan');
  }

  function getCountBrgKeluar(jenistrx, targetId, hrefLink, bulan, tahun) {
    $.ajax({
      type: "get",
      url: `<?= base_url() ?>/laporancontroller/getcountbrgkeluar`,
      data: {
        jenistrx: jenistrx,
        m: bulan,
        y: tahun,
      },
      dataType: "json",
      success: function(response) {
        $(targetId).find('h6').nextAll().empty();
        if (response.jenistrx == "Peminjaman") {
          $(targetId).find('h6').after(`
          <div class="getpeminjaman">
          <h6 class="font-extrabold">${response.data.pengguna}</h6>
          <h6 class="text-muted font-semibold">Barang dipinjam</h6>
          <h6 class="font-extrabold">${response.data.total_brg}</h6>
          </div>
        `);
        } else if (response.jenistrx == "Permintaan") {
          $(targetId).find('h6').after(`
          <div class="getpermintaan">
          <h6 class="font-extrabold">${response.data.pengguna}</h6>
          <h6 class="text-muted font-semibold">Barang yang diminta</h6>
          <h6 class="font-extrabold">${response.data.total_brg}</h6>
          </div>
        `);
        }
      }
    });
  }

  function getCountBarang(method, jenis_kat, targetId, hrefLink, bulan, tahun) {
    $.ajax({
      url: `<?= base_url() ?>/laporancontroller/${method}`,
      data: {
        jenis_kat: jenis_kat,
        m: bulan,
        y: tahun,
      },
      dataType: "json",
      success: function(response) {
        let totalval = Number(response.total_valuasi);
        let valuasiFormatted = 'Rp ' + totalval.toLocaleString('id-ID') + ',-';
        $(targetId).find('h6').nextAll().empty();
        $(targetId).find('h6').after(`
        <div class="getbarang">
        <h6 class="font-extrabold">${response.result}</h6>
        <h6 class="text-muted font-semibold">Total Valuasi</h6>
        <h6 class="font-extrabold">${valuasiFormatted}</h6>
        </div>
      `);
      }
    });
  }

  function set_tahun() {
    var skrg = new Date(Date.now());
    var end = skrg.getFullYear()
    var html = `<option value="">Semua Tahun</option>`
    for (let i = end; i >= 1990; i--) {
      html += `<option value="${i}">${i}</option>`
    }

    $("#selecttahun").html(html)
  }

  function set_bulan() {
    var html = `<option value="">Semua Bulan</option>`;

    for (let i = 0; i < namaBulan.length; i++) {
      html += `<option value="${i + 1}">${namaBulan[i]}</option>`;
    }

    $("#selectbulan").html(html);
  }

  function filterSerialize() {
    // console.log(`m=${$('#selectbulan').val()}&y=${$('#selecttahun').val()}`);
    return `m=${$('#selectbulan').val()}&y=${$('#selecttahun').val()}`;
  }
</script>
<?= $this->endSection() ?>