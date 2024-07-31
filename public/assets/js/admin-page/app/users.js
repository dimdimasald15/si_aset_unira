import { crud } from "./crud.js";

export const users = (() => {
    let tableUsers;
    const initDocReady = () => {
        tableUsers = listData('table-pengguna', `${nav}/listdata`);
    }
    const listData = (selector, url) => {
        const columns = [
            { data: 'no', orderable: false },
            { data: 'nip' },
            { data: 'email' },
            { data: 'username' },
            { data: 'role' },
            { data: 'created_by' },
            { data: 'created_at', render: renderFormatTime },
            { data: 'action', orderable: false }
        ];
        const table = crud.initDataTable(selector, url, columns);
        return table;
    };
    const fillForm = (data, form) => {
        crud.fillForm(data, form, [
            ['id', 'id'],
            ['nip', 'nip'],
            ['email', 'email'],
            ['username', 'username'],
            ['role', 'role'],
        ]);
    };
    const submit = (form, event) => crud.handleFormSubmit(form, event, [tableUsers]);
    const hapus = (id, email) => {
        let data = JSON.stringify({ id, email });
        let url = `${nav}/hapus/${id}`;
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${email} secara permanen?`, tableUsers, "permanent", text);
    }

    return {
        hapus,
        submit,
        fillForm,
        listData,
        initDocReady
    }
})()