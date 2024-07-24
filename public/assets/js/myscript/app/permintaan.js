import { crud } from "./crud.js"

export const permintaan = (() => {
    let tableRestore;
    const listData = (selector, url, isRestore = false) => {
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
            {
                data: 'tgl_minta',
                render: renderFormatTime
            },
            {
                data: 'keterangan',
                render: (data, type, row) => `${data ? `${data}` : "-"}`,
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
                !['checkrow'].includes(column.data)
            );
        }
        const table = crud.initDataTable(selector, url, columns);
        return table;
    };
    const viewTableRestore = () => {
        function callback() {
            tableRestore = listData('table-restore', `${nav}/listdatapermintaan?jenis_kat=${jenis_kat}&isRestore=1`, true);
        }
        crud.handleViewRestore('minta', callback)
    };
    const getForm = (saveMethod, id) => {
        let url = `${nav}/tampilform`;
        const datas = {
            url,
            method: "GET",
            data: {
                saveMethod, id, jenis_kat
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
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data peminjaman ${nama_anggota} atas ${jml} ${satuan} ${nama_brg}?`, [tableMinta], "temporary");
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
        formdata.append('jenistrx', "Permintaan Barang");
        const callback = (response) => {
            const fields = util.getIdsForm(idForm);
            if (response.error) {
                util.handleValidationErrors(fields, response.error);
            } else {
                const tables = [tableMinta];
                util.handleSubmitSuccess(response.success, tables);
            }
        };
        const datas = {
            type: "post", url, data: formdata,
        }
        crud.submitAjax(datas, callback);
        return false;
    }
    const multipleDelete = (form, event) => crud.handleMultipleDelete(form, event, [tableMinta], '.checkrow', "", jenis_kat);
    const printPdf = (opsi) => {
        let datas = {
            method: "post", view: "modal", modalId: "modalcetakpermintaan",
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
        restoreAll,
        hapusPermanen,
        getReturnForm,
        multipleDelete,
        hapusPermanenAll,
        viewTableRestore,
    }
})()