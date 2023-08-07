<?= $this->extend('/layouts/template'); ?>
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
  <div class="col-12 col-md-12 viewtambahmultiple" style="display:none;"></div>
  <div class="col-12 col-md-12 viewdata" style="display:none;"></div>
  <div class="card shadow mb-3 text-white bg-dark shadow">
    <div class="card-header text-white bg-dark shadow-sm">
      <h4 class="card-title">Custom Filter</h4>
    </div>
    <div class=" card-body">
      <div class="row mt-3">
        <div class="col-sm-6 d-flex justify-content-start">
          <label class="col-sm-4 col-form-label" for="selectbarang">Barang</label>
          <div class="col-sm-8">
            <select id="selectbarang" class="form-select"></select>
          </div>
        </div>
        <div class="col-sm-6 d-flex justify-content-start">
          <label class="col-sm-4 col-form-label" for="selectkategori">Kategori</label>
          <div class="col-sm-8">
            <select id="selectkategori" class="form-select"></select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-3 text-white bg-dark shadow datalist-barang">
    <div class="card-header text-white bg-dark shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-md-7">
          <h4 class="card-title">Data Barang</h4>
        </div>
        <div class="col-md-5 d-flex flex-row justify-content-end">
          <div class="col-md-auto d-flex flex-row justify-content-end">
            <div class="col-md-auto btn-databarang">
              <button type="button" class="btn btn-primary" id="btn-restore"><i class="fa fa-recycle"></i> Recycle Bin</button>
            </div>
          </div>
          <div class="col-md-auto btn-datarestorebarang" style="display:none;">
            <button class="btn btn-success" onclick="restoreall()"><i class="fa fa-undo"></i> Pulihkan semua</button>
            <button class="btn btn-danger" onclick="hapuspermanenall()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body table-restore" style="display:none;">
      <div class="table-responsive py-4">
        <table class="table table-flush mb-3" id="table-restore" width="100%">
          <thead class="thead-light">
            <tr>
              <th><input type="checkbox" id="checkall4"></th>
              <th>No.</th>
              <th>QR Code</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Asal Pembelian</th>
              <th>Warna</th>
              <th>Jumlah Keluar</th>
              <th>Sisa Stok</th>
              <th>Lokasi</th>
              <th>Deleted At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-body table-barang">
      <form class="formmultipledelete">
        <div class="row m-1">
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
            <div class="btn-group">
              <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                Input Barang
              </button>
              <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" onclick="formtambahbaru()"><i class="fa fa-plus-square-o"></i> Barang Baru</a>
                </li>
                <li><a class="dropdown-item" onclick="formtambahstok()"><i class="fa fa-file-text"></i> Tambah Stok Barang</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex justify-content-end">
            <button class="btn btn-warning mx-3" onclick="trfbarang()" type="button"><i class="fa fa-exchange"></i> Transfer Barang</button>
            <button type="submit" class="btn btn-danger btn-multipledelete">
              <i class="fa fa-trash-o"></i> Multiple Delete
            </button>
          </div>
        </div>
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="brgtetap-tab" data-bs-toggle="tab" href="#brgtetap" role="tab" aria-controls="brgtetap" aria-selected="true">Barang Tetap</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="alokasibrg-tab" data-bs-toggle="tab" href="#alokasibrg" role="tab" aria-controls="alokasibrg" aria-selected="false">Pengalokasian Barang Tetap</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="brgpersediaan-tab" data-bs-toggle="tab" href="#brgpersediaan" role="tab" aria-controls="brgpersediaan" aria-selected="false">Barang Persediaan</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade  show active" id="brgtetap" role="tabpanel" aria-labelledby="brgtetap-tab">
            <div class="table-responsive py-4">
              <table class="table table-flush" id="table-brgtetap" data-tab-id="brgtetap" width="100%">
                <thead class=" thead-light">
                  <tr>
                    <th><input type="checkbox" id="checkall1"></th>
                    <th>No.</th>
                    <th>QR Code</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Asal Pembelian</th>
                    <th>Warna</th>
                    <th>Jumlah Keluar</th>
                    <th>Sisa Stok</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="alokasibrg" role="tabpanel" aria-labelledby="alokasibrg-tab">
            <div class="table-responsive py-4">
              <table class="table table-flush" data-tab-id="alokasibrg" id="table-alokasibrg" width="100%">
                <thead class=" thead-light">
                  <tr>
                    <th><input type="checkbox" id="checkall2"></th>
                    <th>No.</th>
                    <th>QR Code</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Asal Pembelian</th>
                    <th>Warna</th>
                    <th>Jumlah Keluar</th>
                    <th>Sisa Stok</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="brgpersediaan" role="tabpanel" aria-labelledby="brgpersediaan-tab">
            <div class="table-responsive py-4">
              <table class="table table-flush" id="table-brgpersediaan" data-tab-id="brgpersediaan" width="100%">
                <thead class=" thead-light">
                  <tr>
                    <th><input type="checkbox" id="checkall3"></th>
                    <th>No.</th>
                    <th>QR Code</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Asal Pembelian</th>
                    <th>Warna</th>
                    <th>Jumlah Keluar</th>
                    <th>Sisa Stok</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="row m-2 btn-datarestorebarang" style="display:none;">
      <a href="<?= $nav ?>">&laquo; Kembali ke data <?= strtolower($title) ?></a>
    </div>
  </div>
  <div class="viewmodal" style="display:none;"></div>
</section>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let saveMethod, globalId;
  let jenistrx = '<?= strtolower($title) ?>';
  let tableBrgTetap, tableBrgPersediaan, tableAlokasiBrg, datarestore;
  // deklarasi variabel untuk menyimpan data lokasi
  var lokasiSarprasCache = null;
  let kd_brg = null;
  let kdbrgother = null;
  let katid = null;

  function hapus(id, ruangId, barangId, namabrg, namaruang) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namabrg} di ${namaruang}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus saja!',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= $nav ?>/hapus/" + id,
          data: {
            nama_brg: namabrg,
            nama_ruang: namaruang,
            ruangId: ruangId,
            barangId: barangId
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                tableBrgTetap.ajax.reload();
                tableBrgPersediaan.ajax.reload();
                tableAlokasiBrg.ajax.reload();
              })
            } else if (response.error) {
              Swal.fire(
                'Gagal!',
                response.error,
                'error'
              );
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-layers"> </i>${data.text}</span>`
    );

    return $result;
  }

  function imgQR(qrCanvas, centerImage, factor) {
    var h = qrCanvas.height;
    //center size
    var cs = h * factor;
    // Center offset
    var co = (h - cs) / 2;
    var ctx = qrCanvas.getContext("2d");
    ctx.drawImage(centerImage, 0, 0, centerImage.width, (centerImage.height - 50), co, co, cs, cs + 10);
    ctx.strokeStyle = "#ffffff";
    ctx.lineWidth = 15 // ketebalan garis tepi 2 piksel
    ctx.strokeRect(co, co, cs, cs + 10); // membuat garis tepi persegi panjang di sekitar gambar
  }

  function listdatabarang(tableId, ajaxUrl) {
    var jenis_kat = tableId == "table-brgpersediaan" ? "Barang Persediaan" : "Barang Tetap";
    var isRestore = tableId == "table-restore" ? 1 : 0;

    return $('#' + tableId).DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: ajaxUrl,
        data: function(d) {
          d.barang = $('#selectbarang').val()
          d.kategori = $('#selectkategori').val()
        },
        dataSrc: function(json) {
          json.data.forEach(function(item) {
            item.id = item.id;
          });
          return json.data;
        }
      },
      createdRow: function(row, data, dataIndex) {
        // Get the tab id from the data-table attribute of the table
        var tableTabId = $(this).attr('data-tab-id');

        // Add the respective class based on the tab id to the row
        $(row).find("td input[type='checkbox']").addClass('checkrow-' + tableTabId);
      },
      order: [],
      columns: [{
          data: 'checkrow',
          orderable: false,
          visible: isRestore ? false : true, // menghilangkan tanda kutip di sini
        },
        {
          data: 'no',
          orderable: false
        },
        {
          data: null,
          render: function(data, type, row) {
            return '<div id="qrcode-' + row.id + '"></div>';
          },
          visible: jenis_kat == "Barang Persediaan" || isRestore ? false : true, // menghilangkan tanda kutip di sini
          orderable: false,
          searchable: false,
        },
        {
          data: 'kode_brg'
        },
        {
          data: 'nama_brg',
        },
        {
          data: 'asal',
          render: function(data, type, row) {
            var place = row.toko ? `di ${row.toko}` : `di ${row.instansi}`;
            return `${data} ${place}`;
          }
        },
        {
          data: 'warna',
          render: function(data) {
            return capitalize(data);
          }
        },
        {
          data: 'jumlah_keluar',
          render: function(data, type, row) {
            return `${data!=='0'? `${data} ${row.kd_satuan}` : `0`} `;
          }
        },
        {
          data: 'sisa_stok',
          render: function(data, type, row) {
            if (jenis_kat == "Barang Persediaan") {
              return parseInt(data) <= 3 ? `<span class="fw-bold" style="color: red; background-color: rgba(252, 255, 0, 0.5)">${data!=='0'? `${data} ${row.kd_satuan}*` : `0`}</span>` : `${data} ${row.kd_satuan}`;
            } else {
              return `${data!=='0'? `${data} ${row.kd_satuan}` : `0`} `;
            }
          }
        },
        {
          data: 'nama_ruang'
        },

        {
          data: (!isRestore) ? 'created_at' : 'deleted_at',
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
            return `${!isRestore? `Dibuat oleh ${full.created_by}`:`Dihapus oleh ${full.deleted_by}`} pada ${formattedDate}`;
          }
        },
        {
          data: 'action',
          orderable: false
        },
      ],
      drawCallback: function(settings) {
        if (jenis_kat !== "Barang Persediaan") {
          var api = this.api();
          api.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();
            var id = rowData.id;
            var kodebarang = rowData.kode_brg;
            var loc_id = rowData.ruang_id;
            const kdbrg = kodebarang.split(".").join("-");
            const logo = "<?= base_url('assets/images/logo/logounira.jpg') ?>";

            const icon = new Image();
            icon.onload = function() {
              // create qr code with logo
              var qrcode = new QRCode(document.getElementById('qrcode-' + id), {
                text: `<?= base_url() ?>detail-barang/${kdbrg}-${loc_id}`,
                width: 200,
                height: 200,
                correctLevel: QRCode.CorrectLevel.H,
                colorDark: "#000000",
                colorLight: "#ffffff",
              });
              imgQR(qrcode._oDrawing._elCanvas, this, 0.2);
            }
            icon.src = logo;
          });
        }
      },
    });
  }

  function filteringData(jenis_kat) {
    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihbarang",
      data: {
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        $('#selectbarang').empty(); // Clear existing options
        $('#selectbarang').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectbarang').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihkategori",
      data: {
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        $('#selectkategori').empty(); // Clear existing options
        $('#selectkategori').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectkategori').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });
  }

  $(document).ready(function() {
    $('#checkall1, #checkall2, #checkall3').prop('checked', false)
    var hrefTab = window.location.hash;

    if (!hrefTab) {
      hrefTab = '#brgtetap';
    }

    $('.nav-link').removeClass('active');
    $('.nav-link[href="' + hrefTab + '"]').addClass('active');

    $('.tab-pane').removeClass('show active');
    $(hrefTab).addClass('show active');

    // Initialize DataTables for each tab content
    tableBrgTetap = listdatabarang('table-brgtetap', '<?= $nav ?>/listdatabarang?jenis_kat=Barang%20Tetap&isRestore=0');
    tableAlokasiBrg = listdatabarang('table-alokasibrg', '<?= $nav ?>/listdatabarang?jenis_kat=Barang%20Tetap&isRestore=0&hal=Alokasibrg');
    tableBrgPersediaan = listdatabarang('table-brgpersediaan', '<?= $nav ?>/listdatabarang?jenis_kat=Barang%20Persediaan&isRestore=0');

    filteringData('Barang Tetap');

    // Event handler for tab clicks
    $('.nav-link').on('click', function() {
      // Hide all tab content
      $('.tab-pane').removeClass('show active');

      // Show the corresponding tab content based on the clicked tab
      var targetTab = $(this).attr('href');
      $(targetTab).addClass('show active');

      // Redraw the DataTable for the current tab to load the data from the server
      if (targetTab === '#brgtetap') {
        tableBrgTetap.ajax.reload();
        checkrowDef();
        filteringData('Barang Tetap');
      } else if (targetTab === '#alokasibrg') {
        tableAlokasiBrg.ajax.reload();
        checkrowDef();
        filteringData('Barang Tetap');
      } else if (targetTab === '#brgpersediaan') {
        tableBrgPersediaan.ajax.reload();
        checkrowDef();
        filteringData('Barang Persediaan');
      }
    });

    $('#selectbarang').on('change', function(e) {
      e.preventDefault();
      if (tableBrgTetap) {
        tableBrgTetap.ajax.reload();
      }
      if (tableBrgPersediaan) {
        tableBrgPersediaan.ajax.reload();
      }
      if (tableAlokasiBrg) {
        tableAlokasiBrg.ajax.reload();
      }
      if (datarestore) {
        datarestore.ajax.reload();
      }
    })
    $('#selectkategori').on('change', function(e) {
      e.preventDefault();
      if (tableBrgTetap) {
        tableBrgTetap.ajax.reload();
      }
      if (tableAlokasiBrg) {
        tableAlokasiBrg.ajax.reload();
      }
      if (tableBrgPersediaan) {
        tableBrgPersediaan.ajax.reload();
      }
      if (datarestore) {
        datarestore.ajax.reload();
      }
    })

    // Call the function for each group of checkboxes
    handleCheckAll('#checkall1', '.checkrow-brgtetap');
    handleCheckAll('#checkall2', '.checkrow-alokasibrg');
    handleCheckAll('#checkall3', '.checkrow-brgpersediaan');

    $('#btn-restore').on('click', function() {
      $('.table-barang').hide();
      $('.table-restore').show();
      $('.datalist-barang h4').html('Restore Data <?= $title; ?>');
      $('.btn-databarang').hide();
      $('.btn-datarestorebarang').show();

      datarestore = listdatabarang('table-restore', '<?= $nav ?>/listdatabarang?isRestore=1');
    });

    //Temporary multiple delete
    $('.formmultipledelete').submit(function(e) {
      e.preventDefault();
      let selectedRows = $('td input[type="checkbox"]:checked');
      var keterangan;
      if (selectedRows.attr('class') == "checkrow-brgpersediaan") {
        keterangan = "Barang Persediaan";
      } else if (selectedRows.attr('class') == "checkrow-brgtetap") {
        keterangan = "Barang Tetap";
      } else if (selectedRows.attr('class') == "checkrow-alokasibrg") {
        keterangan = "Alokasi Barang Tetap";
      }
      var selectedIds = $('td:nth-child(1) input[type="checkbox"]:checked').map(function() {
        return $(this).val();
      }).get();
      var jmldata = selectedIds.length;
      var formdata = new FormData(this);
      formdata.append('jenis_kat', keterangan);

      if (jmldata === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Maaf silahkan pilih data <?= strtolower($title) ?> yang mau dihapus'
        })
      } else {
        Swal.fire({
          title: 'Multiple Delete',
          text: `Apakah kamu yakin ingin menghapus ${jmldata} data ${keterangan.toLowerCase()} secara temporary?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Hapus saja!',
          cancelButtonText: 'Batalkan',
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "post",
              url: `<?= $nav ?>/multipledelete`,
              data: formdata,
              processData: false,
              contentType: false,
              success: function(result) {
                var response = JSON.parse(result);
                if (response.sukses) {
                  Swal.fire(
                    'Berhasil', response.sukses, 'success'
                  ).then((result) => {
                    tableBrgTetap.ajax.reload();
                    tableBrgPersediaan.ajax.reload();
                    tableAlokasiBrg.ajax.reload();
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
              }
            });
          } else {
            Swal.fire(
              'Gagal', 'Tidak ada data <?= strtolower($title) ?> yang dihapus', 'info'
            )
          }
        });
      }

      return false;
    })
  });

  function handleCheckAll(checkbox, target) {
    $(checkbox).click(function() {
      $(target).prop('checked', this.checked);
    });

    $(document).on('click', target, function() {
      $(checkbox).prop('checked', $(target).length === $(target + ':checked').length);
    });
  }

  function checkrowDef() {
    $('.checkrow-brgtetap').prop('checked', false);
    $('.checkrow-alokasibrg').prop('checked', false);
    $('.checkrow-brgpersediaan').prop('checked', false);
  }

  function detailstokbarang(kd_brg, ruang_id) {
    const kdbrg = kd_brg.split(".").join("-");
    const loc_id = ruang_id;

    window.location.href = `<?= $nav ?>/detail-barang/${kdbrg}-${loc_id}`;
  }

  function cetaklabel(id) {
    $.ajax({
      type: "post",
      url: "<?= $nav ?>/tampillabelbarang",
      data: {
        id: id,
        nav: "<?= $nav ?>"
      },
      dataType: 'json',
      success: function(response) {
        $('.viewmodal').html(response.sukses).show(500);
        $('#modallabel').modal('show');
      }
    });
  }

  function restore(id, ruangId, barangId, namabrg, namaruang) {
    Swal.fire({
      title: `Memulihkan data ${namabrg} di ${namaruang}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= $nav ?>/restore",
          data: {
            id: id,
            nama_brg: namabrg,
            nama_ruang: namaruang,
            ruangId: ruangId,
            barangId: barangId,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestore.ajax.reload();
              })
            } else if (response.error) {
              Swal.fire(
                'Gagal!',
                response.error,
                'error'
              );
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function restoreall() {
    var api = $('#table-restore').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var ruang_id = api.data().toArray().map(function(d) {
      return d.ruang_id;
    })
    var barang_id = api.data().toArray().map(function(d) {
      return d.barang_id;
    })
    var nama_brg = api.data().toArray().map(function(d) {
      return d.nama_brg;
    })
    var nama_ruang = api.data().toArray().map(function(d) {
      return d.nama_ruang;
    })

    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title) ?> yang dapat dipulihkan',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data  <?= strtolower($title) ?> yang telah terhapus?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        restore(id.toString(), ruang_id.toString(), barang_id.toString(), nama_brg.toString(), nama_ruang.toString());
      });
    } else {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data  <?= strtolower($title) ?> yang telah terhapus?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "<?= $nav ?>/restore",
            data: {
              id: id.join(","),
              barangId: barang_id.join(","),
              ruangId: ruang_id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  location.reload();
                })
              } else if (response.error) {
                Swal.fire(
                  'Gagal!',
                  response.error,
                  'error'
                );
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        }
      });
    }
  }

  function hapuspermanen(id, ruangId, barangId, namabrg, namaruang) {
    Swal.fire({
      width: 700,
      title: `Menghapus data ${namabrg} di ${namaruang} secara permanen?`,
      icon: 'warning',
      text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
      cancelButtonText: 'Batalkan',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "<?= $nav ?>/hapuspermanen",
          data: {
            id: id,
            nama_brg: namabrg,
            nama_ruang: namaruang,
            ruangId: ruangId,
            barangId: barangId,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestore.ajax.reload();
              })
            } else if (response.error) {
              Swal.fire(
                'Gagal!',
                response.error,
                'error'
              );
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    });
  }

  function hapuspermanenall() {
    var api = $('#table-restore').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var ruang_id = api.data().toArray().map(function(d) {
      return d.ruang_id;
    })
    var barang_id = api.data().toArray().map(function(d) {
      return d.barang_id;
    })
    var nama_brg = api.data().toArray().map(function(d) {
      return d.nama_brg;
    })
    var nama_ruang = api.data().toArray().map(function(d) {
      return d.nama_ruang;
    })

    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title) ?> yang dapat dihapus secara permanen',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data <?= strtolower($title) ?> secara permanen?`,
        icon: 'warning',
        text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        hapuspermanen(id.toString(), ruang_id.toString(), barang_id.toString(), nama_brg.toString(), nama_ruang.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data <?= strtolower($title) ?> secara permanen?`,
        icon: 'warning',
        text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "post",
            url: "<?= $nav ?>/hapuspermanen",
            data: {
              id: id.join(","),
              barangId: barang_id.join(","),
              ruangId: ruang_id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  datarestore.ajax.reload();
                })
              } else if (response.error) {
                Swal.fire(
                  'Gagal!',
                  response.error,
                  'error'
                );
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        }
      });
    }
  }

  function edit(id) {
    saveMethod = "update";
    globalId = id;
    $('#cardmultipleinsert').hide(500);
    $('#cardsingleleinsert').hide(500);

    $.ajax({
      type: "post",
      url: "<?= $nav ?>/tampileditform",
      data: {
        id: id,
        title: "<?= $title ?>",
        nav: "<?= $nav ?>",
        saveMethod: saveMethod,
      },
      dataType: "json",
      success: function(response) {
        $('.viewdata').html(response.data).show(500);
      }
    });
  }

  function formtambahbaru() {
    $('.viewdata').hide(500);
    $.ajax({
      type: "post",
      url: "<?= $nav ?>/tampiltambahbarangmultiple",
      data: {
        title: jenistrx,
        nav: "<?= $nav ?>",
        saveMethod: "add",
      },
      dataType: "json",
      success: function(response) {
        $('.viewtambahmultiple').html(response.data).show(500);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function formtambahstok() {
    $('.viewdata').hide(500);
    $.ajax({
      type: "post",
      url: "<?= $nav ?>/tampiltambahstokmultiple",
      data: {
        title: "<?= $title ?>",
        nav: "<?= $nav ?>",
      },
      dataType: "json",
      success: function(response) {
        $('.viewtambahmultiple').html(response.data).show(500);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function upload(id, nama_brg, foto_barang) {
    $('#cardmultipleinsert').hide(500);
    $.ajax({
      type: "post",
      url: "<?= $nav ?>/tampilcardupload",
      data: {
        id: id,
        nama_brg: nama_brg,
        foto_barang: foto_barang,
        nav: "<?= $nav ?>"
      },
      dataType: "json",
      success: function(response) {
        $('.viewdata').html(response.sukses).show(500);
      }
    });
  }

  function trfbarang() {
    let selectedRows = $('td input[type="checkbox"]:checked');
    if (selectedRows.length > 0 && selectedRows.attr('class') !== "checkrow-brgpersediaan") {
      var selectedIds = $('td:nth-child(1) input[type="checkbox"]:checked').map(function() {
        return $(this).val();
      }).get();
      var jmldata = selectedIds.length;
      $.ajax({
        type: 'post',
        url: '<?= $nav ?>/tampiltransferform',
        data: {
          ids: selectedIds.join(","),
          jmldata: jmldata,
          nav: '<?= $nav; ?>',
        },
        dataType: "json",
        success: function(response) {
          $('.viewdata').html(response.data).show(500);
        }
      });
    } else {
      var text = selectedRows.attr('class') == "checkrow-brgpersediaan" ? 'Tidak dapat melakukan transfer barang' : 'Tidak ada data yang dipilih';
      Swal.fire(
        'Perhatian!',
        text,
        'warning'
      );
    }
  }
</script>
<?= $this->endSection() ?>