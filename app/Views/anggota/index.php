<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar <?= $title ?></h3>
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
  <div class="row">
    <div class="viewform" style="display:none;"></div>
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
                <button type="button" class="btn btn-success" id="btn-tambahunit">
                  <i class="bi bi-circle-square"></i>
                  Tambah unit
                </button>
                <button type="button" class="btn btn-primary" id="btn-restoreunit"><i class="fa fa-recycle"></i> Recycle Bin</button>
              </div>
              <div class="col-lg-auto btn-datarestoreunit" style="display:none;">
                <button class="btn btn-success" onclick="restoreallunit()"><i class="fa fa-undo"></i> Pulihkan semua</button>
                <button class="btn btn-danger" onclick="hapuspermanenallunit()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
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
          <form id="formDeleteUnit">
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
          <a href="<?= $nav ?>">&laquo; Kembali ke data unit</a>
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
                <button type="button" class="btn btn-success" id="btn-tambahanggota">
                  <i class="bi bi-people"></i>
                  Tambah Anggota
                </button>
                <button type="button" class="btn btn-primary" id="btn-restoreanggota"><i class="fa fa-recycle"></i> Recycle Bin</button>
              </div>
              <div class="col-lg-auto btn-datarestoreanggota" style="display:none;">
                <button class="btn btn-success" onclick="restoreallanggota()"><i class="fa fa-undo"></i> Pulihkan semua</button>
                <button class="btn btn-danger" onclick="hapuspermanenallanggota()"><i class="fa fa-trash"></i> Hapus semua permanen</button>
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
          <form id="formDeleteAnggota">
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
          <a href="anggota">&laquo; Kembali ke data anggota</a>
        </div>
      </div>
    </div>
  </div>


</section>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let dataanggota = '';
  let dataunit = '';
  let datarestoreunit = '';
  let datarestoreanggota = '';

  function viewdtcontrol(index, data) {
    // Add event listener for opening and closing details
    $(`${index} tbody`).on('click', 'td.dt-control', function() {
      var tr = $(this).closest('tr');
      var row = data.row(tr);

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
  }

  $(document).ready(function() {
    $('.viewform').hide();
    $('.btn-datarestoreunit').hide();
    $('.btn-datarestoreanggota').hide();

    dataanggota = $('#table-anggota').DataTable({
      processing: true,
      serverSide: true,
      ajax: `<?= $nav . '/listdataanggota' ?>`,
      order: [],
      columns: [{
          data: 'checkRowAnggota',
          orderable: false,
          searchable: false,
        }, {
          className: 'dt-control',
          orderable: false,
          sortable: false,
          data: null,
          defaultContent: '',
          searchable: false,
        },
        {
          data: 'nama_anggota'
        },
        {
          data: 'no_anggota',
        },
        {
          data: 'singkatan',
        },
        {
          data: 'action',
          orderable: false
        },
      ],
    });

    $('#btn-restoreanggota').on('click', function(e) {
      e.preventDefault;
      $('.table-anggota').hide(500);
      $('.viewform').hide();
      $('.table-restoreanggota').show(500);
      $('.datalist-anggota h4').html('Restore Data anggota');
      $('.btn-dataanggota').hide();
      $('.btn-datarestoreanggota').show();
      datarestoreanggota = $('#table-restoreanggota').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= $nav . '/listdataanggota?isRestore=1' ?>',
        },
        order: [],
        columns: [{
            className: 'dt-control',
            orderable: false,
            sortable: false,
            data: null,
            defaultContent: '',
            searchable: false,
          },
          {
            data: 'nama_anggota'
          },
          {
            data: 'no_anggota',
          },
          {
            data: 'singkatan',
          },
          {
            data: 'deleted_at'
          },
          {
            data: 'deleted_by'
          },
          {
            data: 'action',
            orderable: false
          },
        ]
      });

      viewdtcontrol('#table-restoreanggota', datarestoreanggota);
    });

    viewdtcontrol('#table-anggota', dataanggota);

    dataunit = $('#table-unit').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '<?= $nav . '/listdataunit?isRestore=0' ?>',
      },
      order: [],
      columns: [{
          data: 'checkRowUnit',
          orderable: false,
          searchable: false,
        },
        {
          className: 'dt-control',
          orderable: false,
          sortable: false,
          data: null,
          defaultContent: '',
          searchable: false,
        },
        {
          data: 'nama_unit'
        },
        {
          data: 'singkatan'
        },
        {
          data: 'action',
          orderable: false
        },
      ]
    });

    $('#btn-restoreunit').on('click', function(e) {
      e.preventDefault;
      $('.table-unit').hide(500);
      $('.viewform').hide();
      $('.table-restoreunit').show(500);
      $('.datalist-unit h4').html('Restore Data Unit');
      $('.btn-dataunit').hide();
      $('.btn-datarestoreunit').show();
      datarestoreunit = $('#table-restoreunit').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= $nav . '/listdataunit?isRestore=1' ?>',
        },
        order: [],
        columns: [{
            className: 'dt-control',
            orderable: false,
            sortable: false,
            data: null,
            defaultContent: '',
            searchable: false,
          },
          {
            data: 'nama_unit'
          },
          {
            data: 'singkatan'
          },
          {
            data: 'deleted_by'
          },
          {
            data: 'deleted_at'
          },
          {
            data: 'action',
            orderable: false
          },
        ]
      });

      viewdtcontrol('#table-restoreunit', datarestoreunit);
    });

    viewdtcontrol('#table-unit', dataunit);

    $('#btn-tambahunit').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= $nav . '/singleformunit' ?>",
        data: {
          nav: "<?= $nav ?>",
          saveMethod: "add",
        },
        dataType: "json",
        success: function(response) {
          $('.viewform').show().html(response.data);
        }
      });
    })
    $('#btn-tambahanggota').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= $nav . '/singleformanggota' ?>",
        data: {
          nav: "<?= $nav ?>",
          saveMethod: "add",
        },
        dataType: "json",
        success: function(response) {
          $('.viewform').show().html(response.data);
        }
      });
    })

    // Check All Unit
    $('#checkAllUnit').click(function() {
      if ($(this).is(':checked')) {
        $('.checkRowUnit').prop('checked', true);
      } else {
        $('.checkRowUnit').prop('checked', false);
      }
    })
    // Check Row
    $('.checkRowUnit').click(function() {
      var allChecked = true;
      $('.checkRowUnit').each(function() {
        if (!$(this).is(':checked')) {
          allChecked = false;
        }
      });
      if (allChecked) {
        $('#checkAllUnit').prop('checked', true);
      } else {
        $('#checkAllUnit').prop('checked', false);
      }
    });

    // Check All Anggota
    $('#checkAllAnggota').click(function() {
      if ($(this).is(':checked')) {
        $('.checkRowAnggota').prop('checked', true);
      } else {
        $('.checkRowAnggota').prop('checked', false);
      }
    })
    // Check Row
    $('.checkRowAnggota').click(function() {
      var allChecked = true;
      $('.checkRowAnggota').each(function() {
        if (!$(this).is(':checked')) {
          allChecked = false;
        }
      });
      if (allChecked) {
        $('#checkAllAnggota').prop('checked', true);
      } else {
        $('#checkAllAnggota').prop('checked', false);
      }
    });

    //Temporary delete
    $('#formDeleteUnit').submit(function(e) {
      e.preventDefault();

      let jmldata = $('.checkRowUnit:checked');
      var formdata = new FormData(this);

      if (jmldata.length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Maaf silahkan pilih data unit yang mau dihapus'
        })
      } else {
        Swal.fire({
          title: 'Multiple Delete',
          text: `Apakah kamu yakin ingin menghapus ${jmldata.length} data unit secara temporary?`,
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
              url: `<?= $nav ?>/multipledeleteunit`,
              data: formdata,
              processData: false,
              contentType: false,
              success: function(result) {
                var response = JSON.parse(result);
                if (response.sukses) {
                  Swal.fire(
                    'Berhasil', response.sukses, 'success'
                  ).then((result) => {
                    dataunit.ajax.reload();
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
              }
            });
          } else {
            Swal.fire(
              'Gagal', 'Tidak ada data unit yang dihapus', 'info'
            )
          }
        });
      }

      return false;
    })
    //Temporary delete
    $('#formDeleteAnggota').submit(function(e) {
      e.preventDefault();

      let jmldata = $('.checkRowAnggota:checked');
      var formdata = new FormData(this);

      if (jmldata.length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Maaf silahkan pilih data anggota yang mau dihapus'
        })
      } else {
        Swal.fire({
          title: 'Multiple Delete',
          text: `Apakah kamu yakin ingin menghapus ${jmldata.length} data anggota secara temporary?`,
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
              url: `<?= $nav ?>/multipledeleteanggota`,
              data: formdata,
              processData: false,
              contentType: false,
              success: function(result) {
                var response = JSON.parse(result);
                if (response.sukses) {
                  Swal.fire(
                    'Berhasil', response.sukses, 'success'
                  ).then((result) => {
                    dataanggota.ajax.reload();
                  })
                }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
              }
            });
          } else {
            Swal.fire(
              'Gagal', 'Tidak ada data anggota yang dihapus', 'info'
            )
          }
        });
      }

      return false;
    })
  });

  function format(d) {
    var created_at = d.created_at;
    var dateParts = created_at.split(/[- :]/);
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
    // return formattedDate;

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

  function editunit(id) {
    $.ajax({
      type: "get",
      url: "<?= $nav . '/singleformunit' ?>",
      data: {
        nav: "<?= $nav ?>",
        saveMethod: "update",
        globalId: id,
      },
      dataType: "json",
      success: function(response) {
        $('.viewform').show().html(response.data);
      }
    });
  }

  function editanggota(id) {
    $.ajax({
      type: "get",
      url: "<?= $nav . '/singleformanggota' ?>",
      data: {
        nav: "<?= $nav ?>",
        saveMethod: "update",
        globalId: id,
      },
      dataType: "json",
      success: function(response) {
        $('.viewform').show().html(response.data);
      }
    });
  }

  function hapusunit(id, namaunit) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namaunit}?`,
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
          url: "<?= $nav ?>/hapusunit/" + id,
          data: {
            nama_unit: namaunit
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                dataunit.ajax.reload();
                dataanggota.ajax.reload();
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

  function restoreunit(id, namaunit) {
    Swal.fire({
      title: `Memulihkan data ${namaunit}?`,
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
          url: "<?= $nav ?>/restoreunit",
          data: {
            id: id,
            nama_unit: namaunit,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestoreunit.ajax.reload();
                dataanggota.ajax.reload();
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

  function restoreallunit() {
    var api = $('#table-restoreunit').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var unit = api.data().toArray().map(function(d) {
      return d.unit;
    });
    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data unit yang dapat dipulihkan',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data unit yang telah terhapus?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        restore(id.toString(), nama_unit.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data unit yang telah terhapus?`,
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
            url: "<?= $nav ?>/restoreunit",
            data: {
              id: id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  datarestoreunit.ajax.reload();
                  dataanggota.ajax.reload();
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

  function hapusanggota(id, namaanggota) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namaanggota}?`,
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
          url: "<?= $nav ?>/hapusanggota/" + id,
          data: {
            nama_anggota: namaanggota
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                dataanggota.ajax.reload();
                dataanggota.ajax.reload();
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

  function restoreanggota(id, namaanggota) {
    Swal.fire({
      title: `Memulihkan data ${namaanggota}?`,
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
          url: "<?= $nav ?>/restoreanggota",
          data: {
            id: id,
            nama_anggota: namaanggota,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestoreanggota.ajax.reload();
                dataanggota.ajax.reload();
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

  function restoreallanggota() {
    var api = $('#table-restoreanggota').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var anggota = api.data().toArray().map(function(d) {
      return d.anggota;
    });
    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data anggota yang dapat dipulihkan',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data anggota yang telah terhapus?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        restore(id.toString(), nama_anggota.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        title: `Apakah anda ingin memulihkan semua data anggota yang telah terhapus?`,
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
            url: "<?= $nav ?>/restoreanggota",
            data: {
              id: id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  datarestoreanggota.ajax.reload();
                  dataanggota.ajax.reload();
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

  function hapuspermanenunit(id, namaunit) {
    Swal.fire({
      width: 700,
      title: `Menghapus data ${namaunit} secara permanen?`,
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
          url: "<?= $nav ?>/hapuspermanenunit",
          data: {
            id: id,
            nama_unit: namaunit,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestoreunit.ajax.reload();
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
            Swal.fire(
              'Error!',
              xhr.status + " + " + xhr.responseText + " + " + thrownError,
              'error'
            );
          }
        });
      }
    });
  }

  function hapuspermanenanggota(id, namaanggota) {
    Swal.fire({
      width: 700,
      title: `Menghapus data ${namaanggota} secara permanen?`,
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
          url: "<?= $nav ?>/hapuspermanenanggota",
          data: {
            id: id,
            nama_anggota: namaanggota,
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                datarestoreanggota.ajax.reload();
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

  function hapuspermanenallunit() {
    var api = $('#table-restoreunit').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var nama_unit = api.data().toArray().map(function(d) {
      return d.nama_unit;
    })

    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data unit yang dapat dihapus secara permanen',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data unit secara permanen?`,
        icon: 'warning',
        text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        hapuspermanenunit(id.toString(), nama_unit.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data unit secara permanen?`,
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
            url: "<?= $nav ?>/hapuspermanenunit",
            data: {
              id: id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  datarestoreunit.ajax.reload();
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

  function hapuspermanenallanggota() {
    var api = $('#table-restoreanggota').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
      return d.id;
    });
    var nama_anggota = api.data().toArray().map(function(d) {
      return d.nama_anggota;
    })

    if (api.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data anggota yang dapat dihapus secara permanen',
        'error'
      );
    } else if (api.count() === 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data anggota secara permanen?`,
        icon: 'warning',
        text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
      }).then((result) => {
        hapuspermanenanggota(id.toString(), nama_anggota.toString());
      });
    } else if (api.count() > 1) {
      Swal.fire({
        width: 700,
        title: `Bersihkan semua data anggota secara permanen?`,
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
            url: "<?= $nav ?>/hapuspermanenanggota",
            data: {
              id: id.join(","),
            },
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  datarestoreanggota.ajax.reload();
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