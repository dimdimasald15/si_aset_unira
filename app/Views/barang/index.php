<?= $this->extend('/layouts/template'); ?>
<?= $this->section('content') ?>
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-8 order-md-1 order-last">
        <h3>Daftar Barang</h3>
        <p class="text-subtitle text-muted">Kelola menu barang di Universitas Islam Raden Rahmat Malang</p>
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
  <section class="section">
    <div class="card mb-3" id="tampilformtambahbarang" style="display:none">
      <div class="card-header">
        <div class="row">
          <h4 class="card-title">Tambah Data Barang</h4>
        </div>
      </div>
      <div class="card-body">
        <form class="form form-vertical" id="formTambahBarang">
          <?= csrf_field() ?>
          <div class="form-body">
            <div class="col-12">
              <div class="row mb-1">
                <label for="katid mb-2">Nama Kategori</label>
              </div>
              <div class="row mb-1">
                <div class="input-group mb-3">
                  <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                  <select name="kat_id" class="form-select p-2" id="katid" style="width: 400px;"></select>
                  <div class="invalid-feedback errkatid"></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <input type="hidden" name="id" id="id">
                <div class="row mb-1">
                  <label for="namabarang">Nama Barang</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
                    <input type="text" class="form-control" placeholder="Nama barang" id="namabarang" name="nama_brg">
                    <div class="invalid-feedback errnamabarang"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="prefix">Nama Singkat Gedung (Prefix)</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-arrow-down-left-square"></i></span>
                    <input type="text" class="form-control" placeholder="Nama Singkat Gedung" id="prefix" name="prefix">
                    <div class="invalid-feedback errprefix"></div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row mb-1">
                  <label for="katid mb-2">Nama Kategori</label>
                </div>
                <div class="row mb-1">
                  <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
                    <!-- <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span> -->
                    <select name="kat_id" class="form-select p-2" id="katid" style="width: 400px;"></select>
                    <div class="invalid-feedback errkatid"></div>
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
<div class="card mb-3 datalist-barang">
  <div class="card-header">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-9">
        <h4 class="card-title">Data Barang</h4>
      </div>
      <div class="col-lg-3 d-flex flex-row-reverse">
        <button type="button" class="btn btn-success" id="btn-tambahbarang">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
            <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"></path>
          </svg>
          Tambah Barang
        </button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive py-4">
      <table class="table table-flush" id="table-barang" width="100%">
        <thead class=" thead-light">
          <tr>
            <!-- <th style="width: 50px;">No.</th> -->
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok Barang</th>
            <th>Harga Beli</th>
            <th>Kondisi</th>
            <th>Lokasi</th>
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
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  let formtambah = $('#tampilformtambahbarang');
  let saveMethod, globalId;

  // function edit(id) {
  //   // console.log('edit :' + id);
  //   clear_is_invalid();
  //   formtambah.show(500);
  //   saveMethod = "update";
  //   globalId = id;

  //   formtambah.find('.card-title').html('Edit Data Gedung');
  //   formtambah.find("button[type='submit']").html('Perbarui');

  //   $.ajax({
  //     type: "get",
  //     url: "<?= site_url('gedungcontroller/get_gedung_by_id/') ?>" + id,
  //     dataType: "json",
  //     success: function(response) {
  //       console.log(response);
  //       isiForm(response);
  //     }
  //   });
  // }

  // function isiForm({
  //   id,
  //   nama_gedung,
  //   prefix,
  //   kat_id,
  //   nama_kategori
  // }) {
  //   formtambah.find("input[name='id']").val(id)
  //   formtambah.find("input[name='nama_gedung']").val(nama_gedung)
  //   formtambah.find("input[name='prefix']").val(prefix)
  //   formtambah.find("select[name*='kat_id']").html('<option value = "' + kat_id + '" selected >' + nama_kategori + '</option>');

  // }

  function clearForm() {
    formtambah.find("input").val("")
    formtambah.find("select").html("")
  }

  function clear_is_invalid() {
    if (formtambah.find('input').hasClass('is-invalid') || formtambah.find('select').hasClass('is-invalid')) {
      formtambah.find('input').removeClass('is-invalid');
      formtambah.find('select').removeClass('is-invalid');
    }
  }

  function defaultform() {
    formtambah.find('.card-title').html('Tambah Data Barang');
    formtambah.find("button[type='submit']").html('Simpan');
  }

  // function hapus(id, namagedung) {
  //   // console.log(id + " & " + namagedung);
  //   // console.log('delete : ' + namagedung);
  //   Swal.fire({
  //     title: `Apakah kamu yakin ingin menghapus data ${namagedung}?`,
  //     icon: 'warning',
  //     showCancelButton: true,
  //     confirmButtonColor: '#3085d6',
  //     cancelButtonColor: '#d33',
  //     confirmButtonText: 'Ya, Hapus saja!',
  //     cancelButtonText: 'Batalkan',
  //   }).then((result) => {
  //     if (result.isConfirmed) {
  //       $.ajax({
  //         type: "post",
  //         url: "gedung/hapus/" + id,
  //         data: {
  //           nama_gedung: namagedung
  //         },
  //         dataType: 'json',
  //         success: function(response) {
  //           if (response.sukses) {
  //             Swal.fire(
  //               'Berhasil', response.sukses, 'success'
  //             ).then((result) => {
  //               location.reload();
  //             })
  //           } else if (response.error) {
  //             Swal.fire(
  //               'Gagal!',
  //               response.error,
  //               'error'
  //             );
  //           }
  //         },
  //         error: function(xhr, ajaxOptions, thrownError) {
  //           alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
  //         }
  //       });
  //     }
  //   });
  // }

  $(document).ready(function() {
    formtambah.hide();

    var databarang = $('#table-barang').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: 'barang/listdatabarang',
      },
      order: [],
      columns: [{
          data: 'no',
          orderable: false
        },
        {
          data: 'kode_brg'
        },
        {
          data: 'nama_brg'
        },
        {
          data: 'nama_kategori'
        },
        {
          data: null,
          render: function(data, type, row) {
            return data.stok + ' ' + data.kd_satuan;
          }
        },
        {
          data: 'harga_beli',
          render: function(data, type, row) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
          }
        },
        {
          data: 'kondisi'
        },
        {
          data: 'nama_ruang'
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

    $('#btn-tambahbarang').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      defaultform();
      clearForm();
      formtambah.show(500);
      saveMethod = "add";
    })

    $('.batal-form').click(function(e) {
      e.preventDefault();
      clear_is_invalid();
      formtambah.hide(500);
    });

    $('#katid').select2({
      placeholder: 'Piih Nama Kategori',
      minimumInputLength: 3,
      allowClear: true,
      width: "90%",
      ajax: {
        url: 'barang/pilihkategori',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
          }
        },
        processResults: function(data, page) {
          return {
            results: data
          };
        },
      }
    });

    // $('#formTambahGedung').submit(function(e) {
    //   e.preventDefault();
    //   let url = "";
    //   if (saveMethod == "update") {
    //     url = "gedung/update/" + globalId;
    //   } else if (saveMethod == "add") {
    //     url = "gedung/simpan";
    //   }
    //   $.ajax({
    //     type: 'post',
    //     url: url,
    //     data: $(this).serialize(),
    //     dataType: "json",
    //     beforeSend: function() {
    //       $('.btnsimpan').attr('disable', 'disabled');
    //       $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
    //     },
    //     complete: function() {
    //       $('.btnsimpan').removeAttr('disable');
    //       $('.btnsimpan').html('Simpan');
    //     },
    //     success: function(response) {
    //       if (response.error) {
    //         if (response.error.namagedung) {
    //           $('#namagedung').addClass('is-invalid');
    //           $('.errnamagedung').html(response.error.namagedung);
    //         } else {
    //           $('#namagedung').removeClass('is-invalid');
    //           $('.errnamagedung').html('');
    //         }
    //         if (response.error.prefix) {
    //           $('#prefix').addClass('is-invalid');
    //           $('.errprefix').html(response.error.prefix);
    //         } else {
    //           $('#prefix').removeClass('is-invalid');
    //           $('.errprefix').html('');
    //         }
    //         if (response.error.katid) {
    //           $('#katid').addClass('is-invalid');
    //           $('.errkatid').html(response.error.katid);
    //         } else {
    //           $('#katid').removeClass('is-invalid');
    //           $('.errkatid').html('');
    //         }
    //       } else {
    //         formtambah.hide(500);
    //         Swal.fire(
    //           'Berhasil!',
    //           response.sukses,
    //           'success'
    //         ).then((result) => {
    //           databarang.ajax.reload();
    //         })
    //       }
    //     },
    //     error: function(xhr, ajaxOptions, thrownError) {
    //       alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
    //     }
    //   });

    //   return false;

    // })


  });
</script>
<?= $this->endSection() ?>