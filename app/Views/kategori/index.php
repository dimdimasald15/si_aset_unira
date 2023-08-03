<?= $this->extend('/layouts/template'); ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar <?= $title ?></h3>
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
  <div class="viewform" style="display: none;"></div>
  <div class="card shadow mb-3 datalist-kategori">
    <div class="card-header shadow-sm text-white bg-dark shadow">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-lg-auto btn-datakategori">
            <button type="button" class="btn btn-primary" id="btn-restore"><i class="fa fa-recycle"></i> Recycle Bin</button>
          </div>
          <div class="col-lg-auto btn-datarestorekategori" style="display:none;">
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
              <th>Kode Kategori</th>
              <th>Nama Kategori</th>
              <th>Deskripsi</th>
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
    <div class="card-body table-kategori">
      <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="ktetap-tab" data-bs-toggle="tab" href="#ktetap" role="tab" aria-controls="ktetap" aria-selected="true">Kategori Barang Tetap</a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" id="kpersediaan-tab" data-bs-toggle="tab" href="#kpersediaan" role="tab" aria-controls="kpersediaan" aria-selected="false">Kategori Barang Persediaan</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="ktetap" role="tabpanel" aria-labelledby="ktetap-tab">
          <div class="row mt-3">
            <div class="col-sm-12 d">
              <button type="button" class="btn btn-success" onclick="tampilform('add','Barang Tetap')" id="btn-addktetap">
                <i class="bi bi-layers"></i>
                Tambah Kategori Tetap
              </button>
            </div>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="table-ktetap" width="100%">
              <thead class=" thead-light">
                <tr>
                  <th>No.</th>
                  <th>Kode Kategori</th>
                  <th>Nama Kategori</th>
                  <th>Deskripsi</th>
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
        <div class="tab-pane fade" id="kpersediaan" role="tabpanel" aria-labelledby="kpersediaan-tab">
          <div class="row mt-3">
            <div class="col-sm-12 d">
              <button type="button" class="btn btn-success" onclick="tambah('Barang Persediaan')" id="btn-addkpersediaan">
                <i class="bi bi-layers"></i>
                Tambah Kategori Persediaan
              </button>
            </div>
          </div>
          <div class="table-responsive py-4">
            <table class="table table-flush" id="table-kpersediaan" width="100%">
              <thead class=" thead-light">
                <tr>
                  <th>No.</th>
                  <th>Kode Kategori</th>
                  <th>Nama Kategori</th>
                  <th>Deskripsi</th>
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

    </div>
    <div class="row m-2 btn-datarestorekategori" style="display:none;">
      <a href="<?= $nav; ?>">&laquo; Kembali ke data <?= strtolower($title) ?></a>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let tableKatTetap, tableKatPersediaan, datarestore;

  $(document).ready(function() {
    // Initialize DataTables for each tab content
    tableKatTetap = listdatakategori('table-ktetap', '<?= $nav ?>/listdatakategori?jenis=Barang%20Tetap&isRestore=0');
    tableKatPersediaan = listdatakategori('table-kpersediaan', '<?= $nav ?>/listdatakategori?jenis=Barang%20Persediaan&isRestore=0');

    // Event handler for tab clicks
    $('.nav-link').on('click', function() {
      // Hide all tab content
      $('.tab-pane').removeClass('show active');

      // Show the corresponding tab content based on the clicked tab
      var targetTab = $(this).attr('href');
      $(targetTab).addClass('show active');

      // Redraw the DataTable for the current tab to load the data from the server
      if (targetTab === '#ktetap') {
        tableKatTetap.ajax.reload();
      } else if (targetTab === '#kpersediaan') {
        tableKatPersediaan.ajax.reload();
      }
    });

    $('#btn-restore').on('click', function() {
      $('.table-kategori').hide();
      $('.table-restore').show();
      $('.datalist-kategori h4').html('Restore Data <?= $title; ?>');
      $('.btn-datakategori').hide();
      $('.btn-datarestorekategori').show();

      datarestore = listdatakategori('table-restore', '<?= $nav ?>/listdatakategori?isRestore=1');
    });

  });

  function listdatakategori(tableId, ajaxUrl) {
    var jenis_kat = tableId == "table-kpersediaan" ? "Barang Persediaan" : "Barang Tetap";
    var isRestore = tableId == "table-restore" ? 1 : 0;

    return $('#' + tableId).DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: ajaxUrl,
      },
      order: [],
      columns: [{
          data: 'no',
          orderable: false
        },
        {
          data: 'kd_kategori'
        },
        {
          data: 'nama_kategori'
        },
        {
          data: 'deskripsi',
          visible: jenis_kat == "Barang Tetap" ? true : false,
        },
        {
          data: isRestore ? 'deleted_by' : 'created_by',
        },
        {
          data: isRestore ? 'deleted_at' : 'created_at',
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
      ],
      autowidth: true,
    });
  }

  function tampilform(saveMethod, jenis, id) {
    let globalId = (id !== undefined) ? id : '';

    $.ajax({
      type: "post",
      url: "<?= $nav ?>/tampilformtambah",
      data: {
        title: "<?= $title ?>",
        nav: "<?= $nav ?>",
        jenis: jenis,
        saveMethod: saveMethod,
        globalId: globalId
      },
      dataType: "json",
      success: function(response) {
        $('.viewform').html(response.data).show(500);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  function hapus(id, namakategori) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namakategori}?`,
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
            nama_kategori: namakategori
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                tableKatTetap.ajax.reload();
                tableKatPersediaan.ajax.reload();
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

  function restore(id, namakategori) {
    Swal.fire({
      title: `Memulihkan data ${namakategori}?`,
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
          url: "<?= $nav ?>/restore/" + id,
          data: {
            nama_kategori: namakategori,
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
    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title); ?> yang dapat dipulihkan',
        'error'
      );
    } else {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data yang telah terhapus?`,
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

  function hapuspermanen(id, namakategori) {
    Swal.fire({
      width: 700,
      title: `Menghapus data ${namakategori} secara permanen?`,
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
          url: "<?= $nav ?>/hapuspermanen/" + id,
          data: {
            nama_kategori: namakategori
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
    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title); ?> yang dapat dihapus secara permanen',
        'error'
      );
    } else {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data <?= strtolower($title); ?> secara permanen?`,
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
</script>
<?= $this->endSection() ?>