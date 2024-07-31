import { crud } from "./crud.js";

export const kategori = (() => {
    let tableRestore;
    let subkode1, subkode2, subkode3, subkode4;

    const listData = (selector, url) => {
        var jenis_kat = selector == "table-kpersediaan" ? "Barang Persediaan" : "Barang Tetap";
        var isRestore = selector == "table-restore" ? 1 : 0;
        const columns = [
            { data: 'no', orderable: false },
            { data: 'kd_kategori' },
            { data: 'nama_kategori' },
            {
                data: 'deskripsi',
                visible: jenis_kat == "Barang Tetap" ? true : false,
            },
            { data: isRestore ? 'deleted_by' : 'created_by', },
            {
                data: isRestore ? 'deleted_at' : 'created_at',
                render: renderFormatTime
            },
            { data: 'action', orderable: false },
        ]
        return crud.initDataTable(selector, url, columns);
    };
    const viewTableRestore = () => {
        function callback() {
            tableRestore = listData('table-restore', `${nav}/listdata?isRestore=1`);
        }
        crud.handleViewRestore(title.toLowerCase(), callback)
    }
    const getForm = (saveMethod, jenis, id) => {
        const datas = {
            url: `${nav}/tampilform`,
            method: "POST",
            data: {
                saveMethod, jenis, id
            }
        };
        crud.getForm(datas);
    }
    const fillForm = (data, form) => {
        var kode = data.kd_kategori; // kode yang akan dipisahkan
        var subkode = kode.split('.'); // memisahkan kode dengan tanda titik
        var jenis = data.jenis;
        var kode1 = subkode[0]; // mendapatkan subkode 1
        var kode2 = subkode[1]; // mendapatkan subkode 2
        getSubkode1(jenis, kode1);
        getSubkode2(kode1, kode2);
        if (jenis == "Barang Tetap") {
            var kode3 = subkode[2]; // mendapatkan subkode 3
            var kode4 = subkode[3]; // mendapatkan subkode 4
            getSubkode3(kode1, kode2, kode3);
            getSubkode4(kode1, kode2, kode3, kode4);
        }
        crud.fillForm(data, form, [
            ['id', 'id'],
            ['kd_kategori', 'kd_kategori'],
            ['nama_kategori', 'nama_kategori'],
            ['deskripsi', 'deskripsi'],
        ]);
    };
    const submit = (form, event) => crud.handleFormSubmit(form, event, [tableKatTetap, tableKatPersediaan]);
    const hapus = (id, nama_kategori) => {
        let data = JSON.stringify({ id, nama_kategori });
        let url = `${nav}/hapus/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_kategori}?`, [tableKatTetap, tableKatPersediaan], "temporary");
    }
    const restore = (id, nama_kategori) => {
        let data = JSON.stringify({ id, nama_kategori });
        let title = `Memulihkan data ${nama_kategori}?`
        crud.handleRestore(data, title, tableRestore, "restore")
    }
    const restoreAll = () => crud.handleRestoreAll(tableRestore, false)
    const hapusPermanen = (id, nama_kategori) => {
        let data = JSON.stringify({ id, nama_kategori });
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        let url = `${nav}/hapuspermanen/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_kategori} secara permanen?`, tableRestore, "permanent", text);
    }
    const hapusPermanenAll = () => {
        crud.handleDeleteAll(tableRestore);
    }
    const fetchData = (datas, callback) => {
        $.ajax({
            url: datas.url,
            data: datas.data,
            type: datas.type,
            dataType: "json",
            success: callback,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
    const getSubkode1 = (jenis, kode1) => {
        let url = `${nav}/getsubkode1`;
        const datas = {
            url,
            data: { jenis },
            type: "POST",
        };
        function callback(response) {
            $('#subkode1').empty();
            $('#subkode1').append('<option value="">SubKode 1</option>');
            $.each(response, function (key, value) {
                $('#subkode1').append('<option value="' + value.subkode1 + '">' + value.subkode1 + '</option>');
            });
            $('#subkode1').append('<option value="other1">Lainnya</option>');

            if (kode1 !== undefined) {
                $("#subkode1 option").each(function () {
                    if ($(this).val() === kode1) {
                        $(this).attr("selected", "selected");
                    }
                });
            }
        }
        fetchData(datas, callback);
    }
    const getSubkode2 = (subkode1, kode2) => {
        let url = `${nav}/getsubkode2`;
        const datas = {
            url,
            data: { subkode1 },
            type: "POST",
        };
        function callback(response) {
            $('#subkode2').empty();
            $('#subkode2').append('<option value="">SubKode 2</option>');
            $.each(response, function (key, value) {
                $('#subkode2').append('<option value="' + value.subkode2 + '">' + value.subkode2 + '</option>');
            });
            $('#subkode2').append('<option value="other2">Lainnya</option>');
            if (kode2 !== undefined) {
                $("#subkode2 option").each(function () {
                    if ($(this).val() === kode2) {
                        $(this).attr("selected", "selected");
                    }
                });
            }
        }

        fetchData(datas, callback);
    }
    const getSubkode3 = (subkode1, subkode2, kode3) => {
        let url = `${nav}/getsubkode3`;
        const datas = {
            url,
            data: { subkode1, subkode2 },
            type: "POST",
        };
        function callback(response) {
            $('#subkode3').empty();
            $('#subkode3').append('<option value="">SubKode 3</option>');
            for (var i = 0; i < response.length; i++) {
                if (response[i].subkode3 != '') {
                    $('#subkode3').append('<option value="' + response[i].subkode3 + '">' + response[i].subkode3 + '</option>');
                }
            }
            $('#subkode3').append('<option value="other3">Lainnya</option>');
            if (kode3 !== undefined) {
                $("#subkode3 option").each(function () {
                    if ($(this).val() === kode3) {
                        $(this).attr("selected", "selected");
                    }
                });
            }
        }

        fetchData(datas, callback);
    }
    const getSubkode4 = (subkode1, subkode2, subkode3, kode4) => {
        let url = `${nav}/getsubkode4`;
        const datas = {
            url,
            data: { subkode1, subkode2, subkode3 },
            type: "POST",
        };
        function callback(response) {
            $('#subkode4').empty();
            $('#subkode4').append('<option value="">SubKode 4</option>');
            $.each(response, function (key, value) {
                $('#subkode4').append('<option value="' + value.subkode4 + '">' + value.subkode4 + '</option>');
            });
            $('#subkode4').append('<option value="other4">Lainnya</option>');

            if (kode4 !== undefined) {
                $("#subkode4 option").each(function () {
                    if ($(this).val() === kode4) {
                        $(this).attr("selected", "selected");
                    }
                });
            }
        }

        fetchData(datas, callback);
    }
    const handleSubkode1Change = (form, jenis) => {
        subkode1 = $(form).val();
        util.rmIsInvalid("kd_kategori");
        util.rmIsInvalid("nama_kategori");
        if (subkode1 === 'other1') {
            $('#subkode1-other').show();
            $('#kd_kategori').val('');
            $('#subkode1-other').on('keyup', function () {
                validateInputOther($(form), $('#subkode1-other'))
                getSubkodeOther($('#subkode1-other').val());
                if ($('#subkode1-other').val() == '') {
                    $('#subkode1-other').removeClass('is-invalid');
                    $('#subkode1-other').next().html('');
                }
            });
        } else {
            $('#subkode1-other').hide();
            getSubkodeOther(subkode1);
        }
        autoFillName(jenis, subkode1);
        getSubkode2(subkode1);
    }
    const handleSubkode2Change = (form, jenis) => {
        subkode2 = $(form).val();
        if (subkode2 === 'other2') {
            $('#subkode2-other').show();
            $('#kd_kategori').val('');
            $('#nama_kategori').val('');
            $('#deskripsi').val('');
            $('#subkode2-other').on('keyup', function () {
                validateInputOther($('#subkode2'), $('#subkode2-other'))
                getSubkodeOther($('#subkode2-other').val());
                if ($('#subkode2-other').val() == '') {
                    $('#subkode2-other').removeClass('is-invalid');
                    $('#subkode2-other').next().html('');
                }
                if (subkode1 !== 'other1') {
                    getSubkodeOther(subkode1, $('#subkode2-other').val());
                } else {
                    getSubkodeOther($('#subkode1-other').val(), $('#subkode2-other').val());
                }
            });
        } else {
            $('#subkode2-other').hide();
            getSubkodeOther(subkode1, subkode2);
            autoFillName(jenis, subkode1, subkode2);
        }
        if (jenis == "Barang Tetap") {
            getSubkode3(subkode1, subkode2);
        }
    }
    const handleSubkode3Change = (form, jenis) => {
        subkode3 = $(form).val();

        if (subkode3 === 'other3') {
            $('#subkode3-other').show(); // menampilkan form input
            $('#nama_kategori').val('');
            $('#kd_kategori').val('');
            $('#deskripsi').val('');
            $('#subkode3-other').on('keyup', function () {
                validateInputOther($(form), $('#subkode3-other'))
                getSubkodeOther($('#subkode3-other').val());
                if ($('#subkode3-other').val() == '') {
                    $('#subkode3-other').removeClass('is-invalid');
                    $('#subkode3-other').next().html('');
                }
                if (subkode1 !== 'other1' && subkode2 !== 'other2') {
                    getSubkodeOther(subkode1, subkode2, $('#subkode3-other').val());
                } else if (subkode1 !== 'other1' && subkode2 == 'other2') {
                    getSubkodeOther(subkode1, $('#subkode2-other').val(), $('#subkode3-other').val());
                } else {
                    getSubkodeOther($('#subkode1-other').val(), $('#subkode2-other').val(), $('#subkode3-other').val());
                }
            });
        } else {
            $('#subkode3-other').hide(); // menyembunyikan form input
            getSubkodeOther(subkode1, subkode2, subkode3);
            autoFillName(jenis, subkode1, subkode2, subkode3);
        }

        getSubkode4(subkode1, subkode2, subkode3);
    }
    const handleSubkode4Change = (form, jenis) => {
        subkode4 = $(form).val();
        if (subkode4 === 'other4') {
            $('#subkode4-other').show();
            $('#nama_kategori').val('');
            $('#kd_kategori').val('');
            $('#deskripsi').val('');
            $('#subkode4-other').on('keyup', function () {
                if (subkode1 !== 'other1' && subkode2 !== 'other2' && subkode3 !== 'other3') {
                    getSubkodeOther(subkode1, subkode2, subkode3, $('#subkode4-other').val());
                } else if (subkode1 !== 'other1' && subkode2 !== 'other2', subkode3 == 'other3') {
                    getSubkodeOther(subkode1, subkode2, $('#subkode3-other').val(), $('#subkode4-other').val());
                } else if (subkode1 !== 'other1' && subkode2 == 'other2', subkode3 == 'other3') {
                    getSubkodeOther(subkode1, $('#subkode2-other').val(), $('#subkode3-other').val(), $('#subkode4-other').val());
                } else {
                    getSubkodeOther($('#subkode1-other').val(), $('#subkode2-other').val(), $('#subkode3-other').val(), $('#subkode4-other').val());
                }
            });
        } else {
            $('#subkode4-other').hide(); // menyembunyikan form input
            getSubkodeOther(subkode1, subkode2, subkode3, subkode4);
            autoFillName(jenis, subkode1, subkode2, subkode3, subkode4);
        }
    }
    const getSubkodeOther = (skother1, skother2, skother3, skother4) => {
        var subkd1other = (typeof skother1 !== 'undefined') ? skother1 : '';
        var subkd2other = (typeof skother2 !== 'undefined') ? skother2 : '';
        var subkd3other = (typeof skother3 !== 'undefined') ? skother3 : '';
        var subkd4other = (typeof skother4 !== 'undefined') ? skother3 : '';

        if (subkd2other == '' && subkd3other == '' && subkd4other == '') {
            $('#kd_kategori').val(`${subkd1other}`)
        } else if (subkd3other == '' && subkd4other == '') {
            $('#kd_kategori').val(`${subkd1other}.${subkd2other}`)
        } else if (subkd4other == '') {
            $('#kd_kategori').val(`${subkd1other}.${subkd2other}.${subkd3other}`)
        } else {
            $('#kd_kategori').val(`${subkd1other}.${subkd2other}.${subkd3other}.${subkd4other}`)
        }
    }
    const autoFillName = (jenis, subkd1, subkd2, subkd3, subkd4) => {
        // periksa apakah nilai undefined
        subkd1 = (typeof subkd1 !== 'undefined' && subkd1 !== 'other1') ? subkd1 : '';
        subkd2 = (typeof subkd2 !== 'undefined' && subkd2 !== 'other2') ? subkd2 : '';
        subkd3 = (typeof subkd3 !== 'undefined' && subkd3 !== 'other3') ? subkd3 : '';
        subkd4 = (typeof subkd4 !== 'undefined' && subkd4 !== 'other4') ? subkd4 : '';
        $.ajax({
            type: "post",
            url: `${nav}/getnamakategori`,
            data: {
                subkode1: subkd1,
                subkode2: subkd2,
                subkode3: subkd3,
                subkode4: subkd4,
                jenis,
            },
            dataType: "json",
            success: function (response) {
                if (response != null) {
                    $('#nama_kategori').val(response.nama_kategori)
                    $('#deskripsi').val(response.deskripsi)
                } else {
                    $('#nama_kategori').val('')
                    $('#deskripsi').val('')
                }
            }
        });
    }

    function validateInputOther(skd, skdother) {
        const skdothervalue = skdother.val();
        // Mendapatkan opsi-opsi pada select #subkode2
        const skdoption = skd.find('option');
        // Memeriksa apakah nilai yang dimasukkan pengguna sudah ada pada opsi select #subkode2
        for (let i = 0; i < skdoption.length; i++) {
            const subkodeOption = $(skdoption[i]);
            if (subkodeOption.val() === skdothervalue) {
                // Jika nilai sudah ada, munculkan peringatan error pada input text #subkode2-other
                skdother.addClass('is-invalid');
                skdother.next().html(`${$(skdoption[0]).text()} sudah ada`);
                return;
            }
        }
        // Jika nilai belum ada, hapus peringatan error pada input text #subkode2-other
        skdother.removeClass('is-invalid');
        skdother.next().html('');
    }

    const getElementSubKode3dan4 = () => {
        return $('.subkodekategori').append(`
            <div class="col-sm-3 position-relative subkdtetap">
              <div class="input-group has-validation">
                <span class="input-group-text" id="basic-addon1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-3-square" viewBox="0 0 16 16">
                    <path d="M7.918 8.414h-.879V7.342h.838c.78 0 1.348-.522 1.342-1.237 0-.709-.563-1.195-1.348-1.195-.79 0-1.312.498-1.348 1.055H5.275c.036-1.137.95-2.115 2.625-2.121 1.594-.012 2.608.885 2.637 2.062.023 1.137-.885 1.776-1.482 1.875v.07c.703.07 1.71.64 1.734 1.917.024 1.459-1.277 2.396-2.93 2.396-1.705 0-2.707-.967-2.754-2.144H6.33c.059.597.68 1.06 1.541 1.066.973.006 1.6-.563 1.588-1.354-.006-.779-.621-1.318-1.541-1.318Z"></path>
                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
                  </svg>
                </span>
                <select class="form-select" id="subkode3" onChange="kategori.handleSubkode3Change(this, $('#jenis').val())"></select>
                <input type="number" class="form-control" placeholder="opsi lain" id="subkode3-other" style="display: none;">
                <div class="invalid-feedback errsk3"></div>
              </div>
            </div>
            <div class="col-sm-3 position-relative subkdtetap">
              <div class="input-group has-validation">
                <span class="input-group-text" id="basic-addon1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-4-square" viewBox="0 0 16 16">
                    <path d="M7.519 5.057c.22-.352.439-.703.657-1.055h1.933v5.332h1.008v1.107H10.11V12H8.85v-1.559H4.978V9.322c.77-1.427 1.656-2.847 2.542-4.265ZM6.225 9.281v.053H8.85V5.063h-.065c-.867 1.33-1.787 2.806-2.56 4.218Z"></path>
                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2Zm15 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2Z"></path>
                  </svg>
                </span>
                <select class="form-select" id="subkode4" onChange="kategori.handleSubkode4Change(this, $('#jenis').val())"></select>
                <input type="number" class="form-control" placeholder="opsi lain" id="subkode4-other" style="display: none;">
                <div class="invalid-feedback errsk4"></div>
              </div>
            </div>
            `);
    }

    const handleNavLink = () => {
        // Hide all tab content
        $('.tab-pane').removeClass('show active');
        // Show the corresponding tab content based on the clicked tab
        var targetTab = $(this).attr('href');
        $(targetTab).addClass('show active');
        // Redraw the DataTable for the current tab to load the data from the server
        if (targetTab === '#ktetap') {
            tableKatTetap.ajax.reload();
        } else if (targetTab === '#kpersediaan') {
            tableKatPersediaan.ajax.reload();
        }
    }

    return {
        handleNavLink,
        hapus,
        hapusPermanen,
        hapusPermanenAll,
        submit,
        restore,
        restoreAll,
        fillForm,
        listData,
        getForm,
        getSubkode1,
        getSubkode2,
        getSubkode3,
        getSubkode4,
        getSubkodeOther,
        handleSubkode1Change,
        handleSubkode2Change,
        handleSubkode3Change,
        handleSubkode4Change,
        getElementSubKode3dan4,
        viewTableRestore,
        autoFillName,
    }
})()