<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar Ruangan</h3>
        <p class="text-subtitle text-muted">Kelola menu ruangan di Universitas Islam Raden Rahmat Malang</p>
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
  <div class="card shadow mb-3" id="tampilformtambah" style="display:none">
    <div class="card-header shadow-sm">
      <div class="row">
        <h4 class="card-title">Tambah Data Ruangan</h4>
      </div>
    </div>
    <div class="card-body">
      <form class="form form-vertical" id="formTambah">
        <?= csrf_field() ?>
        <div class="form-body">
          <div class="row">
            <div class="col-12">
              <input type="hidden" name="id" id="id">
              <!-- <div class="form-group has-icon-left"> -->
              <div class="row mb-1">
                <label for="namaruang">Nama Ruang</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-door-closed"></i></span>
                  <input type="text" class="form-control" placeholder="Nama ruang" id="namaruang" name="nama_ruang">
                  <div class="invalid-feedback errnamaruang"></div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="row mb-1">
                <label for="namalantai mb-2">Nama Lantai</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                  <select name="nama_lantai" class="form-select" placeholder="Nama lantai" id="namalantai">
                    <option value="" selected>Pilih Lantai</option>
                    <option value="1">Lantai 1</option>
                    <option value="2">Lantai 2</option>
                    <option value="3">Lantai 3</option>
                  </select>
                  <div class="invalid-feedback errnamalantai"></div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="row mb-1">
                <label for="namagedung mb-2">Nama Gedung</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-building"></i></label>
                  <select class="form-select" name="gedung_id" id="namagedung">
                    <option value="" selected>Pilih Gedung</option>
                    <option value="1">Gedung KH KH. Mahmud Zubaidi (A)</option>
                    <option value="2">Gedung KH. M. Tolchah Hasan (B)</option>
                    <option value="3">Gedung KH. M. Tolchah Hasan (C)</option>
                  </select>
                  <div class="invalid-feedback errnamagedung"></div>
                </div>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button type="button" class="btn btn-white my-4 batal-form">Batal</button>
              <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow mb-3 datalist-ruangan">
    <div class="card-header shadow-sm">
      <div class="row justify-content-between align-items-center">
        <div class="col-lg-7">
          <h4 class="card-title">Data Ruangan</h4>
        </div>
        <div class="col-lg-5 d-flex flex-row justify-content-end">
          <div class="col-lg-auto btn-dataruang">
            <button type="button" class="btn btn-success" id="btn-tambahruang">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"></path>
                <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"></path>
              </svg>
              Tambah Ruangan
            </button>
            <button type="button" class="btn btn-danger" id="btn-restore"><i class="fa fa-trash-o"></i> Trash</button>
          </div>
          <div class="col-lg-auto btn-datarestoreruang" style="display:none;">
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
              <th>Nama Ruangan</th>
              <th>Nama Lantai</th>
              <th>Prefix Gedung</th>
              <th>Nama Gedung</th>
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
    <div class="card-body table-ruang">
      <div class="table-responsive py-4">
        <table class="table table-flush" id="table-ruang" width="100%">
          <thead class=" thead-light">
            <tr>
              <th>No.</th>
              <th>Nama Ruangan</th>
              <th>Nama Lantai</th>
              <th>Prefix Gedung</th>
              <th>Nama Gedung</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row m-2 btn-datarestoreruang" style="display:none;">
      <a href="ruang">&laquo; Kembali ke data ruangan</a>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  let formtambah = $('#tampilformtambah');
  let saveMethod, globalId;
  var datarestore = '';
  var dataruang = '';

  function edit(id) {
    clear_is_invalid();
    formtambah.show(500);
    saveMethod = "update";
    globalId = id;

    formtambah.find('.card-title').html('Edit Data Ruangan');
    formtambah.find("button[type='submit']").html('Perbarui');

    $.ajax({
      type: "get",
      url: "<?= site_url('ruangcontroller/get_ruang_by_id/') ?>" + id,
      dataType: "json",
      success: function(response) {
        isiForm(response);
      }
    });
  }

  function isiForm({
    id,
    nama_ruang,
    nama_lantai,
    nama_gedung,
    gedung_id
  }) {
    formtambah.find("input[name='id']").val(id)
    formtambah.find("input[name='nama_ruang']").val(nama_ruang)
    formtambah.find("select[name='nama_lantai']").val(nama_lantai)
    formtambah.find("select[name='gedung_id']").val(gedung_id)
  }

  function hapus(id, namaruang) {
    Swal.fire({
      title: `Apakah kamu yakin ingin menghapus data ${namaruang}?`,
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
          url: "ruang/hapus/" + id,
          data: {
            nama_ruang: namaruang
          },
          dataType: 'json',
          success: function(response) {
            if (response.sukses) {
              Swal.fire(
                'Berhasil', response.sukses, 'success'
              ).then((result) => {
                dataruang.ajax.reload();
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

  function restore(id, namaruang) {
    Swal.fire({
      title: `Memulihkan data ${namaruang}?`,
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
          url: "ruang/restore/" + id,
          data: {
            nama_ruang: namaruang
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

  function restoreall() {
    var jumlahbaris = $('#table-restore').DataTable().rows();
    if (jumlahbaris.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data ruangan yang dapat dipulihkan',
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
            // type: "post",
            url: "ruang/restore",
            dataType: 'json',
            success: function(response) {
              if (response.sukses) {
                Swal.fire(
                  'Berhasil', response.sukses, 'success'
                ).then((result) => {
                  location.reload();
                })
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

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").val("")
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data Ruangan');
    formtambah.find("button[type='submit']").html('Simpan');
  }

  function defaultshow() {
    formtambah.hide();
    $('.datalist-ruangan h4').html('Data Ruangan');
    $('.btn-dataruang').show();
    $('.btn-datarestoreruang').hide();
  }

  $(document).ready(function() {
    dataruang = $('#table-ruang').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'ruang/tampildataruang?isRestore=0',
      },
      order: [],
      columns: [{
          data: 'no',
          orderable: false
        },
        {
          data: 'nama_ruang'
        },
        {
          data: 'nama_lantai'
        },
        {
          data: 'prefix'
        },
        {
          data: 'nama_gedung'
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
    // $('.paginate_button.page-item').addClass('btn btn-success');

    defaultshow();

    $('#btn-tambahruang').click(function() {
      clear_is_invalid();
      defaultform();
      clearForm();
      formtambah.show(500);
      saveMethod = "add";
    });

    $(".batal-form").click(function(e) {
      clear_is_invalid();
      formtambah.hide(500);
    })

    // simpan data ruang
    $('#formTambah').submit(function(e) {
      e.preventDefault();
      let url = "";
      if (saveMethod == "update") {
        url = "ruang/update/" + globalId;
      } else if (saveMethod == "add") {
        url = "ruang/simpan";
      }
      $.ajax({
        type: 'post',
        url: url,
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Simpan');
        },
        success: function(response) {
          if (response.error) {
            if (response.error.namaruang) {
              $('#namaruang').addClass('is-invalid');
              $('.errnamaruang').html(response.error.namaruang);
            } else {
              $('#namaruang').removeClass('is-invalid');
              $('.errnamaruang').html('');
            }
            if (response.error.namalantai) {
              $('#namalantai').addClass('is-invalid');
              $('.errnamalantai').html(response.error.namalantai);
            } else {
              $('#namalantai').removeClass('is-invalid');
              $('.errnamalantai').html('');
            }
            if (response.error.gedungid) {
              $('#namagedung').addClass('is-invalid');
              $('.errnamagedung').html(response.error.gedungid);
            } else {
              $('#namagedung').removeClass('is-invalid');
              $('.errnamagedung').html('');
            }
          } else {
            formtambah.hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              dataruang.ajax.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });

      return false;
    })

    $('#namaruang').on('input', function() {
      if ($(this).val().trim() !== '') {
        $(this).removeClass('is-invalid');
        $('.errnamaruang').html('');
      }
    });

    $('#namalantai').on('change', function() {
      if ($(this).val() !== '') {
        $(this).removeClass('is-invalid');
        $('.errnamalantai').html('');
      }
    });
    $('#namagedung').on('change', function() {
      if ($(this).val() !== '') {
        $(this).removeClass('is-invalid');
        $('.errnamagedung').html('');
      }
    });

    $('#btn-restore').on('click', function() {
      $('.table-ruang').hide();
      $('.table-restore').show();
      $('.datalist-ruangan h4').html('Restore Data Ruangan');
      formtambah.hide();
      $('.btn-dataruang').hide();
      $('.btn-datarestoreruang').show();
      datarestore = $('#table-restore').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: 'ruang/tampildatarestore?isRestore=1',
        },
        order: [],
        columns: [{
            data: 'no',
            orderable: false
          },
          {
            data: 'nama_ruang'
          },
          {
            data: 'nama_lantai'
          },
          {
            data: 'prefix'
          },
          {
            data: 'nama_gedung'
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
  });


  function hapuspermanen(id, namaruang) {
    Swal.fire({
      title: `Menghapus data ${namaruang} secara permanen?`,
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
          url: "ruang/hapuspermanen/" + id,
          data: {
            nama_ruang: namaruang
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
    var jumlahbaris = $('#table-restore').DataTable().rows();
    if (jumlahbaris.count() === 0) { // jika tidak ada data
      Swal.fire(
        'Gagal!',
        'Tidak ada data ruangan yang dapat dihapus secara permanen',
        'error'
      );
    } else {
      Swal.fire({
        title: `Bersihkan semua data secara permanen?`,
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
            url: "ruang/hapuspermanen",
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