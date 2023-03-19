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
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Ruang</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card mb-3" id="tampilformtambah" style="display:none">
      <div class="card-header">
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
                <div class="form-group has-icon-left">
                  <label for="nama_ruang mb-2">Nama Ruangan</label>
                  <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Nama ruang" id="namaruang" name="nama_ruang">
                    <div class="form-control-icon position-absolute top-50 start-0">
                      <i class="bi bi-door-closed"></i>
                    </div>
                    <!-- <div class="text-danger mt-2" id="err-ceknamaruang">
                    </div> -->
                    <div class="invalid-feedback errnamaruang"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="nama-lantai mb-2">Nama Lantai</label>
                  <div class="position-relative">
                    <select name="nama_lantai" class="form-select" placeholder="Nama lantai" style="padding-left: 2.6rem !important;" id="namalantai">
                      <option value="" selected>Pilih Lantai</option>
                      <option value="1">Lantai 1</option>
                      <option value="2">Lantai 2</option>
                      <option value="3">Lantai 3</option>
                    </select>
                    <div class="form-control-icon">
                      <i class="bi bi-layers"></i>
                    </div>
                    <div class="invalid-feedback errnamalantai"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="nama-gedung mb-2">Nama Gedung</label>
                  <div class="position-relative">
                    <select class="form-select" style="padding-left: 2.6rem !important;" name="gedung_id" id="namagedung">
                      <option value="" selected>Pilih Gedung</option>
                      <option value="1">Gedung KH KH. Mahmud Zubaidi (A)</option>
                      <option value="2">Gedung KH. M. Tolchah Hasan (B)</option>
                      <option value="3">Gedung KH. M. Tolchah Hasan (C)</option>
                    </select>
                    <div class="form-control-icon">
                      <i class="bi bi-building"></i>
                    </div>
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
  </section>
</div>
<div class="card mb-3 datalist-ruangan">
  <div class="card-header">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-9">
        <h4 class="card-title">Data Ruangan</h4>
      </div>
      <div class="col-lg-3 d-flex flex-row-reverse">
        <button type="button" class="btn btn-success" id="btn-tambahruang">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
            <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"></path>
            <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"></path>
          </svg>
          Tambah Ruangan
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive py-4">
      <table class="table table-flush" id="table-ruang" width="100%">
        <thead class=" thead-light">
          <tr>
            <!-- <th style="width: 50px;">No.</th> -->
            <th>No.</th>
            <th>Nama Ruangan</th>
            <th>Nama Lantai</th>
            <th>Prefix Gedung</th>
            <th>Nama Gedung</th>
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
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
  let formtambah = $('#tampilformtambah');
  let saveMethod, globalId;

  function edit(id) {
    console.log('edit :' + id);
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
        console.log(response);
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
    console.log(id + " & " + namaruang);
    // console.log('delete : ' + namaruang);
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

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").val("")
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
      $('.form-control-icon').css("transform", "translate(0,-15px)");
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data Ruangan');
    formtambah.find("button[type='submit']").html('Simpan');
  }

  $(document).ready(function() {
    // console.log('awal : ' + formtambah.find('input').hasClass('is-invalid'));
    // listdataruang();
    var dataruang = $('#table-ruang').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'ruang/tampildataruang',
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
          data: 'created_at'
        },
        {
          data: 'action',
          orderable: false
        },
      ]
    });

    formtambah.hide();

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
          $('.form-control-icon').css("transform", "translate(0,-27px)");
        },
        success: function(response) {
          console.log(response);
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
              $('.form-control-icon').css("transform", "translate(0,-15px)");
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });

      return false;
    })

  });
</script>
<?= $this->endSection() ?>