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
  <div class="card shadow mb-3 datalist-pinjam">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-md-auto btn-datapinjam">
            <button type="button" class="btn btn-primary" id="btn-restore"><i class="fa fa-recycle"></i> Recycle Bin</button>
          </div>
          <div class="col-lg-auto btn-datarestorepinjam" style="display:none;">
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
              <th>Nama Peminjam</th>
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
    <div class="card-body table-pinjam">
      <form class="formmultipledelete">
        <div class="row m-1">
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
            <div class="btn-group">
              <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                Input Peminjaman
              </button>
              <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" onclick="singleform()"><i class="fa fa-plus-square-o"></i> Tambah Peminjaman
                  </a>
                </li>
                <!-- <li><a class="dropdown-item" onclick="multipleinsert()"><i class="fa fa-file-text"></i> Input Multiple</a>
                </li> -->
              </ul>
            </div>
            <button class="btn btn-warning" id="tampilformkembali"><i class="fa fa-edit"></i> Form Pengembalian</button>
          </div>
          <div class="col-md-6 pb-0 pt-3 px-0 d-flex justify-content-end">
            <button type="submit" class="btn btn-danger btn-multipledelete">
              <i class="fa fa-trash-o"></i> Multiple Delete
            </button>
          </div>
        </div>
        <div class="table-responsive py-4">
          <table class="table table-flush" id="table-pinjam" width="100%">
            <thead class=" thead-light">
              <tr>
                <th><input type="checkbox" id="checkall"></th>
                <th>No.</th>
                <th>Nama Peminjam</th>
                <th>Asal</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Satuan</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
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
    <div class="row m-2 btn-datarestorepinjam" style="display:none;">
      <a href="<?= $nav; ?>">&laquo; Kembali ke data <?= strtolower($title); ?></a>
    </div>
  </div>

  <div class="viewmodal" style="display:none;"></div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  let jenistrx = "Peminjaman <?= $jenis_kat ?>";
  let jenis_kat = "<?= $jenis_kat ?>";
  let datapinjam = "";
  let datarestore = "";

  $(document).ready(function() {
    // Check Row
    $('#checkall').click(function() {
      if ($(this).is(':checked')) {
        $('.checkrow').prop('checked', true);
      } else {
        $('.checkrow').prop('checked', false);
      }
    })
    // Check Row
    $('.checkrow').click(function() {
      var allChecked = true;
      $('.checkrow').each(function() {
        if (!$(this).is(':checked')) {
          allChecked = false;
        }
      });
      if (allChecked) {
        $('#checkall').prop('checked', true);
      } else {
        $('#checkall').prop('checked', false);
      }
    });

    datapinjam = $('#table-pinjam').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= $nav ?>/listdatapeminjaman?jenis_kat=${jenis_kat}&isRestore=0`,
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
          data: 'tgl_pinjam',
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
          data: 'tgl_kembali',
          render: function(data, type, full, meta) {
            if (data !== null) {
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
            } else {
              return '-';
            }
          }
        },
        {
          data: 'status',
          render: function(data) {
            if (data === '0') {
              var viewStatus = `<span class="badge bg-danger">Belum kembali</span>`;
            } else if (data === '1') {
              var viewStatus = `<span class="badge bg-primary">Sudah kembali</span>`;
            }
            return viewStatus;
          }
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

    $('#tampilformkembali').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url() ?>/peminjamancontroller/tampilformkembali",
        data: {
          saveMethod: "update",
          nav: "<?= $nav ?>",
          jenis_kat: jenis_kat,
          formname: "Form Kembali"
        },
        dataType: "json",
        success: function(response) {
          $('.viewform').show().html(response.data);
        }
      });
    });

    $('#btn-restore').on('click', function(e) {
      e.preventDefault();
      $('.table-pinjam').hide();
      $('.viewform').hide();
      $('.table-restore').show();
      $('.datalist-pinjam h4').html('Restore Data <?= $title; ?>');
      $('.btn-datapinjam').hide();
      $('.btn-datarestorepinjam').show();

      datarestore = $('#table-restore').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: `<?= $nav ?>/listdatapeminjaman?jenis_kat=${jenis_kat}&isRestore=1`,
          dataSrc: function(json) {
            json.data.forEach(function(item) {
              item.id = item.id;
            });
            return json.data;
          }
        },
        order: [],
        columns: [{
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
            data: 'deleted_by'
          },
          {
            data: 'deleted_at',
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

    $('.formmultipledelete').submit(function(e) {
      e.preventDefault();

      let jmldata = $('.checkrow:checked');
      var formdata = new FormData(this);
      formdata.append('jenis_kat', jenis_kat);

      if (jmldata.length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Maaf silahkan pilih data <?= strtolower($title); ?> yang mau dihapus'
        })
      } else {
        Swal.fire({
          title: 'Multiple Delete',
          text: `Apakah kamu yakin ingin menghapus ${jmldata.length} data <?= strtolower($title); ?> secara temporary?`,
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
                    datapinjam.ajax.reload();
                    $('#checkall').prop('checked', false);
                    $('.viewform').hide();
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
              }
            });
          } else {
            Swal.fire(
              'Gagal', 'Tidak ada data <?= strtolower($title); ?> yang dihapus', 'info'
            )
          }
        });
      }

      return false;
    })
  });

  function singleform() {
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/peminjamancontroller/tampilsingleform",
      data: {
        saveMethod: "add",
        nav: "<?= $nav ?>",
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        $('.viewform').show().html(response.data);
      }
    });
  }

  function edit(id) {
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/peminjamancontroller/tampilsingleform",
      data: {
        globalId: id,
        saveMethod: "update",
        nav: "<?= $nav ?>",
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
        $('.viewform').show().html(response.data);
      }
    });
  }

  function hapus(id, namaanggota, namabrg, jml, satuan, ) {
    Swal.fire({
      width: 700,
      title: `Apakah kamu yakin ingin menghapus data peminjaman ${namaanggota} atas ${jml} ${satuan} ${namabrg}?`,
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
            nama_anggota: namaanggota
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datapinjam.ajax.reload();
                $('.viewform').hide();
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

  function restore(id, idbrg, namabrg, namaanggota) {
    Swal.fire({
      title: `Memulihkan data <?= strtolower($title); ?> ${namabrg} oleh ${namaanggota}?`,
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
            barang_id: idbrg,
            nama_brg: namabrg,
            nama_anggota: namaanggota,
            jenis_kat: jenis_kat,
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
    var barang_id = api.data().toArray().map(function(d) {
      return d.barang_id;
    })
    var nama_brg = api.data().toArray().map(function(d) {
      return d.nama_brg;
    })
    var nama_anggota = api.data().toArray().map(function(d) {
      return d.nama_anggota;
    })
    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title); ?> yang dapat dipulihkan',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data <?= $title ?> yang telah terhapus?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        restore(id.toString(), barang_id.toString(), nama_brg.toString(), nama_anggota.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data <?= $title ?> yang telah terhapus?`,
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
              barang_id: barang_id.join(","),
              jenis_kat: jenis_kat,
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

  function hapuspermanen(id, idbrg, namabrg, namaanggota) {
    Swal.fire({
      width: 700,
      title: `Menghapus data peminjaman ${namaanggota} atas barang ${namabrg} secara permanen?`,
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
            barang_id: idbrg,
            nama_brg: namabrg,
            nama_anggota: namaanggota,
            jenis_kat: jenis_kat,
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
    var barang_id = api.data().toArray().map(function(d) {
      return d.barang_id;
    })
    var nama_brg = api.data().toArray().map(function(d) {
      return d.nama_brg;
    })
    var nama_anggota = api.data().toArray().map(function(d) {
      return d.nama_anggota;
    })

    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data <?= strtolower($title); ?> yang dapat dihapus secara permanen',
        'error'
      );
    } else if (api.count() === 1) {
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
        hapuspermanen(id.toString(), barang_id.toString(), nama_brg.toString(), nama_anggota.toString());
      });
    } else if (api.count() > 1) {
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
            data: {
              id: id.join(","),
              barang_id: barang_id.join(","),
              jenis_kat: jenis_kat,
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
</script>
<?= $this->endSection() ?>