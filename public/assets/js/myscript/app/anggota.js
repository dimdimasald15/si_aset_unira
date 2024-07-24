import { crud } from "./crud.js"
import { selectOption } from "./selectOption.js"

export const anggota = (() => {
    let tableRestoreAnggota;
    const listData = (selector, url, isRestore = false) => {
        const commonColumns = [{
            className: 'dt-control',
            orderable: false,
            sortable: false,
            data: null,
            defaultContent: '',
            searchable: false,
        },
        {
            data: 'nama_anggota'
        },
        {
            data: 'no_anggota',
        },
        {
            data: 'nama_unit',
        }];
        const additionalColumns = isRestore ? [
            {
                data: 'deleted_by'
            },
            {
                data: 'deleted_at'
            }
        ] : [
            {
                data: 'checkRowAnggota',
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
    const viewdtcontrol = (index, data) => {
        function format(d) {
            const formattedDate = renderFormatTime(d.created_at);

            let addunit = `
                <table class="table" style="padding:20px;">
                    <tr>
                        <th>${d.kategori_unit}</th>
                        <td class="align-top">:</td>
                        <td class="align-top">${d.singkatan ? d.singkatan : '-'}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td class="align-top">:</td>
                        <td class="align-top">${d.deskripsi ? d.deskripsi : '-'}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td class="align-top">:</td>
                        <td class="align-top">dibuat tanggal ${formattedDate} oleh ${d.created_by}</td>
                    </tr>
                </table>
            `;

            let addanggota = `
                <table class="table" style="padding:20px;">
                    <tr>
                        <th>Nomor Handphone</th>
                        <td>:</td>
                        <td>${d.no_hp ? d.no_hp : '-'}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>:</td>
                        <td>${d.level}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td class="align-top">:</td>
                        <td class="align-top">dibuat tanggal ${formattedDate} oleh ${d.created_by}</td>
                    </tr>
                </table>
            `;

            return d.deskripsi ? addunit : addanggota;
        }
        crud.viewDtControl(index, data, format);
    }
    const handleNoAnggota = (level, noAnggotaValue = '') => {
        const noAnggotaContainer = $('.no_anggota');
        noAnggotaContainer.hide().html('');

        if (level === 'Mahasiswa' || level === 'Karyawan') {
            const label = level === 'Mahasiswa' ? 'NIM' : 'Nomor Pegawai';
            const placeholder = level === 'Mahasiswa' ? 'Masukkan NIM' : 'Masukkan Nomor Pegawai';

            noAnggotaContainer.show().append(`
                <label for="no_anggota" class="form-label">${label}</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="number" class="form-control" placeholder="${placeholder}" id="no_anggota" name="no_anggota" value="${noAnggotaValue}">
                    <div class="invalid-feedback errno_anggota"></div>
                </div>
            `);
        }
        util.rmIsInvalid("no_anggota");
    }
    const handleLevel = (form, formId) => {
        const level = $(form).val();
        selectOption.unit("unit_id", level);
        util.clearForm(form, formId);
        handleNoAnggota(level);
    }
    const fillForm = ({ id, nama_anggota, no_anggota, unit_id, level, singkatan, no_hp }, form) => {
        $('#id').val(id);
        $('#nama_anggota').val(nama_anggota);
        $('#level').val(level);
        handleNoAnggota(level, no_anggota);
        selectOption.unit("unit_id", level);
        $('#unit_id').html(`<option value="${unit_id}">${singkatan}</option>`);
        $('#no_hp').val(no_hp);
    }
    const viewTableRestore = () => {
        function callback() {
            tableRestoreAnggota = listData(`table-restoreanggota`, `${nav}/listdataanggota?isRestore=1`, true)
            viewdtcontrol('table-restoreanggota', tableRestoreAnggota);
        }
        crud.handleViewRestore(nav, callback)
    };
    const submit = (form, event) => crud.handleFormSubmit(form, event, [tableAnggota]);
    const hapus = (id, nama_anggota) => {
        let data = JSON.stringify({ id, nama_anggota });
        let url = `${nav}/hapusanggota/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_anggota}?`, [tableAnggota], "temporary");
    }
    const hapusPermanen = (id, nama_anggota) => {
        let data = JSON.stringify({ id, nama_anggota });
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        let url = `${nav}/hapuspermanenanggota/${id}`;
        crud.handleDelete(url, data, `Apakah kamu yakin ingin menghapus data ${nama_anggota} secara permanen?`, tableRestoreAnggota, "permanent", text);
    }
    const hapusPermanenAll = () => crud.handleDeleteAll(tableRestoreAnggota, `${nav}/hapuspermanenanggota`, 'anggota')
    const restore = (id, nama_anggota) => {
        let url = `${nav}/restoreanggota`
        let data = JSON.stringify({ id, nama_anggota });
        let title = `Memulihkan data ${nama_anggota}?`
        crud.handleRestore(data, title, tableRestoreAnggota, "restore", url)
    }
    const restoreAll = () => crud.handleRestoreAll(tableRestoreAnggota, false, `${nav}/restoreanggota`, "anggota")
    const multipleDelete = (form, event) => crud.handleMultipleDelete(form, event, [tableAnggota], '.checkRowAnggota', 'anggota');

    return {
        listData,
        hapus,
        submit,
        restore,
        fillForm,
        restoreAll,
        handleLevel,
        hapusPermanen,
        viewdtcontrol,
        hapusPermanenAll,
        viewTableRestore,
        multipleDelete
    }
})()