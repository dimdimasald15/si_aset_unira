<div class="card mb-3" id="cardTambahStokMultiple">
    <div class="card-header shadow-sm">
        <h5 class="card-title">Form Tambah Stok <?= ucwords($title); ?></h5>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form class="form form-vertical py-2" id="formTambahStok">
                <?= csrf_field() ?>
                <?php $row = 1; ?>
                <table class="table table-responsive-lg">
                    <thead>
                        <th>Form Tambah Stok Multiple</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="formtambahrow">
                        <tr>
                            <td>
                                <div class="form-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-12">
                                            <h5>Form <?= $row; ?></h5>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="hidden" name="id[]" id="id<?= $row ?>">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="jenis_kat<?= $row ?>">Jenis Kategori
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-layers"></i>
                                                        </span>
                                                        <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat<?= $row ?>">
                                                            <option value="">Pilih Jenis Kategori Barang</option>
                                                            <option value="Barang Tetap">Barang Tetap</option>
                                                            <option value="Barang Persediaan">Barang Persediaan</option>
                                                        </select>
                                                        <div class="invalid-feedback errjenis_kat<?= $row ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="idbrg<?= $row ?>">Nama Barang</label>
                                                    <div class="row mb-1">
                                                        <div class="input-group mb-3">
                                                            <select name="barang_id[]" class="form-select p-2" id="idbrg<?= $row; ?>"></select>
                                                            <div class="invalid-feedback erridbrg<?= $row; ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row mb-1">
                                                    <label for="lokasi<?= $row ?>">Lokasi Penempatan
                                                        <?= ucwords($title) ?></label>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                                        <select class="form-select" id="lokasi<?= $row; ?>" name="ruang_id[]"></select>
                                                        <div class="invalid-feedback errlokasi<?= $row; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row g-2 mb-1">
                                                    <div class="col-md-6">
                                                        <label class="mb-1">Sisa Stok</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                                            <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok<?= $row ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="jmlmasuk<?= $row ?>" class="mb-1">Jumlah
                                                            <?= $title ?></label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" min="1" class="form-control" id="jmlmasuk<?= $row; ?>" placeholder="Masukkan Jumlah <?= $title ?>" name="jumlah_masuk[]">
                                                            <div class="invalid-feedback errjmlmasuk<?= $row; ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-5">
                                                    <label class="mb-1">Tanggal Pembelian Sebelumnya</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                                                        <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama<?= $row ?>" name="tgl_belilama[]" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="tglbeli<?= $row ?>" class="mb-1">Tanggal Pembelian
                                                        Baru</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                                                        <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli<?= $row; ?>" name="tgl_pembelian[]">
                                                        <div class="invalid-feedback errtglbeli<?= $row; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-bottom" style="width:1px; white-space:nowrap;">
                                <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" onClick="util.hapusForm(this)" style="display:none;">
                                    <i class="fa fa-times"></i> Hapus form</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6 d-flex justify-content-start">
                        <button type="button" class="btn btn-primary my-4 btn-sm btntambahrow"><i class="fa fa-plus"></i>Tambah Form</button>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-white my-4 backformmultiple">&laquo; Kembali</button>
                        <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var lastNumb = parseInt("<?= $row ?>");
    var currIndex = lastNumb + 1;
    var rowCount = '';

    function loadLokasistok(row) {
        if (lokasiSarprasCache) {
            // jika data lokasi sudah tersedia di cache, gunakan data tersebut
            $(`#lokasi${row}`).html(
                `<option value='${lokasiSarprasCache[0].id}' selected>${lokasiSarprasCache[0].text}</option>`);
        } else {
            // jika data lokasi belum tersedia di cache, muat data baru dari server
            $.ajax({
                type: "get",
                url: `${nav}/pilihlokasi`,
                data: {
                    search: "Sarana",
                },
                dataType: "json",
                success: function(response) {
                    // simpan data lokasi ke dalam cache
                    lokasiSarprasCache = response;
                    // tampilkan opsi lokasi di form
                    $(`#lokasi${row}`).html(
                        `<option value='${response[0].id}' selected>${response[0].text}</option>`);
                }
            });
        }
    }

    function clearFormmt(row) {
        $('#formTambahStok').find("input").val("")
        $('#formTambahStok').find("select").html("")
    }

    //check duplikat barang
    idbrgSet = new Set();

    $(document).ready(function() {
        rowCount = $('.formtambahrow tr').length;
        looping(rowCount);
        loadLokasistok(rowCount);

        $('.backformmultiple').on('click', function() {
            // Hapus semua baris kecuali baris pertama
            $('.formtambahrow tr').slice(1).remove();
            $('#cardTambahStokMultiple').hide(500);
            util.clearIsInvalid(`#formTambahStok`);
            clearFormmt(rowCount);
        });

        $('.btntambahrow').on('click', function(e) {
            e.preventDefault();
            var index = currIndex++;

            $(".formtambahrow").append(`
      <tr>
        <td>
          <div class="form-body">
            <div class="row d-flex justify-content-between">
              <div class="col-12">
                <h5>Form ${index}</h5>
              </div>
              <div class="col-lg-12">
              <input type="hidden" name="id[]" id="id${index}">
              <div class="row g-2 mb-1">
                <div class="col-md-6">
                  <label class="form-label" for="jenis_kat${index}">Jenis Kategori Barang</label>
                  <div class="input-group mb-3">
                    <span class="input-group-text">
                      <i class="bi bi-layers"></i>
                    </span>
                    <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat${index}">
                      <option value="">Pilih Jenis Kategori Barang</option>
                      <option value="Barang Tetap">Barang Tetap</option>
                      <option value="Barang Persediaan">Barang Persediaan</option>
                    </select>
                    <div class="invalid-feedback errjenis_kat${index}"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="idbrg${index}">Nama Barang</label>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <select name="barang_id[]" class="form-select p-2" id="idbrg${index}"></select>
                      <div class="invalid-feedback erridbrg${index}"></div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="col-12">
                  <div class="row mb-1">
                    <label for="lokasi${index}">Lokasi Penempatan Stok <?= ucwords($title) ?></label>
                  </div>
                  <div class="row mb-1">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                      <select class="form-select" id="lokasi${index}" name="ruang_id[]"></select>
                      <div class="invalid-feedback errlokasi${index}"></div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row g-2 mb-1">
                    <div class="col-md-6">
                      <label class="mb-1">Sisa Stok</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                        <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok${index}" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="jmlmasuk${index}" class="mb-1">Jumlah <?= $title ?></label>
                      <div class="input-group mb-3">
                        <input type="number" min="1" class="form-control" id="jmlmasuk${index}" placeholder="Masukkan Jumlah <?= $title ?>" name="jumlah_masuk[]">
                        <div class="invalid-feedback errjmlmasuk${index}"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row g-2 mb-1">
                  <div class="col-md-5">
                    <label  class="mb-1">Tanggal Pembelian Sebelumnya</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama${index}" name="tgl_belilama[]" readonly>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <label for="tglbeli${index}" class="mb-1">Tanggal Pembelian Baru</label>
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbeli${index}" name="tgl_pembelian[]">
                      <div class="invalid-feedback errtglbeli${index}"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </td>
        <td class="align-bottom" style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" onClick="util.hapusForm(this)" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
        </td>
      </tr>
      `);

            rowCount = $('.formtambahrow tr').length;

            looping(rowCount);

            $(".formtambahrow tr:last-child .btnhapusrow").show();
        });

        $('#formTambahStok').submit(function(e) {
            e.preventDefault();
            var url = `${nav}/updatedatastokmultiple`;

            let formdatamultiple = new FormData(this); // mengambil data dari form
            formdatamultiple.append('jmldata', rowCount);

            $.ajax({
                type: "post",
                url: url,
                data: formdatamultiple,
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
                    var response = JSON.parse(result);
                    if (response.error) {
                        for (var i = 1; i <= rowCount; i++) {
                            var errjenis_kat = response.error[`jenis_kat.${i-1}`];
                            var erridbrg = response.error[`barang_id.${i-1}`];
                            var errjmlmasuk = response.error[`jumlah_masuk.${i-1}`];
                            var errtglbeli = response.error[`tgl_pembelian.${i-1}`];
                            util.setFieldError(`#jenis_kat${i}`, errjenis_kat);
                            util.setFieldError(`#idbrg${i}`, erridbrg);
                            util.setFieldError(`#jmlmasuk${i}`, errjmlmasuk);
                            util.setFieldError(`#tglbeli${i}`, errtglbeli);
                        }
                    } else {
                        const tables = [tableBrgTetap, tableBrgPersediaan];
                        util.handleSubmitSuccess(response.success, tables);
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

    function looping(row) {
        for (var i = 1; i <= row; i++) {
            $('.formtambahrow tr').find('.btnhapusrow').hide();

            (function(j) {
                $(`#jenis_kat${j}`).on('change', function(e) {
                    e.preventDefault();
                    var jenis_kat = $(this).val();
                    selectOption.barang(`idbrg${j}`, jenis_kat)
                    util.rmIsInvalid(`jenis_kat${j}`);
                })
            })(i);

            (function(j) {
                const inputId = ["lokasi", "jmlmasuk", "tglbeli"];
                util.initializeValidationHandlers(inputId, j);

                $(`#idbrg${j}`).on('change', function(e) {
                    e.preventDefault();
                    util.rmIsInvalid(`idbrg${j}`);
                    let idbrg = $(`#idbrg${j}`).val();
                    const fieldsToReset = ["idbrg", "sisastok", "tglbelilama"]
                    barang.isDuplicate(idbrg, fieldsToReset, j);

                    var b_id = $(`#idbrg${j}`).val();
                    var r_id = $(`#lokasi${j}`).val();

                    if (b_id != null && r_id != null) {
                        function successCallback(response) {
                            if (response) {
                                $(`#id${j}`).val(response.id);
                                $(`#sisastok${j}`).val(response.sisa_stok);
                                $(`#tglbelilama${j}`).val(response.tgl_beli);
                            }
                        }
                        const datas = {
                            barang_id: b_id,
                            ruang_id: r_id
                        }
                        barang.checkRuangBrg(datas, successCallback);
                    } else {
                        $(`#id_${j}`).val('');
                        $(`#sisastok${j}`).html('');
                        $(`#tglbelilama${j}`).html('');
                    }
                });

            })(i);

            loadLokasistok(i);
        }
    }
</script>