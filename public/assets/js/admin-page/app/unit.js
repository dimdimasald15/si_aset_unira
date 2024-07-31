import { crud } from "./crud.js"

export const unit = (() => {
    let tableRestoreUnit;
    const listData = (selector, url, isRestore = false) => {
        const commonColumns = [
            {
                className: 'dt-control',
                orderable: false,
                sortable: false,
                data: null,
                defaultContent: '',
                searchable: false,
            },
            {
                data: 'nama_unit'
            },
            {
                data: 'singkatan'
            },
        ];
        const additionalColumns = isRestore ? [
            {
                data: 'deleted_by'
            },
            {
                data: 'deleted_at'
            }
        ] : [
            {
                data: 'checkRowUnit',
                orderable: false,
                searchable: false,
            }
        ];
        const actionColumn = [{
            data: 'action',
            orderable: false
        }];
        const columns = isRestore ? commonColumns.slice(0, 1).concat(commonColumns.slice(1), additionalColumns, actionColumn) : additionalColumns.concat(commonColumns, actionColumn);
        const table = crud.initDataTable(selector, url, columns);
        return table;
    };
    const fillForm = (data, form) => {
        console.log(data);
        crud.fillForm(data, form, [
            ['id', 'id'],
            ['nama_unit', 'nama_unit'],
            ['kategori_unit', 'kategori_unit'],
            ['singkatan', 'singkatan'],
            ['deskripsi', 'deskripsi']
        ]);
    };
    const submit = (form, event) => crud.handleFormSubmit(form, event, [tableUnit]);
    const hapus = (id, nama_unit) => {
        let data = JSON.stringify({ id, nama_unit });
        let url = `${nav}/hapusunit/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_unit}?`, [tableUnit], "temporary");
    }
    const hapusPermanen = (id, nama_unit) => {
        let data = JSON.stringify({ id, nama_unit });
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        let url = `${nav}/hapuspermanenunit/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_unit} secara permanen?`, tableRestoreUnit, "permanent", text);
    }
    const hapusPermanenAll = () => crud.handleDeleteAll(tableRestoreUnit, `${nav}/hapuspermanenunit`, 'unit')
    const viewTableRestore = () => {
        function callback() {
            tableRestoreUnit = listData(`table-restoreunit`, `${nav}/listdataunit?isRestore=1`, true)
            viewdtcontrol('table-restoreunit', tableRestoreUnit);
        }
        crud.handleViewRestore("unit", callback)
    };
    const restore = (id, nama_unit) => {
        let url = `${nav}/restoreunit`
        let data = JSON.stringify({ id, nama_unit });
        let title = `Memulihkan data ${nama_unit}?`
        crud.handleRestore(data, title, tableRestoreUnit, "restore", url)
    }
    const restoreAll = () => crud.handleRestoreAll(tableRestoreUnit, false, `${nav}/restoreunit`, "unit")
    const multipleDelete = (form, event) => crud.handleMultipleDelete(form, event, [tableUnit], '.checkRowUnit', 'unit');
    return {
        listData,
        hapus,
        submit,
        restore,
        fillForm,
        restoreAll,
        hapusPermanen,
        hapusPermanenAll,
        viewTableRestore,
        multipleDelete
    }
})()