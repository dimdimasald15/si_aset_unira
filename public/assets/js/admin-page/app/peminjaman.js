import { crud } from "./crud.js"

export const peminjaman = (() => {
    let tableRestore;
    const renderStatus = (data, type, row) => {
        if (data === '0') return `<span class="badge bg-danger">Belum kembali</span>`;
        if (data === '1') {
            let kondisi = row.kondisi_kembali.toLowerCase();
            let label_kondisi = "";
            switch (kondisi) {
                case "baik":
                    label_kondisi = `<span class="badge bg-success">Kondisi baik</span>`
                    break;
                case "rusak ringan":
                    label_kondisi = `<span class="badge bg-warning">Kondisi rusak ringan</span>`
                    break;
                case "rusak berat":
                    label_kondisi = `<span class="badge bg-danger">Kondisi rusak berat</span>`
                    break;
                default:
                    break;
            }
            return `<span class="badge bg-primary">Sudah kembali</span>${label_kondisi}`;
        }
        return '';
    };
    const listData = (selector, url, isRestore) => {
        let columns = [
            { data: 'checkrow', orderable: false },
            { data: 'no', orderable: false },
            { data: 'nama_anggota' },
            { data: 'singkatan' },
            { data: 'nama_brg' },
            {
                data: 'jml_barang',
                render: (data, type, row) => `${data} ${row.kd_satuan}`,
                searchable: false,
            },
            { data: 'keterangan' },
            {
                data: 'tgl_pinjam',
                render: renderFormatTime
            },
            {
                data: 'tgl_kembali',
                render: renderFormatTime
            },
            {
                data: 'status',
                render: renderStatus
            },
            { data: isRestore ? 'deleted_by' : 'created_by' },
            {
                data: isRestore ? 'deleted_at' : 'created_at',
                render: renderFormatTime
            },
            { data: 'action', orderable: false }
        ];
        if (isRestore) {
            columns = columns.filter(column =>
                !['checkrow', 'keterangan', 'tgl_pinjam', 'tgl_kembali'].includes(column.data)
            );
        }
        const table = crud.initDataTable(selector, url, columns);
        return table;
    };
    const getForm = (saveMethod, id, status) => {
        let url = `${nav}/tampilformpinjam`;
        const datas = {
            url,
            method: "GET",
            data: {
                saveMethod, id, jenis_kat, status
            }
        };
        crud.getForm(datas);
    }
    const fillForm = (data, form) => {
        $('.viewalert').show().html(`
            <div class="alert alert-info" role="alert">
              <div class="row">
                <div class="col-sm-1 d-flex align-items-center justify-content-end">
                  <p class="fs-1"><i class="bi bi-info-circle"></i></p>
                </div>
                <div class="col-sm-10 p-0">
                <p>Informasi: Jika Anda mencoba mengubah nama barang menjadi nama 
                barang yang sudah ada di tabel peminjaman untuk anggota yang sama, 
                proses ini akan melanjutkan dengan menghapus data peminjaman saat 
                ini dan menambahkan jumlah peminjaman ke data barang yang sudah ada.</p>
                </div>
                <div class="col-sm-1">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              </div>
            </div>
            `)
        isiForm(data.data, data.jmldata, form);
        function isiForm(data, jmldata, form) {
            crud.fillForm(data, form, [
                ['id', 'id'],
                ['anggota_id', 'nama_anggota'],
                ['tgl_pinjam', 'tgl_pinjam'],
                ['keterangan', 'keterangan']
            ]);
            for (let i = 1; i <= jmldata; i++) {
                $(`#barang_id${i}`).html(`
                    <option value="${data.barang_id}">${data.nama_brg}</option>
                `);
                sisa_stok_lama.push(parseInt(data.sisa_stok));
                jumlah_lama.push(parseInt(data.jml_barang));
                $(`#sisastok${i}`).val(data.sisa_stok);
                $(`#jml_barang${i}`).val(data.jml_barang);
                $(`#satuan${i}`).prop('disabled', true);
                $(`#satuan${i}`).html(`<option value="${data.satuan_id}">${data.kd_satuan}</option>`);
            }
        }
    };
    const fillForm2 = (data, form) => {
        isiForm(data.data, data.jmldata, form);
        function isiForm(data, jmldata, form) {
            crud.fillForm(data, form, [
                ['anggota_id', 'nama_anggota'],
                ['tgl_pinjam', 'tgl_pinjam'],
            ]);
            for (let i = 1; i <= jmldata; i++) {
                appendRowReturnForm(data, i);
            }
        }
    }
    const getReturnForm = (saveMethod) => {
        let url = `${nav}/tampilformkembali`;
        const datas = {
            url,
            method: "GET",
            data: {
                saveMethod, formName: "Form Kembali", jenis_kat
            }
        };
        crud.getForm(datas);
    }
    const hapus = (id, nama_anggota, nama_brg, jml, satuan) => {
        let data = JSON.stringify({ nama_anggota, nama_brg });
        let url = `${nav}/hapus/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data peminjaman ${nama_anggota} atas ${jml} ${satuan} ${nama_brg}?`, [tablePinjam], "temporary");
    }
    const hapusPermanen = (id, nama_brg, nama_anggota) => {
        let data = JSON.stringify({ id, nama_brg, jenis_kat });
        let titleText = `Apakah kamu yakin ingin menghapus data peminjaman ${nama_anggota} atas barang ${nama_brg} secara permanen??`
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        let url = `${nav}/hapuspermanen/${id}`;
        crud.handleDelete(url, data, titleText, tableRestore, "permanent", text);
    }
    const hapusPermanenAll = () => {
        crud.handleDeleteAll(tableRestore);
    }
    const viewTableRestore = () => {
        function callback() {
            tableRestore = listData('table-restore', `${nav}/listdatapeminjaman?jenis_kat=${jenis_kat}&isRestore=1`, true);
        }
        crud.handleViewRestore('pinjam', callback)
    };
    const restore = (id, barang_id, nama_brg, nama_anggota) => {
        let data = JSON.stringify({ id, barang_id, nama_brg, nama_anggota, jenis_kat });
        let textTitle = `Memulihkan data ${title} ${nama_brg} oleh ${nama_anggota}?`
        crud.handleRestore(data, textTitle, tableRestore, "restore")
    }
    const restoreAll = () => crud.handleRestoreAll(tableRestore, true)
    const submit = (form, event) => {
        event.preventDefault();
        const idForm = $(form).attr('id');
        const url = $(form).attr('action');
        var formdata = new FormData(form);
        formdata.append('jmlbrg', rowCount);
        formdata.append('jenistrx', "Peminjaman Barang");
        const callback = (response) => {
            const fields = util.getIdsForm(idForm);
            if (response.error) {
                util.handleValidationErrors(fields, response.error);
            } else {
                const tables = [tablePinjam];
                util.handleSubmitSuccess(response.success, tables);
            }
        };
        const datas = {
            type: "post", url, data: formdata,
        }
        crud.submitAjax(datas, callback);
        return false;
    }
    const submitReturnForm = (form, event) => {
        event.preventDefault();
        const idForm = $(form).attr('id');
        const url = $(form).attr('action');
        const saveMethod = $(form).attr('saveMethod');
        var rowCount = $('#tambahrow tr').length;
        var formdata = new FormData(form);
        formdata.append('jenistrx', "Pengembalian Barang");
        formdata.append('jmldata', rowCount);
        formdata.append('saveMethod', saveMethod);
        const datas = {
            type: "post", url, data: formdata,
        }
        const callback = (response) => {
            const fields = util.getIdsForm(idForm);
            if (response.error) {
                util.handleValidationErrors(fields, response.error);
            } else {
                const tables = [tablePinjam];
                util.handleSubmitSuccess(response.success, tables);
            }
        }
        crud.submitAjax(datas, callback);
        return false;
    }

    const appendRowReturnForm = (data, i) => {
        const isChecked = data.status == 1 ? 'checked' : '';
        const checkboxVal = data.status == 1 ? '1' : '0';
        const bgtext = data.status == 1 ? '<span class="badge bg-primary">Sudah Kembali</span>' : '<span class="badge bg-danger">Belum Kembali</span>';

        $('#tambahrow').append(`
        <tr>
            <td style="display:none;">
                <input name="id[]" id="id${i}" value='${data.id}'>
            </td>
            <td>${i}</td>
            <td>
                <input type="hidden" name="barang_id[]" id="barang_id${i}" value='${data.barang_id}'>${data.nama_brg}
            </td>
            <td class="align-center">
                <input type="hidden" name="jml_barang[]" id="jml_barang${i}" value='${data.jml_barang}'>${data.jml_barang} ${data.kd_satuan}
            </td>
            <td>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                    <input type="datetime-local" class="form-control" id="tgl_kembali${i}" name="tgl_kembali[]" value="${data.tgl_kembali ? `${data.tgl_kembali}` : "mm/dd/yyyy --:-- --"}">
                    <div class="invalid-feedback errtgl_kembali${i}"></div>
                </div>
            </td>   
            <td>
                <select class="form-select" name="kondisi_kembali[]" id="kondisi_kembali${i}">
                    <option value="" selected disabled>Pilih kondisi</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak ringan">Rusak ringan</option>
                    <option value="Rusak berat">Rusak berat</option>
                </select>
                <div class="invalid-feedback errkondisi_kembali${i}"></div>
            </td>
            <td>
                <div class="form-check">
                    <input class="form-check-input mt-0" type="checkbox" name="status[]" id="status${i}" value="${checkboxVal}" ${isChecked}>
                    <label for="status${i}">${bgtext}</label>
                </div>
            </td>
        </tr>
    `);
        addEventListeners(i, data);
    };

    const addEventListeners = (i, data) => {
        $(`#tgl_kembali${i}`).on('input', function (e) {
            e.preventDefault();
            util.rmIsInvalid($(this).attr("id"));
            if ($(this).val()) {
                $(`#status${i}`).prop('checked', true);
                $(`#status${i}`).val(1);
                $(`#status${i}`).siblings('label').html('<span class="badge bg-primary">Sudah Kembali</span>');
            } else {
                $(`#status${i}`).prop('checked', false);
                $(`#status${i}`).val(0);
                $(this).siblings('label').html('<span class="badge bg-danger">Belum Kembali</span>');
            }
        });

        $(`#kondisi_kembali${i}`).on('change', function (e) {
            e.preventDefault();
            util.rmIsInvalid($(this).attr("id"));
        });

        $(`#tgl_kembali${i}`).val(data.tgl_kembali);
        $(`#kondisi_kembali${i}`).val(data.kondisi_kembali);
        $(`#status${i}`).on('change', function (e) {
            e.preventDefault();
            if ($(this).prop('checked')) {
                $(this).val(1);
                $(this).siblings('label').html('<span class="badge bg-primary">Sudah Kembali</span>');
            } else {
                $(this).val(0);
                $(this).siblings('label').html('<span class="badge bg-danger">Belum Kembali</span>');
                $(`#tgl_kembali${i}`).val("mm/dd/yyyy --:-- --");
                $(`#kondisi_kembali${i}`).val("");
            }
        });
    };
    const getDataPeminjaman = (anggota_id, tgl_pinjam) => {
        let datas = {
            type: "get",
            url: `${nav}/getdatapeminjaman`,
            data: {
                anggota_id,
                tgl_pinjam,
            },
        };
        const callback = (response) => {
            $('#tabledatabrg').show();
            $('#tambahrow').empty();
            if (response.jmldata != 0) {
                $.each(response.data, function (i, val) {
                    appendRowReturnForm(val, i + 1);
                });
            } else {
                swal.fire('Data Kosong', `${response.nama_anggota} tidak melakukan peminjaman pada tanggal ${tgl_pinjam}`, 'info');
                $('#tabledatabrg').hide();
                $('#tambahrow').empty();
            }
        };
        util.fetchData(datas, callback);
    };
    const multipleDelete = (form, event) => crud.handleMultipleDelete(form, event, [tablePinjam], '.checkrow', "", jenis_kat);
    const printPdf = (opsi) => {
        let datas = {
            method: "post", view: "modal", modalId: "modalcetakpeminjaman",
            url: `${nav}/tampilmodalcetak`,
            data: {
                jenis_kat, opsi
            },
        };
        crud.getForm(datas);
    }
    return {
        hapus,
        submit,
        getForm,
        restore,
        listData,
        printPdf,
        fillForm,
        fillForm2,
        restoreAll,
        hapusPermanen,
        getReturnForm,
        multipleDelete,
        submitReturnForm,
        hapusPermanenAll,
        viewTableRestore,
        getDataPeminjaman,
    }
})()