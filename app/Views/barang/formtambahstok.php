<form class="form form-vertical py-4" id="formTambahStok">
  <?= csrf_field() ?>
  <div class="form-body">
    <div class="row d-flex justify-content-between">
      <div class="col-lg-12">
        <div class="col-12">
          <input type="hidden" name="id" id="id">
          <div class="row mb-1">
            <label for="idbrg mb-2">Nama Barang</label>
          </div>
          <div class="row mb-1">
            <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupSelect01"><i class="bi bi-layers"></i></label>
              <select name="barang_id" class="form-select p-2" id="idbrg" style="width: 400px;"></select>
              <div class="invalid-feedback erridbrg"></div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row mb-1">
            <label for="lokasi">Lokasi Penempatan <?= ucwords($title) ?></label>
          </div>
          <div class="row mb-1">
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
              <select class="form-select lokasi" name="ruang_id"></select>
              <div class="invalid-feedback errlokasi"></div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row g-2 mb-1">
            <div class="col-md-5">
              <label for="sisastok" class="mb-1">Sisa Stok <?= $jenis_kat ?></label>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok" readonly>
                <div class="invalid-feedback errsisastok"></div>
              </div>
            </div>
            <div class="col-md-5">
              <label for="jmlmasuk" class="mb-1">Jumlah Barang Masuk</label>
              <div class="input-group mb-3">
                <input type="number" min="1" class="form-control" id="jmlmasuk" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk">
                <div class="invalid-feedback errjmlmasuk"></div>
              </div>
            </div>
            <div class="col-md-2">
              <label for="" class="mb-1">Satuan</label>
              <div class="input-group mb-3">
                <select name="satuan_id" class="form-select p-2 satuan"></select>
                <div class="invalid-feedback errsatuan"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="row g-2 mb-1">
          <div class="col-md-5">
            <label for="tglbelilama" class="mb-1">Tanggal Pembelian Sebelumnya</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
              <input type="date" class="form-control" placeholder="Masukkan Tanggal" name="tgl_belilama" readonly>
            </div>
          </div>
          <div class="col-md-5">
            <label for="tglbeli" class="mb-1">Tanggal Pembelian Baru</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
              <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli" name="tgl_pembelian">
              <div class="invalid-feedback errtglbeli"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="row">
    <div class="col-12 d-flex justify-content-end">
      <button type="button" class="btn btn-white my-4 back-form">&laquo; Kembali</button>
      <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
    </div>
  </div>
</form>
<script>
  $(document).ready(function() {
    var saveMethod = "<?= $saveMethod ?>";

    $('.back-form').on('click', function() {
      $('#formTambahBarang').hide(500);
      $('.viewformstok').hide(500);
      $('.option').show(500);
      $('#opsi1').prop('checked', false);
      $('#opsi2').prop('checked', false);
    });

    $('#idbrg').select2({
      placeholder: 'Piih Nama <?= $title ?>',
      minimumInputLength: 1,
      allowClear: true,
      width: "50%",
      ajax: {
        url: `<?= base_url() ?>/barangcontroller/pilihbarang`,
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
            jenis_kat: "<?= $jenis_kat ?>",
          }
        },
        processResults: function(data, page) {
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatResult,
    });

    $('.satuan').select2({
      placeholder: 'Piih Satuan',
      minimumInputLength: 1,
      allowClear: true,
      width: "100%",
      ajax: {
        url: "<?= base_url() ?>/barangcontroller/pilihsatuan",
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
        cache: true
      },
      templateResult: formatResult,
    });

    $('#lokasi').on('change', function(e) {
      e.preventDefault();
      $('#lokasi').removeClass('is-invalid');
      $('.errorlokasi').html('');
    })
    $('#satuan').on('change', function(e) {
      e.preventDefault();
      $('#satuan').removeClass('is-invalid');
      $('.errorsatuan').html('');
    })
    $('#jmlmasuk').on('input', function(e) {
      e.preventDefault();
      $('#jmlmasuk').removeClass('is-invalid');
      $('.errorjmlmasuk').html('');
    })

    $('#idbrg').on('change', function(e) {
      e.preventDefault();
      $('#idbrg').removeClass('is-invalid');
      $('.erroridbrg').html('');

      var b_id = $('#idbrg').val();
      var r_id = $('#formTambahStok').find('select[name="ruang_id"]').val();

      if (b_id != null && r_id != null) {
        $.ajax({
          type: "post",
          url: "<?= base_url() ?>/barangcontroller/cekbrgdanruang",
          data: {
            barang_id: b_id,
            ruang_id: r_id,
          },
          dataType: "json",
          success: function(response) {
            console.log(response);
            if (response) {
              $('#formTambahStok').find("input[name='id']").val(response.id);
              $('#formTambahStok').find("input[name='sisa_stok']").val(response.sisa_stok);
              $('#formTambahStok').find("input[name='tgl_belilama']").val(response.tgl_beli);
              $('.satuan').prop('disabled', true);
              $('#formTambahStok').find("select[name*='satuan_id']").html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
            }
            $('#formTambahBarang').html();
          }
        });
      } else {
        $('#id').val('');
        $('.satuan').prop('disabled', false);
        $('#formTambahStok').find("select[name*='satuan_id']").html('');
      }
    });

    $('#formTambahStok').submit(function(e) {
      e.preventDefault();
      let url = "";

      globalId = $(this).find("input[name='id']").val();

      if (saveMethod == "update") {
        url = "<?= $nav ?>/updatestok/" + globalId;
      } else if (saveMethod == "add") {
        url = "<?= $nav ?>/simpanstok";
      }

      let formdata = new FormData(this); // mengambil data dari form
      formdata.append('jenis_transaksi', "<?= $jenistrx ?>"); // menambahkan data tambahan

      $.ajax({
        type: "post",
        url: url,
        data: formdata,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Simpan');
        },
        success: function(result) {
          var response = JSON.parse(result)
          if (response.error) {
            if (response.error.idbrg) {
              $('.idbrg').addClass('is-invalid');
              $('.erridbrg').html(response.error.idbrg);
            } else {
              $('.idbrg').removeClass('is-invalid');
              $('.erridbrg').html('');
            }
            if (response.error.jmlmasuk) {
              $('#jmlmasuk').addClass('is-invalid');
              $('.errjmlmasuk').html(response.error.jmlmasuk);
            } else {
              $('#jmlmasuk').removeClass('is-invalid');
              $('.errjmlmasuk').html('');
            }
            if (response.error.tglbeli) {
              $('#tglbeli').addClass('is-invalid');
              $('.errtglbeli').html(response.error.tglbeli);
            } else {
              $('#tglbeli').removeClass('is-invalid');
              $('.errtglbeli').html('');
            }
          } else {
            $('#tampilformtambahbarang').hide(500);
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              databarang.ajax.reload();
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          Swal.fire(
            'Error!',
            'Terjadi kesalahan saat mengirim data karena tidak ada data yang diubah',
            'error'
          )
        }
      });
      return false;
    });

  });

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-layers"> </i>${data.text}</span>`
    );

    return $result;
  }
</script>