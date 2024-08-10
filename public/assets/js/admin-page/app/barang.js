import { crud } from "./crud.js";

const barang = (() => {
    let tableRestore;
    const listData = (selector, ajaxUrl) => {
        var jenis_kat = selector == "table-brgpersediaan" ? "Barang Persediaan" : "Barang Tetap";
        var isRestore = selector == "table-restore" ? 1 : 0;

        return $('#' + selector).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: ajaxUrl,
                headers: {
                    authorization: `Bearer ${token}`
                },
                data: function (d) {
                    d.barang = $('#selectbarang').val()
                    d.kategori = $('#selectkategori').val()
                },
                dataSrc: function (json) {
                    json.data.forEach(function (item) {
                        item.id = item.id;
                    });
                    return json.data;
                }
            },
            createdRow: function (row, data, dataIndex) {
                // Get the tab id from the data-table attribute of the table
                var tableTabId = $(this).attr('data-tab-id');

                // Add the respective class based on the tab id to the row
                $(row).find("td input[type='checkbox']").addClass('checkrow-' + tableTabId);
            },
            order: [],
            columns: [{
                data: 'checkrow',
                orderable: false,
                visible: isRestore ? false : true, // menghilangkan tanda kutip di sini
            },
            {
                data: 'no',
                orderable: false
            },
            {
                data: null,
                render: function (data, type, row) {
                    return '<div id="qrcode-' + row.id + '" class="qrcode_barang"></div>';
                },
                visible: jenis_kat == "Barang Persediaan" || isRestore ? false :
                    true, // menghilangkan tanda kutip di sini
                orderable: false,
                searchable: false,
            },
            {
                data: 'kode_brg'
            },
            {
                data: 'nama_brg',
            },
            {
                data: 'asal',
                render: function (data, type, row) {
                    var place = row.toko ? `di ${row.toko}` : `dari ${row.instansi}`;
                    return `${data} ${place}`;
                }
            },
            {
                data: 'warna',
                render: function (data) {
                    return capitalize(data);
                }
            },
            {
                data: 'jumlah_keluar',
                render: function (data, type, row) {
                    return `${data !== '0' ? `${data} ${row.kd_satuan}` : `0`} `;
                }
            },
            {
                data: 'sisa_stok',
                render: function (data, type, row) {
                    if (jenis_kat == "Barang Persediaan") {
                        return parseInt(data) <= 3 ?
                            `<span class="fw-bold" style="color: red; background-color: rgba(252, 255, 0, 0.5)">${data !== '0' ? `${data} ${row.kd_satuan}*` : `0`}</span>` :
                            `${data} ${row.kd_satuan}`;
                    } else {
                        return `${data !== '0' ? `${data} ${row.kd_satuan}` : `0`} `;
                    }
                }
            },
            {
                data: 'nama_ruang'
            },

            {
                data: (!isRestore) ? 'created_at' : 'deleted_at',
                render: renderFormatTime
            },
            {
                data: 'action',
                orderable: false
            },
            ],
            drawCallback: function (settings) {
                if (jenis_kat !== "Barang Persediaan") {
                    var api = this.api();
                    api.rows().every(function (rowIdx, tableLoop, rowLoop) {
                        var rowData = this.data();
                        var id = rowData.id;
                        var kodebarang = rowData.kode_brg;
                        var loc_id = rowData.ruang_id;
                        const kdbrg = kodebarang.split(".").join("-");
                        const logo = `${BASE_URL}/assets/images/logo/logounira.jpg`;

                        const icon = new Image();
                        icon.onload = function () {
                            // create qr code with logo
                            var qrcode = new QRCode(document.getElementById('qrcode-' + id), {
                                text: `${BASE_URL}/detail-barang/${kdbrg}-${loc_id}`,
                                width: 200,
                                height: 200,
                                correctLevel: QRCode.CorrectLevel.H,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                            });
                            util.imgQR(qrcode._oDrawing._elCanvas, this, 0.2);
                        }
                        icon.src = logo;
                    });
                }
            },
        });
    }

    const detail = (kd_brg, ruang_id) => {
        const kdbrg = kd_brg.split(".").join("-");
        const loc_id = ruang_id;

        window.location.href = `/detail-barang/${kdbrg}-${loc_id}`;
    }

    const cetakLabel = (id) => {
        const datas = {
            url: `${nav}/tampillabelbarang`,
            view: "modal",
            modalId: "modallabel",
            method: "POST",
            data: {
                id, nav
            },
        }
        crud.getForm(datas);
    }

    const downloadLabelImg = () => {
        html2canvas(card).then(function (canvas) {
            // Convert the canvas to an image data URL
            var dataURL = canvas.toDataURL('image/png');
            // Create a download link
            var downloadLink = document.createElement('a');
            downloadLink.href = dataURL;
            downloadLink.download = `label-${kdbrg}-${idlokasi}.png`;
            // Trigger the download
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        });
    }

    const downloadLabelPdf = () => {
        // Menampilkan tombol loading
        $('#cetakpdf').attr('disabled', 'disabled');
        $('#cetakpdf').html('<i class="fa fa-spin fa-spinner"></i> Loading...');

        var qty = parseInt($('#qty-input').val())
        var canvasArray = [];

        for (let i = 0; i < qty; i++) {
            var canvas = document.createElement('canvas');
            canvas.willReadFrequently = true;
            canvas.width = 400;
            canvas.height = 400;
            canvasArray.push(canvas);
        }

        var promises = [];
        for (let i = 0; i < qty; i++) {
            var canvas2 = canvasArray[i];
            var ctx = canvas2.getContext('2d');
            var scale = canvas2.width / card.clientWidth / 1.3;
            ctx.scale(scale, scale);
            ctx.imageSmoothingQuality = "High";
            promises.push(html2canvas(card, {
                canvas: canvas2,
                width: card.clientWidth,
                height: card.clientHeight,
                scale: scale,
                dpi: 96,
            }));
        }

        Promise.all(promises).then(function () {
            var docDefinition = {
                pageSize: 'A4',
                pageMargins: [10, 10, 10, 10],
                pageOrientation: 'portrait',
                content: []
            };
            var images = [];
            for (let i = 0; i < qty; i++) {
                images.push({
                    image: canvasArray[i].toDataURL('image/png'),
                    width: 130,
                    margin: [0, 0, 0, 0],
                });
            }

            var content = [];
            for (let i = 0; i < qty; i += 7) {
                var row = [];
                for (let j = i; j < i + 7 && j < qty; j++) {
                    row.push(images[j]);
                }
                content.push({
                    columns: row,
                    columnGap: -50,
                    margin: [0, 0, 0, -20]
                });
            }

            docDefinition.content = content;

            // Menghilangkan tombol loading dan mengembalikan teks tombol
            $('#cetakpdf').removeAttr('disabled');
            $('#cetakpdf').html('Cetak PDF');

            pdfMake.createPdf(docDefinition).download(`labels-${kdbrg}-${idlokasi}.pdf`);
        });
    }

    const formTambahBaru = () => {
        let title = jenistrx;
        saveMethod = "add";

        const datas = {
            url: `${nav}/tampiltambahbarang`,
            method: "POST",
            data: {
                title, nav, saveMethod
            }
        }

        crud.getForm(datas);
    }

    const formTambahStok = () => {
        const datas = {
            method: "POST",
            url: `${nav}/tampiltambahstok`,
            data: {
                title, nav
            }
        }

        crud.getForm(datas);
    }

    const edit = (id) => {
        const saveMethod = "update";
        const datas = {
            method: "POST",
            url: `${nav}/tampileditform`,
            data: {
                id, title, nav, saveMethod
            }
        }

        crud.getForm(datas);
    }

    const upload = (id, nama_brg, path_foto, foto_barang) => {
        const datas = {
            method: "POST",
            url: `${nav}/tampilcardupload`,
            view: "modal", modalId: "modalForm",
            data: {
                id, nama_brg, path_foto, foto_barang
            }
        }
        crud.getForm(datas);
    }

    const hapus = (id, jenis_kat, nama_brg, namaruang) => {
        const tables = [tableBrgTetap, tableBrgPersediaan, tableAlokasiBrg];
        let data = JSON.stringify({ id, jenis_kat });
        let titleText = `Apakah kamu yakin ingin menghapus data ${nama_brg} di ${namaruang}?`;
        crud.handleDelete(`${nav}/hapus`, data, titleText, tables, "temporary");
    }

    const hapusMultiple = (form, event) => {
        let selectedRows = $('td input[type="checkbox"]:checked');
        const className = selectedRows.attr('class');
        var keterangan;
        if (className == "checkrow-brgpersediaan") {
            keterangan = "Barang Persediaan";
        } else if (className == "checkrow-brgtetap") {
            keterangan = "Barang Tetap";
        } else if (className == "checkrow-alokasibrg") {
            keterangan = "Alokasi Barang Tetap";
        }
        const tables = [tableBrgTetap, tableBrgPersediaan, tableAlokasiBrg];
        crud.handleMultipleDelete(form, event, tables, `.${className}`, '', keterangan);
    }

    const hapusPermanen = (id, ruangId, barangId, namabrg, namaruang) => {
        let data = JSON.stringify({ id, ruangId, barangId });
        let text = 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!';
        let url = `${nav}/hapuspermanen`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${namabrg} di ${namaruang} secara permanen?`, tableRestore, "permanent", text);
    }

    const hapusPermanenAll = () => {
        var api = tableRestore.rows();
        var id = api.data().toArray().map(function (d) {
            return d.id;
        });
        var ruang_id = api.data().toArray().map(function (d) {
            return d.ruang_id;
        })
        var barang_id = api.data().toArray().map(function (d) {
            return d.barang_id;
        })
        let data = JSON.stringify({
            id: id.join(","),
            barangId: barang_id.join(","),
            ruangId: ruang_id.join(","),
        });
        crud.handleDeleteAll(tableRestore, '', '', data)
    }

    const transferBarang = () => {
        let selectedRows = $('td input[type="checkbox"]:checked');
        if (selectedRows.length > 0 && selectedRows.attr('class') !== "checkrow-brgpersediaan") {
            let selectedIds = $('td:nth-child(1) input[type="checkbox"]:checked').map(function () {
                return $(this).val();
            }).get();
            let jmldata = selectedIds.length;
            const datas = {
                method: "POST",
                url: `${nav}/tampiltransferform`,
                view: "modal",
                modalId: "modaltransfer",
                data: {
                    ids: selectedIds.join(","),
                    jmldata: jmldata,
                }
            }
            crud.getForm(datas);
        } else {
            var text = selectedRows.attr('class') == "checkrow-brgpersediaan" ? 'Tidak dapat melakukan transfer barang' :
                'Tidak ada data yang dipilih';
            Swal.fire(
                'Perhatian!',
                text,
                'warning'
            );
        }
    }

    const tampilExportExcel = () => {
        let title = "Download Template Excel";
        const datas = {
            method: "POST",
            url: `${nav}/tampilexportexcel`,
            data: {
                title, nav
            }
        }
        crud.getForm(datas);
    }

    const tampilImportExcel = () => {
        let title = "Input Barang Via Excel";
        const datas = {
            url: `${nav}/tampilimportexcel`,
            view: "modal",
            method: "POST",
            modalId: "modalimportexcel",
            data: {
                title, nav
            }
        }
        crud.getForm(datas);
    }

    const uploadExcel = (form, event) => {
        event.preventDefault();
        let formData = new FormData(form);

        $.ajax({
            type: "post",
            url: `${nav}/simpandataexcel`,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="csrf_test_name"]').value,
                'authorization': `Bearer ${token}`
            },
            dataType: "json",
            beforeSend: function () {
                $('.btnsimpan').attr('disable', 'disabled');
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $('.btnsimpan').removeAttr('disable');
                $('.btnsimpan').html('<i class="fa fa-upload"></i> Upload');
            },
            success: function (response) {
                const fields = ['file'];
                if (response.error) {
                    util.handleValidationErrors(fields, response.error);
                } else {
                    $(`#modalimportexcel`).modal('hide');
                    const tables = [tableBrgTetap, tableBrgPersediaan];
                    util.handleSubmitSuccess(response.success, tables);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    const viewTableRestore = () => {
        function callback() {
            tableRestore = listData('table-restore', `${nav}/listdatabarang?isRestore=1`);
        }
        crud.handleViewRestore(title.toLowerCase(), callback)
    }

    const restore = (id, ruangId, barangId, nama_brg, nama_ruang) => {
        let data = JSON.stringify({ id, nama_brg, nama_ruang, ruangId, barangId });
        let title = `Memulihkan data ${nama_brg} di ${nama_ruang}?`
        crud.handleRestore(data, title, tableRestore, "restore");
    }

    const restoreAll = () => crud.handleRestoreAll(tableRestore, true, '', '', '')

    const selectItem = () => {
        util.selectReload();
    }

    const selectCategory = () => {
        util.selectReload();
    }

    const navLink = (form) => {
        // Hide all tab content
        $('.tab-pane').removeClass('show active');
        // Show the corresponding tab content based on the clicked tab
        var targetTab = $(form).attr('href');
        $(targetTab).addClass('show active');
        // Redraw the DataTable for the current tab to load the data from the server
        util.checkrowDef(tabId);
        $("table tbody tr td").removeClass("select_warna");
        $('#checkall1, #checkall2, #checkall3').prop('checked', false)
        if (targetTab === '#brgtetap') {
            tableBrgTetap.ajax.reload();
            util.filteringData('Barang Tetap');
        } else if (targetTab === '#alokasibrg') {
            tableAlokasiBrg.ajax.reload();
            util.filteringData('Barang Tetap');
        } else if (targetTab === '#brgpersediaan') {
            tableBrgPersediaan.ajax.reload();
            util.filteringData('Barang Persediaan');
        }
    }

    const isDuplicate = (idbrg, fieldsToReset, row) => {
        if (idbrgSet.has(idbrg)) {
            Swal.fire({
                icon: 'info',
                text: 'Nama barang sudah dimasukkan sebelumnya! Sistem akan mengosongkan input barang.',
            }).then((result) => {
                fieldsToReset.forEach((val) => {
                    if (val == "idbrg" || val == "barang_id") {
                        $(`#${val}${row}`).html('');
                    }
                    $(`#${val}${row}`).val("")
                })
            });
        } else {
            idbrgSet.add(idbrg);
        }
    }

    const checkRuangBrg = (data, successCallback) => {
        $.ajax({
            type: "post",
            url: `${nav}/cekbrgdanruang`,
            headers: { 'authorization': `Bearer ${token}` },
            data,
            dataType: "json",
            success: successCallback
        });
    }

    return {
        checkRuangBrg,
        isDuplicate,
        edit,
        hapus,
        detail,
        upload,
        restore,
        navLink,
        listData,
        cetakLabel,
        selectItem,
        restoreAll,
        uploadExcel,
        hapusMultiple,
        hapusPermanen,
        formTambahBaru,
        selectCategory,
        formTambahStok,
        transferBarang,
        viewTableRestore,
        hapusPermanenAll,
        downloadLabelImg,
        downloadLabelPdf,
        tampilExportExcel,
        tampilImportExcel,
    }
})();

export { barang };