import { util } from "./util.js";

const barang = (() => {
    const listDataBarang = (tableId, ajaxUrl) => {
        var jenis_kat = tableId == "table-brgpersediaan" ? "Barang Persediaan" : "Barang Tetap";
        var isRestore = tableId == "table-restore" ? 1 : 0;

        return $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: ajaxUrl,
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
                    return '<div id="qrcode-' + row.id + '"></div>';
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
                    console.log(place);
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
                render: function (data, type, full, meta) {
                    var dateParts = data.split(/[- :]/);
                    var year = parseInt(dateParts[0]);
                    var month = parseInt(dateParts[1]) - 1;
                    var day = parseInt(dateParts[2]);
                    var hours = parseInt(dateParts[3]);
                    var minutes = parseInt(dateParts[4]);
                    var seconds = parseInt(dateParts[5]);
                    var options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var formattedDate = new Date(year, month, day, hours, minutes, seconds)
                        .toLocaleDateString('id-ID', options);
                    return `${!isRestore ? `Dibuat oleh ${full.created_by}` : `Dihapus oleh ${full.deleted_by}`} pada ${formattedDate}`;
                }
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

        window.location.href = `${nav}/detail-barang/${kdbrg}-${loc_id}`;
    }

    const cetakLabel = (id) => {
        const datas = {
            url: `${nav}/tampillabelbarang`,
            view: "modal",
            modalId: "modallabel",
            data: {
                id, nav
            },
        }
        util.getCardOrModal(datas);
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
            data: {
                title, nav, saveMethod
            }
        }

        util.getCardOrModal(datas);
    }

    const formTambahStok = () => {
        const datas = {
            url: `${nav}/tampiltambahstok`,
            data: {
                title, nav
            }
        }

        util.getCardOrModal(datas);
    }

    const edit = (id) => {
        const saveMethod = "update";
        const datas = {
            url: `${nav}/tampileditform`,
            data: {
                id, title, nav, saveMethod
            }
        }

        util.getCardOrModal(datas);
    }

    const upload = (id, nama_brg, foto_barang) => {
        const datas = {
            url: `${nav}/tampilcardupload`,
            data: {
                id, nama_brg, nav, foto_barang
            }
        }
        util.getCardOrModal(datas);
    }

    const swalHapus = (datas) => {
        Swal.fire({
            title: datas.title,
            icon: 'warning',
            text: datas.text,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus saja!',
            cancelButtonText: 'Batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: datas.url,
                    data: datas.data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Berhasil', response.sukses, 'success'
                            ).then((result) => {
                                if (datas.jenisHapus === "temporary") {
                                    tableBrgTetap.ajax.reload();
                                    tableBrgPersediaan.ajax.reload();
                                    tableAlokasiBrg.ajax.reload();
                                } else {
                                    datarestore.ajax.reload();

                                }
                            })
                        } else if (response.error) {
                            Swal.fire(
                                'Gagal!',
                                response.error,
                                'error'
                            );
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

    const hapus = (id, ruang_id, barang_id, nama_brg, namaruang) => {
        const datas = {
            data: {
                ruang_id, barang_id, nama_brg
            },
            jenisHapus: 'temporary',
            url: `${nav}/hapus/` + id,
            title: `Apakah kamu yakin ingin menghapus data ${nama_brg} di ${namaruang}?`,
            text: ''
        }
        swalHapus(datas);
    }

    const hapusPermanen = (id, ruangId, barangId, namabrg, namaruang) => {
        const datas = {
            data: {
                id, ruangId, barangId, namabrg, namaruang,
            },
            jenisHapus: 'permanent',
            url: `${nav}/hapuspermanen`,
            title: `Menghapus data ${namabrg} di ${namaruang} secara permanen?`,
            text: 'Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!',
        }
        swalHapus(datas);
    }

    const transferBarang = () => {
        let selectedRows = $('td input[type="checkbox"]:checked');
        if (selectedRows.length > 0 && selectedRows.attr('class') !== "checkrow-brgpersediaan") {
            let selectedIds = $('td:nth-child(1) input[type="checkbox"]:checked').map(function () {
                return $(this).val();
            }).get();
            let jmldata = selectedIds.length;
            const datas = {
                url: `${nav}/tampiltransferform`,
                data: {
                    ids: selectedIds.join(","),
                    jmldata: jmldata,
                }
            }
            util.getCardOrModal(datas);
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
            url: `${nav}/tampilexportexcel`,
            data: {
                title, nav
            }
        }

        util.getCardOrModal(datas);
    }

    const tampilImportExcel = () => {
        let title = "Input Barang Via Excel";
        const datas = {
            url: `${nav}/tampilimportexcel`,
            view: "modal",
            modalId: "modalimportexcel",
            data: {
                title, nav
            }
        }

        util.getCardOrModal(datas);
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
                'X-CSRF-TOKEN': form.querySelector('input[name="csrf_test_name"]').value
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
                    const tables = [$('#tableBrgTetap').DataTable(), $('#tableBrgPersediaan').DataTable()];
                    util.handleSubmitSuccess(response.success, tables);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function handleSubmitError(errors, rowCount) {
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

    return {
        edit,
        detail,
        upload,
        hapus,
        cetakLabel,
        uploadExcel,
        hapusPermanen,
        formTambahBaru,
        formTambahStok,
        transferBarang,
        listDataBarang,
        downloadLabelImg,
        downloadLabelPdf,
        handleSubmitError,
        tampilExportExcel,
        tampilImportExcel
    }
})();

export { barang };