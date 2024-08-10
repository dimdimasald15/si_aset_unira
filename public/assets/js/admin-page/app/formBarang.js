import { crud } from "./crud.js";
import { reportAssets } from "../../report-breakdown-assets/app/reportAssets.js";
export const formBarang = (() => {
    // let currIndex = lastNumb + 1;
    const closeBtnMultiple = () => util.closeBtnMt('#formsimpanmultiple', '#cardmultipleinsert');
    const handleAddRow = (formId, currIndex) => {
        var index = currIndex++;
        var appendRow = forms(index);
        $(".table-body").append(appendRow);
        looping(formId, index);
        $(".table-body tr:last-child .btnhapusrow").show();
    }
    const forms = (index) => {
        return `<tr>
                <td>
                    <div class="form-body">
                        <div class="row d-flex justify-content-between">
                            <div class="col-12">
                                <h5>Form ${index}</h5>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 mb-1">
                                    <div class="col-md-6">
                                        <label class="form-label" for="jenis_kat${index}">Jenis Kategori
                                            Barang</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">
                                                <i class="bi bi-layers"></i>
                                            </span>
                                            <select name="jenis_kat[]" class="form-select selectrow-${index} p-2" id="jenis_kat${index}">
                                                <option value="">Pilih Jenis Kategori Barang</option>
                                                <option value="Barang Tetap">Barang Tetap</option>
                                                <option value="Barang Persediaan">Barang Persediaan</option>
                                            </select>
                                            <div class="invalid-feedback errjenis_kat${index}"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="katid${index}">Nama
                                            Kategori</label>
                                        <div class="input-group mb-3">
                                            <select name="kat_id[]" class="form-select selectrow-${index} p-2" id="katid${index}"></select>
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
                                            <input type="text" class="form-control inputrow-${index}" name="kd_kategori[]" placeholder="Kode Kategori" id="subkdkategori${index}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="skbarang${index}"></label>
                                        <div class="input-group mb-3">
                                            <select name="skbrg[]" class="form-select selectrow-${index}" id="skbarang${index}"></select>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Kode Barang" id="skbarang-other${index}" name="skbrg_lain[]" style="display:none;">
                                            <input type="text" class="form-control inputrow-${index}" id="skbrgfix${index}" name="kode_brg[]" readonly style="display:none;">
                                            <div class="invalid-feedback errskbarang${index}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 mb-1">
                                    <div class="col-md-4">
                                        <label class="form-label" for="merk${index}">Merk</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan Merk" id="merk${index}" name="merk[]">
                                            <div class="invalid-feedback errmerk${index}"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tipe${index}" class="form-label">Tipe Barang</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan tipe" id="tipe${index}" name="tipe[]">
                                            <div class="invalid-feedback errtipe${index}"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="warna${index}" class="form-label">Warna</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-palette"></i></span>
                                            <select class="form-select selectrow-${index}" id="warna${index}" name="warna[]"></select>
                                            <div class="invalid-feedback errwarna${index}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row mb-1">
                                    <label class="form-label" for="namabarang${index}">Nama Barang</label>
                                </div>
                                <div class="row mb-1">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                        <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan Nama Barang" id="namabarang${index}" name="nama_brg[]">
                                        <div class="invalid-feedback errnamabarang${index}"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 mb-1">
                                    <div class="col-md-5 mb-3 asalbrg${index}">
                                        <label class="form-label">Asal <?= $title; ?></label>
                                        <div class="form-check">
                                            <input class="form-check-input radiorow-${index}" type="radio" name="asal${index}" id="belibaru${index}" value="beli baru">
                                            <label class="form-check-label" for="belibaru${index}">
                                                Beli Baru
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input radiorow-${index}" type="radio" name="asal${index}" id="belibekas${index}" value="beli bekas">
                                            <label class="form-check-label" for="belibekas${index}">
                                                Beli Bekas
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input radiorow-${index}" type="radio" name="asal${index}" id="hibah${index}" value="hibah">
                                            <label class="form-check-label" for="hibah${index}">
                                                Hibah
                                            </label>
                                            <div class="invalid-feedback errasalbrg${index}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 radiobelibekas${index}" style="display:none;">
                                        <label class="form-label">Beli bekas dimana?</label>
                                        <div class="form-check">
                                            <input class="form-check-input radiorow-${index}" type="radio" id="radiotoko${index}">
                                            <label class="form-check-label" for="radiotoko${index}">
                                                Beli di toko
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input radiorow-${index}" type="radio" id="radioinstansi${index}">
                                            <label class="form-check-label" for="radioinstansi${index}">
                                                Beli di Instansi
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mb-3 belibaru${index}" style="display:none;">
                                        <label for="toko${index}" class="form-label">Nama Toko</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan nama toko" id="toko${index}" name="toko[]">
                                            <div class="invalid-feedback errtoko"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 hibah${index}" style="display:none;">
                                        <label for="instansi${index}" class="form-label">Nama
                                            Instansi</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan Nama Instansi" id="instansi${index}" name="instansi[]">
                                            <div class="invalid-feedback errinstansi"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 mb-1">
                                    <div class="col-md-6">
                                        <label for="noseri${index}" class="form-label">Nomor seri
                                            barang</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan No Seri" id="noseri${index}" name="no_seri[]">
                                            <div class="invalid-feedback errnoseri"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nodokumen${index}" class="form-label">Nomor
                                            Dokumen</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                            <input type="text" class="form-control inputrow-${index}" placeholder="Masukkan No Dokumen" id="nodokumen${index}" name="no_dokumen[]">
                                            <div class="invalid-feedback errnodokumen"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 mb-1">
                                    <div class="col-md-6">
                                        <label for="hargabeli${index}" class="form-label">Harga Beli
                                            Barang</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control inputrow-${index}" placeholder="Masukkan Harga Beli" id="hargabeli${index}" name="harga_beli[]">
                                            <div class="invalid-feedback errhargabeli${index}"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hargajual${index}" class="form-label">Harga Jual
                                            Barang</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control inputrow-${index}" placeholder="Masukkan Harga Jual" id="hargajual${index}" name="harga_jual[]">
                                            <div class="invalid-feedback errhargajual${index}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-2 mb-1">
                                    <div class="col-md-6">
                                        <label for="tglbeli${index}" class="form-label">Tanggal
                                            Pembelian</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                            <input type="date" class="form-control inputrow-${index}" placeholder="dd/mm/yyyy" id="tglbeli${index}" name="tgl_pembelian[]">
                                            <div class="invalid-feedback errtglbeli${index}"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="lokasi${index}">Lokasi Penempatan
                                            <?= $title ?></label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                            <select class="form-select selectrow-${index}" id="lokasi${index}" name="ruang_id[]">
                                                <option value="54">Sarana dan Prasarana</option>
                                            </select>
                                            <div class="invalid-feedback errlokasi"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-12">
                                    <div class="row g-2 mb-1">
                                        <div class="col-md-6">
                                            <label class="form-label" for="jmlmasuk${index}" class="mb-1">Jumlah Barang Masuk</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                                <input type="number" min="1" class="form-control inputrow-${index}" id="jmlmasuk${index}" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk[]">
                                                <div class="invalid-feedback errjmlmasuk${index}"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="satuan${index}" class="mb-1">Satuan ${title}</label>
                                            <div class="input-group mb-3">
                                                <select name="satuan_id[]" class="form-select selectrow-${index} p-2 " id="satuan${index}"></select>
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
                    <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" onClick="util.hapusForm(this)" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
                </td>
            </tr>`
    }

    const looping = (formId, row) => {
        for (var i = 1; i <= row; i++) {
            $('.table-body tr').find('.btnhapusrow').hide();
            (function (j) {
                $(`#jenis_kat${j}`).on('change', function (e) {
                    e.preventDefault();
                    selectOption.category(`katid${j}`, this);
                    util.rmIsInvalid(`jenis_kat${j}`);
                    util.clearFormatMt("#formsimpanmultiple", j);
                })
            })(i);

            selectOption.warna(`warna${i}`, "70%");

            (function (j) {
                $(`#katid${j}`).on('change', function (e) {
                    e.preventDefault();
                    var katid = $(this).val();
                    if (katid == null) {
                        kd_brg = '';
                        util.clearFormatMt("#formsimpanmultiple", j);
                    } else {
                        kodebrg.getSubKodeBrg(katid, j);
                        kodebrg.getSubKdOtherBrg(katid);
                    }
                    util.rmIsInvalid(`katid${j}`);
                    $(`#skbarang-other${j}`).hide();
                })

                $(document).on('change', `#katid${j}, #merk${j}, #warna${j},#tipe${j}`, function (e) {
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

                $(`#skbarang${j}`).on('change', function (e) {
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
                            headers: {
                                authorization: `Bearer ${token}`
                            },
                            url: `${nav}/getbarangbyany`,
                            data: {
                                kode_brg: kdbrglama,
                            },
                            dataType: "json",
                            success: function (response) {
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

                $('input[type="radio"]').on('click', function () {
                    if ($(this).attr('id') == `belibaru${j}`) {
                        $(`.belibaru${j}`).show();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).hide();
                        formId.find("input[name='instansi[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `belibekas${j}`) {
                        $(`.radiobelibekas${j}`).show();
                        $(`.belibaru${j}`).hide();
                        $(`.hibah${j}`).hide();
                        formId.find("input[name='toko[" + j + "]']").val('')
                        formId.find("input[name='instansi[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `hibah${j}`) {
                        $(`.belibaru${j}`).hide();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).show();
                        formId.find("input[name='toko[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `radiotoko${j}`) {
                        $(`.belibaru${j}`).show();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).hide();
                        $(`#radioinstansi${j}`).prop('checked', false);
                        formId.find("input[name='instansi[" + j + "]']").val('')
                    } else if ($(this).attr('id') == `radioinstansi${j}`) {
                        $(`.belibaru${j}`).hide();
                        $(`.radiobelibekas${j}`).hide();
                        $(`.hibah${j}`).show();
                        $(`#radiotoko${j}`).prop('checked', false);
                        formId.find("input[name='toko[" + j + "]']").val('')
                    } else {
                        $(`.radiobelibekas${j}`).hide();
                        $(`.belibaru${j}`).hide();
                        $(`.hibah${j}`).hide();
                    }

                    $(`.asalbrg${j} .form-check-input`).removeClass("is-invalid");
                    $(`.errasalbrg${j}`).html('');
                });
                const inputId = ["namabarang", "merk", "hargabeli", "hargajual", "satuan", "jmlmasuk"];
                util.initializeValidationHandlers(inputId, j);
                selectOption.satuan(`satuan${j}`);
            })(i);
        }
    }

    const insertMultiple = (form, rowCount, event) => {
        event.preventDefault();
        let formdata = new FormData(form);
        formdata.append('jmldata', rowCount);
        const callback = (response) => {
            if (response.error) {
                handleSubmitError(response.error, rowCount);
            } else {
                const tables = [tableBrgTetap, tableBrgPersediaan];
                util.handleSubmitSuccess(response.success, tables);
            }
        };
        const datas = {
            url: `${nav}/insertmultiple`,
            data: formdata,
        }
        crud.submitAjax(datas, callback);
        return false;
    }

    const handleSubmitError = (errors, rowCount) => {
        let errorasal = [];
        for (let key in errors) {
            if (errors.hasOwnProperty(key) && key.startsWith('asal')) {
                errorasal.push(errors[key]);
            }
        }

        for (let i = 1; i <= rowCount; i++) {
            util.setFieldError(`#jenis_kat${i}`, errors[`jenis_kat.${i - 1}`]);
            util.setFieldError(`#katid${i}`, errors[`kat_id.${i - 1}`]);
            util.setFieldError(`#skbrgfix${i}`, errors[`kode_brg.${i - 1}`]);
            util.setFieldError(`#namabarang${i}`, errors[`nama_brg.${i - 1}`]);
            util.setFieldError(`#merk${i}`, errors[`merk.${i - 1}`]);
            util.setFieldError(`#warna${i}`, errors[`warna.${i - 1}`]);
            util.setFieldError(`.asalbrg${i} .form-check-input`, errorasal.length ? errorasal[i - 1] : null);
            util.setFieldError(`#hargabeli${i}`, errors[`harga_beli.${i - 1}`]);
            util.setFieldError(`#hargajual${i}`, errors[`harga_jual.${i - 1}`]);
            util.setFieldError(`#lokasi${i}`, errors[`ruang_id.${i - 1}`]);
            util.setFieldError(`#jmlmasuk${i}`, errors[`jumlah_masuk.${i - 1}`]);
            util.setFieldError(`#satuan${i}`, errors[`satuan_id.${i - 1}`]);
        }
    }

    const setUpImageLoader = () => {
        return $('#imageLoader').attr({
            'data-type': 'imagesloader',
            'data-errorformat': 'Format file yang diizinkan',
            'data-errorsize': 'Ukuran maksimum yang diizinkan',
            'data-errorduplicate': 'File sudah diunggah',
            'data-errormaxfiles': 'Jumlah maksimal gambar yang dapat diunggah',
            'data-errorminfiles': 'Jumlah minimum gambar yang harus diunggah',
            'data-modifyimagetext': 'Modifikasi gambar'
        });
    }

    let imagesloader; // Deklarasi global
    const initUploadPhotos = (imagesToLoad) => {
        setUpImageLoader();
        imagesloader = $('[data-type=imagesloader]').imagesloader({
            minSelect: 1,
            imagesToLoad: imagesToLoad || [], // default to empty array if null
            maxSize: 2000 * 1024, // 2MB
            maxFiles: 5,
        });
        // return imagesloader;
    }

    // Utility function to handle file uploads
    const handleFileUploads = (formData, files) => {
        for (const fileObj of files) {
            if (fileObj.File) {
                formData.append('files[]', fileObj.File);
            }
        }
    };

    // Utility function to prepare and submit AJAX request
    const submitForm = (datas, callback) => {
        crud.submitAjax(datas, callback);
    };

    const submitUpload = (form, event) => {
        event.preventDefault();
        let formData = new FormData(form);
        let files = imagesloader.data('format.imagesloader').AttachmentArray;
        handleFileUploads(formData, files);
        const datas = {
            url: `${nav}/simpanupload`,
            data: formData,
            enctype: 'multipart/form-data',
        };
        const callback = (response) => {
            if (response.error) {
                Swal.fire('Terjadi Kesalahan!', response.error, 'error');
            } else {
                $(".tooltip").hide();
                $('#modalForm').modal('hide');
                const tables = [tableBrgTetap, tableAlokasiBrg, tableBrgPersediaan];
                util.handleSubmitSuccess(response.success, tables);
            }
        };

        submitForm(datas, callback);
    };

    const submitReport = (form, event, urlDetailBrg) => {
        event.preventDefault();
        let formData = new FormData(form);
        const datas = {
            url: `${nav}/simpan-laporan`,
            data: formData,
            enctype: 'multipart/form-data',
        };
        let files = imagesloader.data('format.imagesloader').AttachmentArray;
        handleFileUploads(formData, files);
        const callback = (response) => {
            const fields = ["anggota_id", "jml_barang", "deskripsi"];
            if (response.error) {
                util.handleValidationErrors(fields, response.error);
                Swal.fire('Terjadi Kesalahan!', response.error, 'error');
            } else {
                reportAssets.defaulthide();
                Swal.fire('Berhasil!', response.success, 'success').then(() => {
                    updateReportOptions(response.laporan_id, urlDetailBrg);
                });
            }
        };
        submitForm(datas, callback);
    };

    const updateReport = (form, event, urlDetailBrg) => {
        event.preventDefault();
        let laporan_id = $(form).find('[name="id"]').val()
        let formData = new FormData(form);

        const datas = {
            url: `${BASE_URL}/laporan-kerusakan-aset/update-laporan/${laporan_id}`,
            data: formData,
            enctype: 'multipart/form-data',
        };
        let files = imagesloader.data('format.imagesloader').AttachmentArray;
        handleFileUploads(formData, files);
        const callback = (response) => {
            const fields = ["anggota_id", "jml_barang", "deskripsi"];
            if (response.error) {
                util.handleValidationErrors(fields, response.error);
                Swal.fire('Terjadi Kesalahan!', response.error, 'error');
            } else {
                $(".tooltip").hide();
                $('#formeditlaporan').hide(500);
                $('#opsiubahlaporan').empty();
                Swal.fire('Berhasil!', response.success, 'success').then(() => {
                    updateReportOptions(response.laporan_id, urlDetailBrg);
                });
            }
        };
        submitForm(datas, callback);
    };
    // Function to update report options
    function updateReportOptions(laporan_id, urlDetailBrg) {
        $('#opsiubahlaporan').empty().html(`
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
                            <br><br>
                            <a href="${BASE_URL}/laporan-kerusakan-aset/edit-laporan/${laporan_id}" class="text-decoration-underline">Ubah laporan anda</a>
                            <br>
                            <a href="${BASE_URL}${urlDetailBrg}" class="text-decoration-underline">&laquo; Kembali ke halaman detail barang</a>
                        </div>
                    </div>
                </div>
            </div>
        `).show(500);
    }
    const downloadTemplate = (form, event) => crud.handlePrintSubmit(form, event);

    return {
        handleAddRow, looping, closeBtnMultiple, insertMultiple,
        initUploadPhotos, submitUpload, submitReport, updateReport,
        downloadTemplate
    }
})()