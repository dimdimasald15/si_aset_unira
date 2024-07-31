import { crud } from "./crud.js"

export const ruang = (() => {
    let tableRuang, tableRestore;
    const listData = (selector, url) => {
        var isRestore = selector == "table-restore" ? 1 : 0;
        const columns = [
            { data: 'no', orderable: false },
            { data: 'nama_ruang' },
            { data: 'nama_lantai' },
            { data: 'prefix' },
            { data: 'nama_gedung' },
            { data: (!isRestore) ? 'created_by' : 'deleted_by' },
            {
                data: (!isRestore) ? 'created_at' : 'deleted_at'
                , render: renderFormatTime
            },
            { data: 'action', orderable: false }
        ];
        tableRuang = crud.initDataTable(selector, url, columns);
        return tableRuang;
    };
    const fillForm = (data, form) => {
        crud.fillForm(data, form, [
            ['id', 'id'],
            ['nama_ruang', 'nama_ruang'],
            ['nama_lantai', 'nama_lantai'],
            ['gedung_id', 'gedung_id']
        ]);
    };
    const submit = (form, event) => crud.handleFormSubmit(form, event, [tableRuang]);
    const hapus = (id, nama_ruang) => {
        let data = JSON.stringify({ id, nama_ruang });
        let url = `${nav}/hapus/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_ruang}?`, [tableRuang], "temporary");
    }
    const hapusPermanen = (id, nama_ruang) => {
        let data = JSON.stringify({ id, nama_ruang });
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        let url = `${nav}/hapuspermanen/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_ruang} secara permanen?`, tableRestore, "permanent", text);
    }
    const hapusPermanenAll = () => {
        crud.handleDeleteAll(tableRestore);
    }
    const viewTableRestore = () => {
        function callback() {
            tableRestore = listData(`table-restore`, `${nav}/listdata?isRestore=1`)
        }
        crud.handleViewRestore(nav, callback)
    };
    const restore = (id, nama_ruang) => {
        let data = JSON.stringify({ id, nama_ruang });
        let title = `Memulihkan data ${nama_ruang}?`
        crud.handleRestore(data, title, tableRestore, "restore")
    }
    const restoreAll = () => crud.handleRestoreAll(tableRestore, false)

    return {
        hapus,
        submit,
        restore,
        listData,
        fillForm,
        restoreAll,
        hapusPermanen,
        hapusPermanenAll,
        viewTableRestore,
    }
})()