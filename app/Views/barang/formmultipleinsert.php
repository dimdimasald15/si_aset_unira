<div class="card mb-3" id="cardmultipleinsert">
    <div class="card-header shadow-sm">
        <h5 class="card-title">Form Tambah <?= ucwords($title); ?></h5>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form class="form form-vertical py-2 formsimpanmultiple">
                <?= csrf_field() ?>
                <?php $no = 1; ?>
                <table class="table table-responsive-lg">
                    <thead>
                        <th>Form</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="formtambahrow">
                        <tr>
                            <td>
                                <div class="form-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-12">
                                            <h5>Form <?= $no; ?></h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="jenis_kat<?= $no ?>">Jenis Kategori
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-layers"></i>
                                                        </span>
                                                        <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat<?= $no ?>">
                                                            <option value="">Pilih Jenis Kategori Barang</option>
                                                            <option value="Barang Tetap">Barang Tetap</option>
                                                            <option value="Barang Persediaan">Barang Persediaan</option>
                                                        </select>
                                                        <div class="invalid-feedback errjenis_kat<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="katid<?= $no ?>">Nama
                                                        Kategori</label>
                                                    <div class="input-group mb-3">
                                                        <select name="kat_id[]" class="form-select p-2" id="katid<?= $no ?>"></select>
                                                        <div class="invalid-feedback errkatid<?= $no; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="subkdkategori<?= $no ?>">Kode Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-upc"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="kd_kategori[]" placeholder="Kode Kategori" id="subkdkategori<?= $no ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="skbarang<?= $no ?>"></label>
                                                    <div class="input-group mb-3">
                                                        <select name="skbrg[]" class="form-select" id="skbarang<?= $no ?>"></select>
                                                        <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other<?= $no ?>" name="skbrg_lain[]" style="display:none;">
                                                        <input type="text" class="form-control" id="skbrgfix<?= $no ?>" name="kode_brg[]" readonly style="display:none;">
                                                        <div class="invalid-feedback errskbarang<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="merk<?= $no ?>">Merk</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                                        <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk<?= $no ?>" name="merk[]">
                                                        <div class="invalid-feedback errmerk<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tipe<?= $no ?>" class="form-label">Tipe Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                                        <input type="text" class="form-control" placeholder="Masukkan tipe" id="tipe<?= $no ?>" name="tipe[]">
                                                        <div class="invalid-feedback errtipe<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="warna<?= $no ?>" class="form-label">Warna</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-palette"></i></span>
                                                        <select class="form-select" id="warna<?= $no ?>" name="warna[]"></select>
                                                        <div class="invalid-feedback errwarna<?= $no ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row mb-1">
                                                <label class="form-label" for="namabarang<?= $no ?>">Nama Barang</label>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                                    <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="namabarang<?= $no ?>" name="nama_brg[]" readonly>
                                                    <div class="invalid-feedback errnamabarang<?= $no ?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-5 mb-3 asalbrg<?= $no ?>">
                                                    <label class="form-label">Asal <?= $title; ?></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="asal<?= $no ?>" id="belibaru<?= $no ?>" value="Beli baru">
                                                        <label class="form-check-label" for="belibaru<?= $no ?>">
                                                            Beli Baru
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="asal<?= $no ?>" id="belibekas<?= $no ?>" value="Beli bekas">
                                                        <label class="form-check-label" for="belibekas<?= $no ?>">
                                                            Beli Bekas
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="asal<?= $no ?>" id="hibah<?= $no ?>" value="Hibah">
                                                        <label class="form-check-label" for="hibah<?= $no ?>">
                                                            Hibah
                                                        </label>
                                                        <div class="invalid-feedback errasalbrg<?= $no ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 radiobelibekas<?= $no ?>" style="display:none;">
                                                    <label class="form-label">Beli bekas dimana?</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="radiotoko<?= $no ?>">
                                                        <label class="form-check-label" for="radiotoko<?= $no ?>">
                                                            Beli di toko
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="radioinstansi<?= $no ?>">
                                                        <label class="form-check-label" for="radioinstansi<?= $no ?>">
                                                            Beli di Instansi
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 mb-3 belibaru<?= $no ?>" style="display:none;">
                                                    <label for="toko<?= $no ?>" class="form-label">Nama Toko</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                                        <input type="text" class="form-control" placeholder="Masukkan nama toko" id="toko<?= $no ?>" name="toko[]">
                                                        <div class="invalid-feedback errtoko"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 hibah<?= $no ?>" style="display:none;">
                                                    <label for="instansi<?= $no ?>" class="form-label">Nama
                                                        Instansi</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                        <input type="text" class="form-control" placeholder="Masukkan Nama Instansi" id="instansi<?= $no ?>" name="instansi[]">
                                                        <div class="invalid-feedback errinstansi"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="noseri<?= $no ?>" class="form-label">Nomor seri
                                                        barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                                        <input type="text" class="form-control" placeholder="Masukkan No Seri" id="noseri<?= $no ?>" name="no_seri[]">
                                                        <div class="invalid-feedback errnoseri"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nodokumen<?= $no ?>" class="form-label">Nomor
                                                        Dokumen</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                                        <input type="text" class="form-control" placeholder="Masukkan No Dokumen" id="nodokumen<?= $no ?>" name="no_dokumen[]">
                                                        <div class="invalid-feedback errnodokumen"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="hargabeli<?= $no ?>" class="form-label">Harga Beli
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli<?= $no ?>" name="harga_beli[]">
                                                        <div class="invalid-feedback errhargabeli<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="hargajual<?= $no ?>" class="form-label">Harga Jual
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" class="form-control" placeholder="Masukkan Harga Jual" id="hargajual<?= $no ?>" name="harga_jual[]">
                                                        <div class="invalid-feedback errhargajual<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="tglbeli<?= $no ?>" class="form-label">Tanggal
                                                        Pembelian</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                                        <input type="date" class="form-control" placeholder="dd/mm/yyyy" id="tglbeli<?= $no ?>" name="tgl_pembelian[]">
                                                        <div class="invalid-feedback errtglbeli<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="lokasi<?= $no ?>">Lokasi Penempatan
                                                        <?= $title ?></label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                                        <select class="form-select" id="lokasi<?= $no ?>" name="ruang_id[]"></select>
                                                        <div class="invalid-feedback errlokasi"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-12">
                                                <div class="row g-2 mb-1">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="jmlmasuk<?= $no ?>" class="mb-1">Jumlah Barang Masuk</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                                            <input type="number" min="1" class="form-control " id="jmlmasuk<?= $no ?>" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk[]">
                                                            <div class="invalid-feedback errjmlmasuk<?= $no ?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="satuan<?= $no ?>" class="mb-1">Satuan <?= $title; ?></label>
                                                        <div class="input-group mb-3">
                                                            <select name="satuan_id[]" class="form-select p-2 " id="satuan<?= $no ?>"></select>
                                                            <div class="invalid-feedback errsatuan<?= $no ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-bottom" style="width:1px; white-space:nowrap;">
                                <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
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
    lastNumb = parseInt("<?= $no ?>");
    currIndex = lastNumb + 1;
    var rowCount = '';
    var kdbrgother = '';
    kodebrgSet = new Set();
    var newkode = '';

    function loadLokasi(row) {
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

    function looping(row) {
        for (var i = 1; i <= row; i++) {
            $('.formtambahrow tr').find('.btnhapusrow').hide();
            (function(j) {
                $(`#jenis_kat${j}`).on('change', function(e) {
                    e.preventDefault();
                    selectOption.category(`katid${j}`,this);
                    $(`#jenis_kat${j}`).removeClass('is-invalid');
                    $(`.errjenis_kat${j}`).html('');
                })
            })(i);

            selectOption.warna(`warna${i}`, "70%");

            (function(j) {
                $(`#katid${j}`).on('change', function(e) {
                    e.preventDefault();
                    var katid = $(this).val();
                    if (katid == null) {
                        kd_brg = '';
                        util.clearFormatMt(j);
                    } else {
                        kodebrg.getSubKodeBrg(katid, j);
                        kodebrg.getSubKdOtherBrg(katid);
                    }
                    $(`#katid${j}`).removeClass('is-invalid');
                    $(`.errkdkatid${j}`).html('');
                    $(`#skbarang-other${j}`).hide();
                })

                $(document).on('change', `#katid${j}, #merk${j}, #warna${j},#tipe${j}`, function(e) {
                    e.preventDefault();
                    var categories = $(`#katid${j}`).find('option:selected').text();
                    var merk = $(`#merk${j}`).val();
                    var warna = $(`#warna${j}`).val() == null ? '' : capitalize(`- ${$(`#warna${j}`).val()}`);
                    var tipe = $(`#tipe${j}`).val();
                    if (categories !== null) {
                        $(`#namabarang${j}`).val(categories);
                        if (merk !== '') {
                            $(`#namabarang${j}`).val(`${categories} ${merk}`);
                            if (tipe !== '') {
                                $(`#namabarang${j}`).val(`${categories} ${merk} ${tipe}`);
                                if (warna !== null) {
                                    $(`#namabarang${j}`).val(`${categories} ${merk} ${tipe} ${warna}`);
                                }
                            } else {
                                $(`#namabarang${j}`).val(`${categories} ${merk} ${warna}`);
                            }
                        }
                    }
                })

                $(`#skbarang${j}`).on('change', function(e) {
                    e.preventDefault();
                    if ($(this).val() == '') {
                        $(`#skbrgfix${j}`).val('');
                        $(`#skbarang-other${j}`).hide();
                        kodebrg.isDuplicate(j, 'kosong');
                    } else if ($(this).val() == `otherbrg${j}`) {
                        $(`#skbarang-other${j}`).show();
                        $(`#skbarang-other${j}`).val(kdbrgother);
                        var kd_brg = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang-other${j}`).val()}`;
                        $(`#skbrgfix${j}`).val(kd_brg);
                        kodebrg.isDuplicate(j);
                        if (newkode !== '') {
                            var newkd_brg = `${$(`#subkdkategori${j}`).val()}.${newkode}`;
                            $(`#skbrgfix${j}`).val(newkd_brg);
                            kodebrg.isDuplicate(j);
                        }
                    } else {
                        var kdbrglama = `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang${j}`).val()}`;

                        var kodebrgbaru;

                        $.ajax({
                            type: "post",
                            url: `${nav}/getbarangbyany`,
                            data: {
                                kode_brg: kdbrglama,
                            },
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'warning',
                                    text: `${response.nama_brg} dengan kode barang ${response.kode_brg} sudah ada, lebih baik lakukan update barang melalui menu update barang. Sistem akan merekomendasikan opsi lain untuk subkode barang.`,
                                }).then((result) => {
                                    $(`#skbarang${j}`).val(`otherbrg${j}`);
                                    $(`#skbarang-other${j}`).show(500);
                                    $(`#skbarang-other${j}`).val(kdbrgother);
                                    kodebrgbaru =
                                        `${$(`#subkdkategori${j}`).val()}.${$(`#skbarang-other${j}`).val()}`;
                                    $(`#skbrgfix${j}`).val(kodebrgbaru);
                                    kodebrg.isDuplicate(j);
                                })
                            }
                        });
                    }
                    $(`#skbrgfix${j}`).removeClass('is-invalid');
                    $(`.errskbarang${j}`).html('');
                });

                $('input[type="radio"]').click(function() {
                    if ($(this).attr('id') == `belibaru${j}`) {
                        $(`.belibaru${j}`).show();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).hide();
                        $('.formsimpanmultiple').find("input[name='instansi[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `belibekas${j}`) {
                        $(`.radiobelibekas${j}`).show();
                        $(`.belibaru${j}`).hide();
                        $(`.hibah${j}`).hide();
                        $('.formsimpanmultiple').find("input[name='toko[" + j + "]']").val('')
                        $('.formsimpanmultiple').find("input[name='instansi[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `hibah${j}`) {
                        $(`.belibaru${j}`).hide();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).show();
                        $('.formsimpanmultiple').find("input[name='toko[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `radiotoko${j}`) {
                        $(`.belibaru${j}`).show();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).hide();
                        $(`#radioinstansi${j}`).prop('checked', false);
                        $('.formsimpanmultiple').find("input[name='instansi[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `radioinstansi${j}`) {
                        $(`.belibaru${j}`).hide();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).show();
                        $(`#radiotoko${j}`).prop('checked', false);
                        $('.formsimpanmultiple').find("input[name='toko[" + j + "]']").val('')
                    } else {
                        $(`.radiobelibekas${j}`).hide();
                        $(`.belibaru${j}`).hide();
                        $(`.hibah${j}`).hide();
                    }

                    $(`.asalbrg${j} .form-check-input`).removeClass("is-invalid");
                    $(`.errasalbrg${j}`).html('');
                });

                $(`#namabarang${j}`).on(`input`, function(e) {
                    e.preventDefault();
                    $(`#namabarang${j}`).removeClass(`is-invalid`);
                    $(`.errornamabarang${j}`).html(``);
                })
                $(`#merk${j}`).on(`input`, function(e) {
                    e.preventDefault();
                    $(`#merk${j}`).removeClass(`is-invalid`);
                    $(`.errormerk${j}`).html(``);
                })

                $(`#hargabeli${j}`).on(`input`, function(e) {
                    e.preventDefault();
                    $(`#hargabeli${j}`).removeClass(`is-invalid`);
                    $(`.errorhargabeli${j}`).html(``);
                })
                $(`#hargajual${j}`).on(`input`, function(e) {
                    e.preventDefault();
                    $(`#hargajual${j}`).removeClass(`is-invalid`);
                    $(`.errorhargajual${j}`).html(``);
                })
                selectOption.satuan(`satuan${j}`)

                $(`#satuan${j}`).on('change', function(e) {
                    e.preventDefault();
                    $(`#satuan${j}`).removeClass('is-invalid');
                    $(`.errorsatuan${j}`).html('');
                })
                $(`#jmlmasuk${j}`).on('input', function(e) {
                    e.preventDefault();
                    $(`#jmlmasuk${j}`).removeClass('is-invalid');
                    $(`.errorjmlmasuk${j}`).html('');
                })
            })(i);

            loadLokasi(i);
        }
    }

    $(document).ready(function() {
        rowCount = $('.formtambahrow tr').length;
        looping(rowCount);
        loadLokasi(rowCount);
        $('.backformmultiple').on('click', function() {
            currIndex = rowCount + 1;
            // Hapus semua baris kecuali baris pertama
            $('.formtambahrow tr').slice(1).remove();
            util.clearIsInvalid('.formsimpanmultiple');
            util.clearFormatMt(rowCount);
            $('#cardmultipleinsert').hide(500);
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
                    <div class="col-12">
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
                            <label class="form-label" for="katid${index}">Nama Kategori</label>
                            <div class="input-group mb-3">
                            <select name="kat_id[]" class="form-select p-2" id="katid${index}"></select>
                            <div class="invalid-feedback errkatid${index}"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                        <div class="col-md-6">
                            <label for="subkdkategori${index}">Kode Barang</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-upc"></i>
                            </span>
                            <input type="text" class="form-control" name="kd_kategori[]" placeholder="Kode Kategori" id="subkdkategori${index}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="skbarang${index}"></label>
                            <div class="input-group mb-3">
                            <select name="skbrg[]" class="form-select" id="skbarang${index}"></select>
                            <input type="text" class="form-control" placeholder="Kode Barang" id="skbarang-other${index}" name="skbrg_lain[]" style="display:none;">
                            <input type="text" class="form-control" id="skbrgfix${index}" name="kode_brg[]" readonly style="display:none;">
                            <div class="invalid-feedback errskbarang${index}"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                        <div class="col-md-4">
                            <label for="merk${index}" class="form-label">Merk</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan Merk" id="merk${index}" name="merk[]">
                            <div class="invalid-feedback errmerk${index}"></div>
                            </div>
                        </div>              
                        <div class="col-md-4">
                            <label for="tipe${index}" class="form-label">Tipe Barang</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan tipe" id="tipe${index}" name="tipe[]">
                            <div class="invalid-feedback errtipe${index}"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="warna${index}" class="form-label">Warna</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-palette"></i></span>
                            <select class="form-select" id="warna${index}" name="warna[]"></select>
                            <div class="invalid-feedback errwarna${index}">
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row mb-1">
                        <label for="namabarang${index}">Nama Barang</label>
                        </div>
                        <div class="row mb-1">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan Nama Barang" id="namabarang${index}" name="nama_brg[] readonly>
                            <div class="invalid-feedback errnamabarang${index}"></div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                        <div class="col-md-5 mb-3 asalbrg${index}">
                            <label class="form-label">Asal <?= $title; ?></label>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="asal${index}" id="belibaru${index}" value="Beli baru">
                            <label class="form-check-label" for="belibaru${index}">
                                Beli Baru
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="asal${index}" id="belibekas${index}" value="Beli bekas">
                            <label class="form-check-label" for="belibekas${index}">
                                Beli Bekas
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="asal${index}" id="hibah${index}" value="Hibah">
                            <label class="form-check-label" for="hibah${index}">
                                Hibah
                            </label>
                            <div class="invalid-feedback errasalbrg${index}">
                            </div>
                            </div>
                        </div>
                        <div class="col-md-7 radiobelibekas${index}" style="display:none;">
                            <label  class="form-label">Beli bekas dimana?</label>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" id="radiotoko${index}">
                            <label class="form-check-label" for="radiotoko${index}">
                                Beli di toko
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" id="radioinstansi${index}">
                            <label class="form-check-label" for="radioinstansi${index}">
                                Beli di Instansi
                            </label>
                            </div>
                        </div>
                        <div class="col-md-7 mb-3 belibaru${index}" style="display:none;">
                            <label for="toko${index}" class="form-label">Nama Toko</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan nama toko" id="toko${index}" name="toko[]">
                            <div class="invalid-feedback errtoko${index}"></div>
                            </div>
                        </div>
                        <div class="col-md-7 hibah${index}" style="display:none;">
                            <label for="instansi${index}" class="form-label">Nama Instansi</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan Nama Instansi" id="instansi${index}" name="instansi[]">
                            <div class="invalid-feedback errinstansi${index}"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                        <div class="col-md-6">
                            <label for="noseri${index}" class="form-label">Nomor seri barang</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan No Seri" id="noseri${index}" name="no_seri[]">
                            <div class="invalid-feedback errnoseri"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nodokumen${index}" class="form-label">Nomor Dokumen</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan No Dokumen" id="nodokumen${index}" name="no_dokumen[]">
                            <div class="invalid-feedback errnodokumen"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                        <div class="col-md-6">
                            <label for="hargabeli${index}" class="form-label">Harga Beli Barang</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" placeholder="Masukkan Harga Beli" id="hargabeli${index}" name="harga_beli[]">
                            <div class="invalid-feedback errhargabeli${index}"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="hargajual${index}" class="form-label">Harga Jual Barang</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number"  class="form-control" placeholder="Masukkan Harga Jual" id="hargajual${index}" name="harga_jual[]">
                            <div class="invalid-feedback errhargajual${index}"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                        <div class="col-md-auto">
                            <label for="tglbeli${index}" class="mb-1">Tanggal Pembelian</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                            <input type="date" class="form-control" placeholder="dd/mm/yyyy" id="tglbeli${index}" name="tgl_pembelian[]">
                            <div class="invalid-feedback errtglbeli${index}"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-12">
                        <div class="row mb-1">
                            <label for="lokasi${index}">Lokasi Penempatan <?= $title ?></label>
                        </div>
                        <div class="row mb-1">
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                            <select class="form-select" id="lokasi${index}" name="ruang_id[]"></select>
                            <div class="invalid-feedback errlokasi"></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="row g-2 mb-1">
                            <div class="col-md-6">
                            <label for="jmlmasuk${index}" class="mb-1">Jumlah Barang Masuk</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                <input type="number" min="1" class="form-control " id="jmlmasuk${index}" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk[]">
                                <div class="invalid-feedback errjmlmasuk${index}"></div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <label for="satuan${index}" class="mb-1">Satuan <?= $title; ?></label>
                            <div class="input-group mb-3">
                                <select name="satuan_id[]" class="form-select p-2 " id="satuan${index}"></select>
                                <div class="invalid-feedback errsatuan${index}"></div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </td>
                <td class="align-bottom" style="width:1px; white-space:nowrap;">
                <button type="button" class="btn btn-danger btn-sm btnhapusrow">
                <i class="fa fa-times"></i> Hapus form ${index}
                </button>
                </td>
            </tr>
            `);

            rowCount = $('.formtambahrow tr').length;

            looping(rowCount);

            $(".formtambahrow tr:last-child .btnhapusrow").show();
        });

        $(document).on('click', '.btnhapusrow', function(e) {
            e.preventDefault();
            // hapus tr yang diklik
            $(this).parents('tr').remove();
            currIndex--;

            if (currIndex <= lastNumb) {
                currIndex = lastNumb + 1;
            }

            //hapus tr sebelumnya
            rowCount = $('.formtambahrow tr').length;
            for (var i = 0; i < rowCount; i++) {
                $('.formtambahrow tr').find('.btnhapusrow').hide();
            }

            rowCount === 1 ? $('.formtambahrow tr').find('.btnhapusrow').hide() :
                $(".formtambahrow tr:last-child .btnhapusrow").show();
        })

        $('.formsimpanmultiple').submit(function(e) {
            e.preventDefault();
            // mengambil data dari form
            let formdata = new FormData(this);
            // dapatkan jumlah row
            formdata.append('jmldata', rowCount);

            $.ajax({
                type: "post",
                url: `${nav}/insertmultiple`,
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
                    var response = JSON.parse(result);

                    if (response.error) {
                        barang.handleSubmitError(response.error, rowCount);       
                    } else {
                        const tables = [$('#tableBrgTetap').DataTable(), $('#tableBrgPersediaan').DataTable()];
                        util.handleSubmitSuccess(response.success, tables);
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