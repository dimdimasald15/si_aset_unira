import { crud } from "./crud.js";

export const gedung = (() => {
    let tableGedung;
    const listData = (selector, url) => {
        const columns = [
            { data: 'no', orderable: false },
            { data: 'nama_gedung' },
            { data: 'prefix' },
            { data: 'nama_kategori' },
            { data: 'created_by' },
            { data: 'created_at', render: renderFormatTime },
            { data: 'action', orderable: false }
        ];
        tableGedung = crud.initDataTable(selector, url, columns);
        return tableGedung;
    };
    const fillForm = (data, form) => {
        crud.fillForm(data, form, [
            ['id', 'id'],
            ['nama_gedung', 'nama_gedung'],
            ['prefix', 'prefix'],
            ['kat_id', 'nama_kategori'],
        ]);
    };
    const submit = (form, event) => crud.handleFormSubmit(form, event, [tableGedung]);
    const hapus = (id, nama_gedung) => {
        let data = JSON.stringify({ id, nama_gedung });
        let url = `${nav}/hapus/${id}`;
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_gedung} secara permanen?`, tableGedung, "permanent", text);

    }

    return {
        hapus,
        submit,
        fillForm,
        listData,
    }
})()