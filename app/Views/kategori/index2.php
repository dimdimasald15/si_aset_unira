<?php

use CodeIgniter\Database\BaseUtils;
?>
<?= $this->extend('/layouts/template'); ?>

<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar Kategori</h3>
        <p class="text-subtitle text-muted">Kelola menu kategori di Universitas Islam Raden Rahmat Malang</p>
      </div>
      <div class="col-12 col-md-4 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Kategori</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card mb-3" id="tampilformtambahkategori" style="display:none">
      <div class="card-header">
        <div class="row">
          <h4 class="card-title">Tambah Data Kategori</h4>
        </div>
      </div>
      <div class="card-body">
        <form class="form form-vertical" id="formTambahKategori">
          <?= csrf_field() ?>
          <div class="form-body">
            <div class="row">
              <div class="col-12">
                <input type="hidden" name="id" id="id">
                <div class="row mb-1">
                  <label for="kd_kat">Kode Kategori</label>
                </div>
                <div class="row mb-1 d-flex">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-code-square"></i></span>
                    <select class="form-select" id="subkode1">
                    </select>
                    <input type="text" class="form-control" placeholder="" id="subkode1-other" style="display: none;">
                    <label class="input-group-text" for="subkode2">.</label>
                    <select class="form-select" id="subkode2">
                    </select>
                    <input type="text" class="form-control" placeholder="" id="subkode2-other" style="display: none;">
                    <label class="input-group-text" for="subkode3">.</label>
                    <select class="form-select" id="subkode3">
                    </select>
                    <input type="text" class="form-control" placeholder="" id="subkode3-other" style="display: none;">
                    <label class="input-group-text" for="subkode4">.</label>
                    <select class="form-select" id="subkode4">
                    </select>
                    <input type="text" class="form-control" placeholder="" id="subkode4-other" style="display: none;">
                    <div class="invalid-feedback errkdkat"></div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="" id="kd_kategori" name="kd_kategori" readonly>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="namakategori">Nama Kategori</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                    <input type="text" class="form-control" placeholder="Nama Kategori" id="namakategori" name="nama_kategori">
                    <div class="invalid-feedback errnamakategori"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="deskripsi">Deskripsi</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-info-circle"></i></span>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" name="deskripsi"></textarea>
                    <div class="invalid-feedback errdeskripsi"></div>
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
</div>
<div class="card mb-3 datalist-kategori">
  <div class="card-header">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-9">
        <h4 class="card-title">Data Kategori</h4>
      </div>
      <div class="col-lg-3 d-flex flex-row-reverse">
        <button type="button" class="btn btn-success" id="btn-tambahkategori">
          <i class="bi bi-layers"></i>
          Tambah Kategori
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive py-4">
      <table class="table table-flush" id="table-kategori" width="100%">
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

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let formtambah = $('#tampilformtambahkategori');
  let saveMethod, globalId;

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").empty()
  }

  // function clear_is_invalid() {
  //   if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
  //     formtambah.find('input').removeClass('is-invalid');
  //     formtambah.find('select').removeClass('is-invalid');
  //     $('.form-control-icon').css("transform", "translate(0,-15px)");
  //   }
  // }
  function inputnamakategori(subkd1, subkd2, subkd3, subkd4) {
    // periksa apakah nilai undefined
    subkd1 = (typeof subkd1 !== 'undefined' && subkd1 !== 'other1') ? subkd1 : '';
    subkd2 = (typeof subkd2 !== 'undefined' || subkd2 !== 'other2') ? subkd2 : '';
    subkd3 = (typeof subkd3 !== 'undefined' || subkd3 !== 'other3') ? subkd3 : '';
    subkd4 = (typeof subkd4 !== 'undefined' || subkd4 !== 'other4') ? subkd4 : '';
    // kode = '';
    if (subkd2 == undefined || subkd3 == undefined || subkd4 == undefined) {
      $('#kd_kategori').val(`${subkd1}`)
    } else if (subkd3 == undefined || subkd4 == undefined) {
      $('#kd_kategori').val(`${subkd1}.${subkd2}`)
    } else if (subkd4 == undefined) {
      $('#kd_kategori').val(`${subkd1}.${subkd2}.${subkd3}`)
    } else {
      $('#kd_kategori').val(`${subkd1}.${subkd2}.${subkd3}.${subkd4}`)
    }

    $.ajax({
      type: "post",
      url: "<?= base_url('kategoricontroller/getnamakategori') ?>",
      data: {
        subkode1: subkd1,
        subkode2: subkd2,
        subkode3: subkd3,
        subkode4: subkd4,
      },
      dataType: "json",
      success: function(response) {
        // console.log('nama kategori dan deskripsi');
        // console.log(response.nama_kategori);
        if (response != null) {
          $('#namakategori').val(response.nama_kategori)
          $('#deskripsi').val(response.deskripsi)
        } else {
          $('#namakategori').val('')
          $('#deskripsi').val('')

        }
      }
    });
  }

  var subkd1other = '',
    subkd2other = '',
    subkd3other = '',
    subkd4other = '';

  function getsubkodeother(skother1, skother2, skother3, skother4) {
    console.log(skother1 + '<br>' + skother2 + '<br>' + skother3 + '<br>' + skother4)
    subkd1other = (typeof skother1 !== 'undefined') ? skother1 : '';
    subkd2other = (typeof skother2 !== 'undefined') ? skother2 : '';
    subkd3other = (typeof skother3 !== 'undefined') ? skother3 : '';
    subkd4other = (typeof skother4 !== 'undefined') ? skother3 : '';
    if (subkd2other == '' || subkd3other == '' || subkd4other == '') {
      $('#kd_kategori').val(`${subkd1other}`)
    } else if (subkd3other == '' || subkd4other == '') {
      $('#kd_kategori').val(`${subkd1other}.${subkd2other}`)
    } else if (subkd4other == '') {
      $('#kd_kategori').val(`${subkd1other}.${subkd2other}.${subkd3other}`)
    } else {
      $('#kd_kategori').val(`${subkd1other}.${subkd2other}.${subkd3other}.${subkd4other}`)
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data Ruangan');
    formtambah.find("button[type='submit']").html('Simpan');
  }



  $('.batal-form').click(function(e) {
    e.preventDefault();
    // clear_is_invalid();
    clearForm();
    formtambah.hide(500);
  });

  $(document).ready(function() {
    // console.log('test');
    formtambah.hide();
    var datakategori = $('#table-kategori').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'kategori/listdatakategori',
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
          data: 'deskripsi'
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


    let subkode1, subkode2, subkode3, subkode4;


    $('#btn-tambahkategori').click(function(e) {
      e.preventDefault();
      // clear_is_invalid();
      defaultform();
      clearForm();
      formtambah.show(500);
      saveMethod = "add";

      $.ajax({
        url: "<?= site_url('kategoricontroller/getsubkode1') ?>",
        type: "GET",
        dataType: "json",
        success: function(result) {
          // console.log(result);
          $('#subkode1').empty();
          $('#subkode1').append('<option value="">SubKode 1</option>');
          $.each(result, function(key, value) {
            $('#subkode1').append('<option value="' + value.kode + '">' + value.kode + '</option>');
          });
          $('#subkode1').append('<option value="other1">Lainnya</option>');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })


    // let subkd1other;

    // function myCallback(subkd1other) {
    //   console.log('subkode1 other = ' + subkd1other);
    // }


    $('#subkode1').on('change', function() {
      subkode1 = $('#subkode1').val();
      if (subkode1 === 'other1') {
        $('#subkode1-other').show();
        $('#subkode1-other').on('keyup', function() {
          getsubkodeother($('#subkode1-other').val());
        });
      } else {
        $('#subkode1-other').hide();
      }


      inputnamakategori(subkode1);

      $.ajax({
        type: "post",
        url: "<?= site_url('kategoricontroller/getsubkode2') ?>",
        data: {
          subkode1: subkode1,
        },
        dataType: "json",
        success: function(result) {
          // console.log(result);
          $('#subkode2').empty();
          $('#subkode2').append('<option value="">SubKode 2</option>');
          $.each(result, function(key, value) {
            $('#subkode2').append('<option value="' + value.subkode2 + '">' + value.subkode2 + '</option>');
          });
          $('#subkode2').append('<option value="other2">Lainnya</option>');

        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });

    $('#subkode2').on('change', function() {
      // console.log('subkode 1 diddalam subkode2 =' + subkode1);
      subkode2 = $('#subkode2').val();
      if (subkode2 === 'other2') {
        $('#subkode2-other').show();
        $('#subkode1-other').on('keyup', function() {
          // getsubkodeother($('#subkode1-other').val());
          getsubkodeother($('#subkode1-other').val(), $('#subkode2-other').val());
          console.log($('#subkode2-other').val());
        });

      } else {
        $('#subkode2-other').hide();
      }
      inputnamakategori(subkode1, subkode2);


      $.ajax({
        type: "post",
        url: "<?= site_url('kategoricontroller/getsubkode3') ?>",
        data: {
          subkode1: subkode1,
          subkode2: subkode2,
        },
        dataType: "json",
        success: function(result) {
          $('#subkode3').empty();
          $('#subkode3').append('<option value="">SubKode 3</option>');
          // console.log(result);
          for (var i = 0; i < result.length; i++) {
            if (result[i].subkode3 != '') {
              $('#subkode3').append('<option value="' + result[i].subkode3 + '">' + result[i].subkode3 + '</option>');
            }
          }

          $('#subkode3').append('<option value="other3">Lainnya</option>');

        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });

    $('#subkode3').on('change', function() {
      subkode3 = $('#subkode3').val();
      console.log('subkode di dalam subkode3 =' + subkode1 + '.' + subkode2 + '.' + subkode3);

      if (subkode3 === 'other3') {
        $('#subkode3-other').show(); // menampilkan form input
      } else {
        $('#subkode3-other').hide(); // menyembunyikan form input
      }

      inputnamakategori(subkode1, subkode2, subkode3);


      $.ajax({
        type: "post",
        url: "<?= site_url('kategoricontroller/getsubkode4') ?>",
        data: {
          subkode1: subkode1,
          subkode2: subkode2,
          subkode3: subkode3,
        },
        dataType: "json",
        success: function(result) {
          console.log(result);
          $('#subkode4').empty();
          $('#subkode4').append('<option value="">SubKode 4</option>');
          $.each(result, function(key, value) {
            $('#subkode4').append('<option value="' + value.subkode4 + '">' + value.subkode4 + '</option>');
          });
          $('#subkode4').append('<option value="other4">Lainnya</option>');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    });
    // console.log($('#subkode4').val());
    $('#subkode4').on('change', function() {
      subkode4 = $('#subkode4').val();
      // console.log('subkode di dalam subkode4 =' + subkode1 + '.' + subkode2 + '.' + subkode3 + '.' + subkode4);
      if (subkode4 === 'other4') {
        $('#subkode4-other').show(); // menampilkan form input
      } else {
        $('#subkode4-other').hide(); // menyembunyikan form input
      }

      inputnamakategori(subkode1, subkode2, subkode3, subkode4);
    });

  });
</script>
<?= $this->endSection() ?>