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
  <div class="viewform"></div>
  <div class="card mb-3 shadow">
    <div class="card-header shadow-sm">
      <h4 class="card-title">Custom Filter</h4>
    </div>
    <div class=" card-body">
      <div class="row mt-3">
        <div class="col-sm-4 d-flex justify-content-start">
          <label class="col-sm-4 col-form-label" for="selectbarang">Barang :</label>
          <div class="col-sm-8">
            <select id="selectbarang" class="form-select"></select>
          </div>
        </div>
        <div class="col-sm-4 d-flex justify-content-start">
          <label class="col-sm-4 col-form-label" for="selectkategori">Kategori :</label>
          <div class="col-sm-8">
            <select id="selectkategori" class="form-select"></select>
          </div>
        </div>
        <div class="col-sm-4 d-flex justify-content-start">
          <label class="col-sm-4 col-form-label" for="selectlokasi">Lokasi :</label>
          <div class="col-sm-8">
            <select id="selectlokasi" class="form-select"></select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card shadow mb-3 datalist-alokasi">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data <?= $title ?></h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-md-auto btn-dataalokasi">
            <button type="button" class="btn btn-primary" id="btn-restore"><i class="fa fa-recycle"></i> Recycle Bin</button>
          </div>
          <div class="col-lg-auto btn-datarestorealokasi" style="display:none;">
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
              <th>Nama Barang</th>
              <th>Lokasi</th>
              <th>Stok</th>
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
    <div class="card-body table-alokasi">
      <form class="formmultipledelete">
        <div class="row m-1">
          <div class="col-md-12 pb-0 pt-3 px-0 d-flex justify-content-end">
            <button class="btn btn-warning mx-3" onclick="trfbarang()" type="button"><i class="fa fa-exchange" hidden></i> Transfer Barang</button>
            <button type="submit" class="btn btn-danger btn-multipledelete">
              <i class="fa fa-trash-o"></i> Multiple Delete
            </button>
          </div>
        </div>
        <div class="table-responsive py-4">
          <table class="table table-flush" id="table-alokasi" width="100%">
            <thead class=" thead-light">
              <tr>
                <th><input type="checkbox" id="checkall"></th>
                <th>No.</th>
                <th <?= $jenis_kat == "Barang Persediaan" ? 'hidden' : '' ?>>QR Code</th>
                <th>Nama Barang</th>
                <th>Lokasi</th>
                <th>Stok</th>
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
    <div class="row m-2 btn-datarestorealokasi" style="display:none;">
      <a href="<?= $nav ?>">&laquo; Kembali ke data <?= strtolower($title); ?></a>
    </div>
  </div>

  <div class="viewmodal" style="display:none;"></div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  let saveMethod, globalId;
  let jenistrx = '<?= strtolower($title); ?>';
  let jenis_kat = '<?= $jenis_kat ?>';
  let dataalokasi = '';
  let datarestore = '';

  function imgQR(qrCanvas, centerImage, factor) {
    var h = qrCanvas.height;
    //center size
    var cs = h * factor;
    // Center offset
    var co = (h - cs) / 2;
    var ctx = qrCanvas.getContext("2d");
    ctx.drawImage(centerImage, 0, 0, centerImage.width, centerImage.height, co, co, cs, cs + 10);
    ctx.strokeStyle = "#ffffff";
    ctx.lineWidth = 2 // ketebalan garis tepi 2 piksel
    ctx.strokeRect(co, co, cs, cs + 10); // membuat garis tepi persegi panjang di sekitar gambar
  }

  $(document).ready(function() {
    dataalokasi = $('#table-alokasi').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: `<?= $nav ?>/listdataalokasi?jenis_kat=${jenis_kat}&isRestore=0`,
        data: function(d) {
          d.barang = $('#selectbarang').val()
          d.kategori = $('#selectkategori').val()
          d.lokasi = $('#selectlokasi').val()
        },
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
          orderable: false,
          searchable: false,
        },
        {
          data: 'no',
          orderable: false,
          searchable: false,
        },
        {
          data: null,
          render: function(data, type, row) {
            return '<div id="qrcode-' + row.id + '"></div>';
          },
          searchable: false,
          visible: <?= $jenis_kat == "Barang Persediaan" ? 'false' : 'true' ?> // menambahkan kolom baru dan menyembunyikannya
        },
        {
          data: 'nama_brg'
        },
        {
          data: 'nama_ruang'
        },
        {
          data: 'sisa_stok',
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
      ],
      drawCallback: function(settings) {
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
              text: `<?= base_url() ?>/public/detail-barang/${kdbrg}-${loc_id}`,
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
    });

    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihbarang",
      data: {
        jenis_kat: jenis_kat,
      },
      dataType: "json",
      success: function(response) {
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
        $('#selectkategori').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectkategori').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $.ajax({
      type: "get",
      url: "<?= $nav ?>/pilihlokasi",
      dataType: "json",
      success: function(response) {
        $('#selectlokasi').append(`<option value="">Pilih Semua</option>`);
        for (var i = 0; i < response.length; i++) {
          $('#selectlokasi').append(`<option value="${response[i].id}">${response[i].text}</option>`);
        }
      }
    });

    $('#selectbarang').on('change', function(e) {
      e.preventDefault();
      if (dataalokasi) {
        dataalokasi.ajax.reload();
      }
      if (datarestore) {
        datarestore.ajax.reload();
      }
    })
    $('#selectkategori').on('change', function(e) {
      e.preventDefault();
      if (dataalokasi) {
        dataalokasi.ajax.reload();
      }
      if (datarestore) {
        datarestore.ajax.reload();
      }
    })

    $('#selectlokasi').on('change', function(e) {
      e.preventDefault();
      if (dataalokasi) {
        dataalokasi.ajax.reload();
      }
      if (datarestore) {
        datarestore.ajax.reload();
      }
    })
    $('#btn-restore').on('click', function() {
      $('.table-alokasi').hide();
      $('.table-restore').show();
      $('.datalist-alokasi h4').html('Restore Data <?= $title; ?>');
      $('.btn-dataalokasi').hide();
      $('.btn-datarestorealokasi').show();

      datarestore = $('#table-restore').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: `<?= $nav ?>/listdataalokasi?jenis_kat=${jenis_kat}&isRestore=1`,
          data: function(d) {
            d.barang = $('#selectbarang').val()
            d.kategori = $('#selectkategori').val()
            d.lokasi = $('#selectlokasi').val()
          },
        },
        order: [],
        columns: [{
            data: 'no',
            orderable: false
          },
          {
            data: 'nama_brg'
          },
          {
            data: 'nama_ruang'
          },
          {
            data: 'sisa_stok',
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
        ],
      });
    });
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
    //Temporary multiple delete
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
                    dataalokasi.ajax.reload();
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

    $('.formmultipledelete').submit(function(e) {
      e.preventDefault();

      let jmldata = $('.checkrow:checked');
      var formdata = new FormData(this);
      formdata.append('jenis_kat', jenis_kat);
      formdata.append('idsarpras', 54);

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
                    dataalokasi.ajax.reload();
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

  function detailstokbarang(kd_brg, ruang_id) {
    const kdbrg = kd_brg.split(".").join("-");
    const loc_id = ruang_id;

    window.location.href = `<?= $nav ?>/detail-barang/${kdbrg}-${loc_id}`;
  }

  function hapus(id, namabrg, namaruang, idsarpras) {
    console.log(idsarpras);
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namabrg} di ${namaruang}?`,
      text: `Jika data ${namabrg} di ${namaruang} dihapus secara temporary, maka jumlah barang di kembalikan ke Sarana dan Prasarana.`,
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
            idsarpras: idsarpras,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                dataalokasi.ajax.reload();
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

  function restore(id, idbrg, namabrg, namaruang) {
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
            barang_id: idbrg,
            nama_brg: namabrg,
            nama_ruang: namaruang,
            jenis_kat: jenis_kat,
            idsarpras: 54,
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
    var nama_ruang = api.data().toArray().map(function(d) {
      return d.nama_ruang;
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
        restore(id.toString(), barang_id.toString(), nama_brg.toString(), nama_ruang.toString());
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
              idsarpras: 54,
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

  function hapuspermanen(id, namabrg, namaruang) {
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
    var nama_brg = api.data().toArray().map(function(d) {
      return d.nama_brg;
    })
    var nama_ruang = api.data().toArray().map(function(d) {
      return d.nama_ruang;
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
        hapuspermanen(id.toString(), nama_brg.toString(), nama_ruang.toString());
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

  function cetaklabel(id) {
    $.ajax({
      type: "post",
      url: "<?= base_url() ?>/pengalokasiancontroller/tampillabelbarang",
      data: {
        id: id,
      },
      dataType: 'json',
      success: function(response) {
        $('.viewmodal').html(response.sukses).show(500);
        $('#modallabel').modal('show');
      }
    });
  }

  function trfbarang() {
    let selectedRows = $('#table-alokasi input[type="checkbox"]:checked');
    if (selectedRows.length > 0) {
      // var ids = [];
      var selectedIds = $('td:nth-child(1) input.checkrow:checked').map(function() {
        return $(this).val();
      }).get();
      var jmldata = selectedIds.length;

      $.ajax({
        type: 'post',
        url: '<?= base_url() ?>/alokasicontroller/tampiltransferform',
        data: {
          ids: selectedIds.join(","),
          title: "<?= $title ?>",
          jenis_kat: jenis_kat,
          jmldata: jmldata,
          saveMethod: 'update',
          nav: '<?= $nav; ?>',
        },
        dataType: "json",
        success: function(response) {
          $('.viewform').html(response.data).show(500);
        }
      });

    } else {
      Swal.fire(
        'Perhatian!',
        'Tidak ada data yang dipilih',
        'warning'
      )
    }
  }
</script>
<?= $this->endSection() ?>