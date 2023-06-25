<?= $this->extend('/layouts/template2') ?>

<?= $this->section('content') ?>
<?php if ($barang) { ?>
  <form class="form form-vertical py-2" id="formlaporbrg">
    <?= csrf_field() ?>
    <div class="row justify-content-center" id="intro">
      <div class="col-lg-9 col-md-9 col-12">
        <div class="card shadow border-0 mb-0">
          <div class="card-header bg-transparent pb-1">
            <div class="text-center text-muted">
              <h3 class="mb-2 text-muted">Form Pelaporan Kerusakan Barang</h3>
            </div>
          </div>
          <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
            <div class="row px-4 py-0 option">
              <div class="col-md-12 d-flex justify-content-center">
                <h6>Apakah anda sudah pernah melaporkan kerusakan aset?</h6>
              </div>
              <div class="col-md-12">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pilihan" id="opsi1" value="anggota baru">
                  <label class="form-check-label" for="opsi1">
                    Tidak, saya belum pernah melaporkan kerusakan aset.
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pilihan" id="opsi2" value="anggota lama">
                  <label class="form-check-label" for="opsi2">
                    Ya, saya sudah pernah melaporkan kerusakan aset.
                  </label>
                  <div class="invalid-feedback erroption"></div>
                </div>
                <input type="hidden" name="no_laporan" id="nolaporan" value="<?= $no_laporan ?>">
              </div>
            </div>
            <div class="row option">
              <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn btn-success mx-4 my-4 btn-block" id="btn-next1">Lanjutkan isi form</button>
              </div>
            </div>
          </div>
          <div class="card-footer shadow-sm">
            <div class="row text-center">
              <div class="col-lg-12">
                <a href="<?= site_url() . $url_detail_brg ?>" class="text-decoration-underline"> Kembali ke halaman sebelumnya</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" id="newmember" style="display:none;">
      <div class="col-lg-9 col-md-9 col-12">
        <div class="card shadow">
          <div class="card-header bg-transparent pb-1">
            <div class="text-center text-muted">
              <h3 class="mb-2 text-muted">Form Pendaftaran Pelapor Baru</h3>
            </div>
          </div>
          <div class="card-body" style="padding: 0.5rem 1rem 1rem 1rem;">
            <div class="row mt-1">
              <div class="form-body">
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="namaanggota" class="form-label">Nama Pelapor</label>
                      <div class="input-group mb-1">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan Nama Anggota" id="namaanggota" name="nama_anggota">
                        <div class="invalid-feedback errnamaanggota"></div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mb-2">
                        <label for="level">Level Pelapor</label>
                      </div>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-badge-fill"></i></span>
                        <select name="level" class="form-select p-2" id="level">
                          <option value="" disabled selected>Pilih Level</option>
                          <option value="Karyawan">Karyawan</option>
                          <option value="Mahasiswa">Mahasiswa</option>
                        </select>
                        <div class="invalid-feedback errlevel"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6 noanggota" style="display:none;">
                    </div>
                    <div class="col-md-6">
                      <label for="unit" class="form-label">Unit Pelapor</label>
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
                        <select name="unit_id" class="form-select p-2" id="unit"></select>
                        <div class="invalid-feedback errunit"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label for="nohp" class="form-label">No Hp Pelapor</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" class="form-control" placeholder="Masukkan No Handphone" id="nohp" name="no_hp">
                        <div class="invalid-feedback errnohp"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row btngroup1" style="display: none;">
                  <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-white my-4 btn-cancel1" style="display:none;">&laquo; Kembali</button>
                    <button type="button" class="btn btn-success my-4" id="btn-next2">Lanjutkan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" id="formbrgrusak" style="display:none;">
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
                            <div class="row mb-1 oldmember" style="display:none;">
                              <label for="idanggota">Nama Pelapor</label>
                              <div class="row mb-1">
                                <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                  <select name="anggota_id" class="form-select p-2" id="idanggota" style="display: none;">
                                  </select>
                                  <div class="invalid-feedback erridanggota"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <input type="hidden" name="stokbrg_id" id="id" value="<?= $barang->id ?>">
                            <div class="row mb-1">
                              <label for="idbrg">Nama Barang</label>
                              <div class="row mb-1">
                                <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1"><i class="bi bi-layers"></i></span>
                                  <select name="barang_id" class="form-select p-2" id="idbrg" disabled>
                                    <option value="<?= $barang->barang_id ?>" selected><?= $barang->nama_brg ?></option>
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
                                  <option value="<?= $barang->ruang_id ?>" selected><?= $barang->nama_ruang ?></option>
                                </select>
                                <div class="invalid-feedback errlokasi"></div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label for="jmlrusak" class="mb-1">Jumlah Barang Rusak</label>
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                              <input type="number" min="1" class="form-control" id="jmlrusak" placeholder="Masukkan Jumlah Barang rusak" name="jml_barang">
                              <div class="invalid-feedback errjmlrusak"></div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label for="satuan" class="mb-1">Satuan</label>
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1"><i class="bi bi-dice-5"></i></span>
                              <select name="satuan_id" class="form-select p-2" id="satuan" disabled>
                                <option value="<?= $barang->satuan_id ?>" selected><?= $barang->kd_satuan ?></option>
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
                            <input type="text" class="form-control" placeholder="Title Laporan" name="title" id="title" value="Laporan kerusakan aset <?= $barang->nama_brg ?> di <?= $barang->nama_ruang ?>" readonly>
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
                        <div class="col-md-6 previewimage" style="display:none;"></div>
                      </div>
                      <div class="col-md-12">
                        <label class="deskripsi" for="deskripsi">Deskripsi Kerusakan Barang</label>
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon1"><i class="bi bi-pencil"></i></span>
                          <textarea class="form-control" id="deskripsi" name="deskripsi" name="deskripsi"></textarea>
                          <div class="invalid-feedback errdeskripsi"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row btngroup2" style="display: none;">
              <div class="col-12 d-flex justify-content-end">
                <button type="button" class="btn btn-white my-4 btn-cancel1" style="display: none;">&laquo; Kembali</button>
                <button type="button" class="btn btn-white my-4" id="btn-cancel2" style="display: none;">&laquo; Kembali</button>
                <button type="button" class="btn btn-success my-4 btnsimpan">Submit !</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </form>

  <div class="row justify-content-center" id="opsiubahlaporan" style="display:none;">
  </div>
<?php } else { ?>
  <div class="card">
    <div class="card-title text-center">
      <div class="row m-3">
        <h4>Mohon maaf, tidak dapat diproses.</h4>
      </div>
    </div>
  </div>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  function clearForm() {
    var title = "";
    if ($('#title').val() && $('#nolaporan').val()) {
      title = $('#title').val();
      nolaporan = $('#nolaporan').val();
    }
    $('#formlaporbrg').find("input").val("")
    $('#title').val(title)
    $('#nolaporan').val(nolaporan)
    $('#unit').html('');
    $('#level').val('');
    $('#idanggota').val('');
    $('.previewimage').empty();
  }

  function clear_is_invalid() {
    if ($('#formlaporbrg').find('input').hasClass('is-invalid') || $('#formlaporbrg').find('select').hasClass('is-invalid')) {
      $('#formlaporbrg').find('input').removeClass('is-invalid');
      $('#formlaporbrg').find('select').removeClass('is-invalid');
    }
  }

  function defaulthide() {
    $('#newmember').hide();
    $('#formbrgrusak').hide(500);
    $('.oldmember').hide();
    $('.noanggota').hide();
    $('#idanggota').hide();
    $('.btngroup1').hide();
    $('.btngroup2').hide();
    $('.btn-cancel1').hide();
    $('#btn-cancel2').hide();
    $('#opsiubahlaporan').hide();
  }

  $(document).ready(function() {
    defaulthide();

    $('.btn-cancel1').on('click', function() {
      $('#intro').show(500);
      $('#newmember').hide(500);
      // $('#formbrgrusak').hide(500);
      clearForm();
      defaulthide();
      clear_is_invalid();
    });

    $('#btn-cancel2').on('click', function() {
      $('#intro').hide(500);
      $('#formbrgrusak').hide(500);
      $('#newmember').show(500);
      $('.btngroup2').hide();
      $('.btn-cancel1').show();
      // clearForm();
      clear_is_invalid();
    });

    $('#btn-next1').on('click', function() {
      var optionSelected = false;
      $('.option .form-check-input').each(function() {
        if ($(this).is(':checked')) {
          optionSelected = true;
          $(".option .form-check-input").removeClass("is-invalid");
          $(".erroption").html('');
          return false; // break out of the loop
        }
      });
      if (!optionSelected) {
        $(".option .form-check-input").addClass("is-invalid");
        $(".erroption").html('Pilih salah satu opsi');
        return; // stop here, don't proceed to the next form
      }

      if ($('#opsi1').is(':checked')) {
        $('#intro').hide(500);
        $('.oldmember').hide(500);
        $('#idanggota').hide();
        $('#newmember').show(500);
        $('#formbrgrusak').hide();
        $('.btn-cancel1').hide();
      } else if ($('#opsi2').is(':checked')) {
        $('#intro').hide(500);
        $('#newmember').hide(500);
        $('#formbrgrusak').show(500);
        $('.oldmember').show();
        $('#idanggota').show();
        $('.btn-cancel1').show();
        $('#btn-cancel2').hide();
      }
    });

    $('#level').on('change', function(e) {
      e.preventDefault();
      $('#level').removeClass('is-invalid');
      $('.errlevel').html('');

      level = $('#level').val();
      pilihunit(level);

      $('.noanggota').hide().html('');
      if (level == 'Mahasiswa') {
        $('.noanggota').show().append(
          `<label for="noanggota" class="form-label">NIM</label>
    <div class="input-group">
      <span class="input-group-text"><i class="bi bi-card-list"></i></span>
      <input type="text" class="form-control" placeholder="Masukkan NIM" id="noanggota" name="no_anggota">
      <div class="invalid-feedback errnoanggota"></div>
    </div>`
        );
      } else if (level == 'Karyawan') {
        $('.noanggota').show().append(
          `<label for="noanggota" class="form-label">Nomor Pegawai</label>
    <div class="input-group">
      <span class="input-group-text"><i class="bi bi-card-list"></i></span>
      <input type="text" class="form-control" placeholder="Masukkan Nomor Pegawai" id="noanggota" name="no_anggota">
      <div class="invalid-feedback errnoanggota"></div>
    </div>`
        );
      } else {
        $('.noanggota').hide().html('');
      }
    })

    $.ajax({
      type: "get",
      url: "pelaporan/pilihanggota",
      dataType: "json",
      success: function(response) {
        $('#idanggota').empty();
        $('#idanggota').append('<option value="">Pilih Pelapor</option>');
        $.each(response, function(key, value) {
          $('#idanggota').append('<option value="' + value.id + '">' +
            value.nama_anggota + ' (' + value.no_anggota + ')' + ' - ' + value.level + '</option>');
        });
      }
    });

    $('#idanggota').on('change', function(e) {
      e.preventDefault();
      $('#idanggota').removeClass('is-invalid');
      $('.erridanggota').html('');
      $('.btngroup2').show(500);
      $('.btn-cancel1').show();
      $('#btn-cancel2').hide();
    })
    $('#namaanggota').on('keyup', function(e) {
      e.preventDefault();
      $('#namaanggota').removeClass('is-invalid');
      $('.errnamaanggota').html('');
      $('.btngroup1').show(500);
      $('.btn-cancel1').show();
    })
    $('#noanggota').on('keyup', function(e) {
      e.preventDefault();
      $('#noanggota').removeClass('is-invalid');
      $('.errnoanggota').html('');
    })
    $('#unit').on('change', function(e) {
      e.preventDefault();
      $('#unit').removeClass('is-invalid');
      $('.errunit').html('');
    })

    var namaanggota = "",
      level = "",
      unit_id = "",
      no_anggota = "",
      nohp = "";
    $('#btn-next2').on('click', function() {
      namaanggota = $('#namaanggota').val();
      level = $('#level').val();
      unit_id = $('#unit').val();
      no_anggota = $('#noanggota').val();
      nohp = $('#nohp').val();
      $.ajax({
        type: "post",
        url: "pelaporan/cekanggota",
        data: {
          nama_anggota: namaanggota,
          level: level,
          unit_id: unit_id,
          no_anggota: no_anggota,
          nohp: nohp,
        },
        dataType: "json",
        success: function(response) {
          if (response.error) {
            var errnamaanggota = response.error.nama_anggota;
            var errnoanggota = response.error.no_anggota;
            var errlevel = response.error.level;
            var errunit = response.error.unit_id;
            if (errnamaanggota) {
              $('#namaanggota').addClass('is-invalid');
              $('.errnamaanggota').html(errnamaanggota);
            } else {
              $('#namaanggota').removeClass('is-invalid');
              $('.errnamaanggota').html('');
            }
            if (errnoanggota) {
              $('#noanggota').addClass('is-invalid');
              $('.errnoanggota').html(errnoanggota);
            } else {
              $('#noanggota').removeClass('is-invalid');
              $('.errnoanggota').html('');
            }
            if (errlevel) {
              $('#level').addClass('is-invalid');
              $('.errlevel').html(errlevel);
            } else {
              $('#level').removeClass('is-invalid');
              $('.errlevel').html('');
            }
            if (errunit) {
              $('#unit').addClass('is-invalid');
              $('.errunit').html(errunit);
            } else {
              $('#unit').removeClass('is-invalid');
              $('.errunit').html('');
            }

          } else {
            if (response.sukses) {
              $('#newmember').hide(500);
              $('#formbrgrusak').show(500);
              $('.oldmember').hide(500);
              $('#idanggota').hide();
              $('.btngroup2').show(500);
              $('#btn-cancel2').show();
              $('.btn-cancel1').hide();
            }
          }
        }
      });
    });

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

    $('.btnsimpan').on('click', function(e) {
      e.preventDefault();
      let formlaporbrg = $('#formlaporbrg')[0];

      let data = new FormData(formlaporbrg);

      $.ajax({
        type: "post",
        url: "simpan-laporan",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('Submit !');
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
            defaulthide();
            Swal.fire(
              'Berhasil!',
              response.sukses,
              'success'
            ).then((result) => {
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
                      <br>
                      <br>
                      <a href="edit-laporan/${response.laporan_id}" class="text-decoration-underline">Ubah laporan anda</a>
                      <br>
                      <a href="<?= site_url() . $url_detail_brg ?>" class="text-decoration-underline">&laquo; Kembali ke halaman detail barang</a>
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

  function pilihunit(level) {
    $('#unit').select2({
      placeholder: 'Piih Unit',
      minimumInputLength: 1,
      allowClear: true,
      width: "70%",
      ajax: {
        url: "pelaporan/pilihunit",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term,
            level: level,
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
  }

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
<?= $this->endSection() ?>