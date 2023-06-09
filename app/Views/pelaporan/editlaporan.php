<?= $this->extend('/layouts/template2') ?>

<?= $this->section('content') ?>

<form class="form form-vertical py-2" id="formeditlaporan">
  <?= csrf_field() ?>
  <div class="row justify-content-center" id="formbrgrusak">
    <div class="col-lg-9 col-md-9 col-12">
      <div class="card shadow">
        <div class="card-header bg-transparent pb-1">
          <div class="text-center text-muted">
            <h3 class="mb-2 text-muted">Form Kerusakan Barang</h3>
          </div>
        </div>
        <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
          <div class="row mt-1">
            <div class="col-lg-12">
              <div class="form-body">
                <div class="row d-flex justify-content-between">
                  <div class="col-lg-12">
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-12">
                          <div class="row mb-1 oldmember">
                            <label for="idanggota">Nama Pelapor</label>
                            <div class="row mb-1">
                              <input type="hidden" name="id" id="id" value="<?= $laporan->id ?>">
                              <input type="hidden" name="stokbrg_id" id="stok_id" value="<?= $laporan->stokbrg_id ?>">
                              <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <select name="anggota_id" class="form-select p-2" id="idanggota">
                                </select>
                                <div class="invalid-feedback erridanggota"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="row mb-1">
                            <label for="idbrg">Nama Barang</label>
                            <div class="row mb-1">
                              <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                                <select name="barang_id" class="form-select p-2" id="idbrg" disabled>
                                  <option value="<?= $laporan->barang_id ?>" selected><?= $laporan->nama_brg ?></option>
                                </select>
                                <div class="invalid-feedback erridbrg"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="row g-2 mb-1">
                        <div class="col-md-6">
                          <div class="row mb-1">
                            <label for="lokasi">Lokasi Penempatan</label>
                          </div>
                          <div class="row mb-1">
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                              <select class="form-select" id="lokasi" name="ruang_id" disabled>
                                <option value="<?= $laporan->ruang_id ?>" selected><?= $laporan->nama_ruang ?></option>
                              </select>
                              <div class="invalid-feedback errlokasi"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label for="jmlrusak" class="mb-1">Jumlah Barang Rusak</label>
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                            <input type="number" min="1" class="form-control" id="jmlrusak" placeholder="Masukkan Jumlah Barang rusak" name="jml_barang" value="<?= $laporan->jml_barang ?>">
                            <div class="invalid-feedback errjmlrusak"></div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label for="satuan" class="mb-1">Satuan</label>
                          <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-dice-5"></i></span>
                            <select name="satuan_id" class="form-select p-2" id="satuan" disabled>
                              <option value="<?= $laporan->satuan_id ?>" selected><?= $laporan->kd_satuan ?></option>
                            </select>
                            <div class="invalid-feedback errsatuan"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="row g-2 mb-1">
                      <div class="col-md-12">
                        <label class="mb-1" for="title">Title laporan</label>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon1"><i class="bi bi-file-earmark-text"></i></span>
                          <input type="text" class="form-control" placeholder="Title Laporan" name="title" id="title" value="Laporan kerusakan aset <?= $laporan->nama_brg ?> di <?= $laporan->nama_ruang ?>" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="fotobrg" class="mb-1">Foto kerusakan barang</label>
                        <div class="input-group mb-3">
                          <span class="input-group-text" id="basic-addon1"><i class="bi bi-card-image"></i></span>
                          <input type="file" class="form-control" placeholder="Upload foto barang rusak" id="fotobrg" name="foto_barang">
                          <div class="invalid-feedback errfotobrg"></div>
                        </div>
                      </div>
                      <div class="col-md-6 previewimage">
                        <label for="preview_img" class="mb-1">Preview Image</label>
                        <div class="input-group mb-3">
                          <img src="<?= base_url('/assets/images/foto_kerusakan/') . $laporan->foto ?>" id="preview_img" class="img-thumbnail rounded mx-auto d-block" style="width: 200px; height: auto;">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label class="deskripsi" for="deskripsi">Deskripsi Kerusakan Barang</label>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-pencil"></i></span>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"><?= $laporan->deskripsi ?></textarea>
                        <div class="invalid-feedback errdeskripsi"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row btngroup2">
            <div class="col-12 d-flex justify-content-end">
              <a type="button" class="btn btn-white my-4 btn-cancel1" href="<?= base_url() ?>detail-barang/<?= str_replace(".", "-", $laporan->kode_brg) . "-" . $laporan->ruang_id ?>">&laquo; Kembali</a>
              <button type="button" class="btn btn-success my-4 btnupdate">Update</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="row justify-content-center" id="opsiubahlaporan" style="display:none;"></div>
<?= $this->endSection(); ?>
<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    var namaanggota = "<?= $laporan->nama_anggota ?>";
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/permintaancontroller/pilihanggota",
      dataType: "json",
      success: function(response) {
        $('#idanggota').empty();
        $('#idanggota').append('<option value="">Pilih Pelapor</option>');
        $.each(response, function(key, value) {
          if (value.nama_anggota == namaanggota) {
            $('#idanggota').append('<option value="' + value.id + '" selected>' +
              value.nama_anggota + ' (' + value.no_anggota + ')' + ' - ' + value.level + '</option>');
          } else {
            $('#idanggota').append('<option value="' + value.id + '">' +
              value.nama_anggota + ' (' + value.no_anggota + ')' + ' - ' + value.level + '</option>');
          }
        });
      }
    });

    $('#idanggota').on('change', function(e) {
      e.preventDefault();
      $('#idanggota').removeClass('is-invalid');
      $('.erridanggota').html('');
    })
    $('#fotobrg').change(function() {
      var input = this;
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('.previewimage').html(` <label for="preview_img" class="mb-1">Preview Image</label>
            <div class="input-group mb-3">
              <img src="${e.target.result}" id="preview_img" class="img-thumbnail rounded mx-auto d-block" style="width: 200px; height: auto;">
            </div>`).show();
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        $('.previewimage').html('');
      }
    });

    $('#jmlrusak').on('input', function(e) {
      e.preventDefault();
      $(this).removeClass('is-invalid');
      $('.errjmlrusak').html('');
    })
    $('#fotobrg').on('input', function(e) {
      e.preventDefault();
      $(this).removeClass('is-invalid');
      $('.errfotobrg').html('');
    })

    $('.btnupdate').on('click', function(e) {
      e.preventDefault();
      let formeditlaporan = $('#formeditlaporan')[0];
      var laporan_id = $('#id').val();
      let data = new FormData(formeditlaporan);

      $.ajax({
        type: "post",
        url: "<?= site_url('laporan-kerusakan-aset/update-laporan/') ?>" + laporan_id,
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        beforeSend: function() {
          $('.btnupdate').attr('disable', 'disabled');
          $('.btnupdate').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnupdate').removeAttr('disable');
          $('.btnupdate').html('Update');
        },
        success: function(result) {
          var response = JSON.parse(result);
          if (response.error) {
            erridanggota = response.error.anggota_id;
            errjmlrusak = response.error.jml_barang;
            errfotobrg = response.error.foto_barang;
            errdeskripsi = response.error.deskripsi;
            if (erridanggota) {
              $('#idanggota').addClass('is-invalid');
              $('.erridanggota').html(erridanggota);
            } else {
              $('#idanggota').removeClass('is-invalid');
              $('.erridanggota').html('');
            }
            if (errjmlrusak) {
              $('#jmlrusak').addClass('is-invalid');
              $('.errjmlrusak').html(errjmlrusak);
            } else {
              $('#jmlrusak').removeClass('is-invalid');
              $('.errjmlrusak').html('');
            }
            if (errfotobrg) {
              $('#fotobrg').addClass('is-invalid');
              $('.errfotobrg').html(errfotobrg);
            } else {
              $('#fotobrg').removeClass('is-invalid');
              $('.errfotobrg').html('');
            }
            if (errdeskripsi) {
              $('#deskripsi').addClass('is-invalid');
              $('.errdeskripsi').html(response.error.deskripsi);
            } else {
              $('#deskripsi').removeClass('is-invalid');
              $('.errdeskripsi').html('');
            }
          } else {
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
              $('#formeditlaporan').hide(500);
              $('#opsiubahlaporan').empty();
              $('#opsiubahlaporan').html(`
              <div class="col-lg-9 col-md-9 col-12">
                <div class="card shadow">
                  <div class="card-header bg-transparent pb-1">
                    <div class="text-center text-muted">
                      <h3 class="mb-2 text-muted">Laporan Anda Telah Kami Terima!</h3>
                    </div>
                  </div>
                  <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
                    <div class="row mt-1">
                      <p>Terima kasih sudah melaporkan kerusakan aset di lingkungan Universitas Islam Raden Rahmat Malang. Jika ada kesalahan dalam laporan anda, anda dapat melakukan perubahan melalui link di bawah ini.</p>
                      <hr>
                      <a class="text-decoration-underline" href="<?= site_url() ?>laporan-kerusakan-aset/edit-laporan/${response.laporan_id}">Ubah laporan anda</a>
                      <br>
                      <a class="text-decoration-underline" href="<?= $url_detail_brg ?>">&laquo; Kembali ke halaman laporan kerusakan aset</a>
                    </div>
                  </div>
                </div>
              </div>`).show(500);
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

  function formatResult(data) {
    if (!data.id) {
      return data.text;
    }

    var $result = $(
      `<span><i class="bi bi-circle-square"> </i>${data.text}</span>`
    );

    return $result;
  }
</script>
<?= $this->endSection(); ?>