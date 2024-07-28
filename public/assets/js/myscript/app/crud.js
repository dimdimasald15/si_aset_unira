import { util } from "./util.js";

export const crud = (() => {
    const viewDtControl = (index, data, format) => {
        // Add event listener for opening and closing details
        $(`#${index} tbody`).on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = data.row(tr);
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    }
    const initDataTable = (selector, url, columns, order, statusProcess = true) => {
        return $(`#${selector}`).DataTable({
            processing: statusProcess,
            serverSide: statusProcess,
            ajax: {
                url,
            },
            order: order ? order : [],
            columns,
            columnDefs: []
        });
    };

    const swalWarning = (datas) => {
        Swal.fire({
            title: datas.title,
            icon: 'warning',
            text: datas.text,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: datas.url,
                    data: datas.data,
                    dataType: 'json',
                    contentType: datas.contentType ? datas.contentType : false,
                    processData: datas.processData,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire(
                                'Berhasil', response.success, 'success'
                            ).then((result) => {
                                if (datas.action === "temporary") {
                                    datas.tables.forEach(table => {
                                        table.ajax.reload(null, false); // false untuk mempertahankan paging
                                    });
                                } else {
                                    datas.tables.ajax.reload();
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
            } else {
                Swal.fire(
                    'Gagal', 'Tidak ada data yang dihapus', 'info'
                );
            }
        });
    }

    const getForm = (datas) => {
        let method = datas.method;
        let data = datas.data ?? datas.data;
        $.ajax({
            type: method,
            url: datas.url,
            data,
            dataType: "json",
            success: function (response) {
                if (datas.view === "modal") {
                    $('.viewdata').html(response.data).show(500);
                    $(`#${datas.modalId}`).modal('show');
                } else {
                    $('.viewdata').html(response.data).show(500);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    const submitAjax = (datas, successCallback) => {
        let type = datas.type;
        let data = datas.data ?? datas.data;
        $.ajax({
            type,
            url: datas.url,
            data,
            enctype: datas.enctype ? datas.enctype : 'application/x-www-form-urlencoded',
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
                setButtonState('.btnsimpan', true, '', 'fa fa-spin fa-spinner');
            },
            complete: function () {
                setButtonState('.btnsimpan', false, 'Simpan', '');
            },
            success: successCallback,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    const handleDelete = (url, data, title, tables, action, text) => {
        const datas = {
            data, url, processData: false, action, title, text, tables
        }
        swalWarning(datas);
    }

    const handleRestore = (data, title, tables, action, path) => {
        let url = `${path ? path : `${nav}/restore`}`;
        const datas = {
            data, url,
            processData: false, contentType: "application/json",
            action, title, text: '', tables
        }
        swalWarning(datas);
    }

    const handleRestoreAll = (tableRestore, includeAdditionalData = false, path, text, jenis_kat) => {
        let url = `${path ? path : `${nav}/restore`}`;
        var api = tableRestore.rows();
        var id = api.data().toArray().map(function (d) {
            return d.id;
        });
        let titles = text ? text : title;

        if (api.count() === 0) { // jika tidak ada data
            Swal.fire(
                'Gagal!',
                `Tidak ada data ${titles.toLowerCase()} yang dapat dipulihkan`,
                'error'
            );
            return;
        }

        let data = { id: id.join(",") };

        if (includeAdditionalData) {
            data.ruangId = api.data().toArray().map(function (d) {
                return d.ruang_id;
            }).join(",");
            data.barangId = api.data().toArray().map(function (d) {
                return d.barang_id;
            }).join(",");
            data.jenis_kat = jenis_kat;
        }

        let textTitle = `Apakah anda ingin memulihkan semua data ${titles.toLowerCase()} yang telah terhapus?`;
        handleRestore(JSON.stringify(data), textTitle, tableRestore, "restore", url);
    }

    const handleDeleteAll = (tableRestore, path, string, data) => {
        let titles = string ? string : title;
        var api = tableRestore.rows();
        if (api.count() === 0) { // jika tidak ada data
            Swal.fire(
                'Gagal!',
                `Tidak ada data ${titles.toLowerCase()} yang dapat dihapus secara permanen`,
                'error'
            );
            return;
        }
        let textTitle = `Bersihkan semua data  ${titles.toLowerCase()} secara permanen?`;
        let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
        let url = path ? path : `${nav}/hapuspermanen`;
        handleDelete(url, data ? data : {}, textTitle, tableRestore, "permanent", text);
    }

    const handleFormSubmit = (form, event, table) => {
        event.preventDefault();
        const idForm = $(form).attr('id');
        const url = $(form).attr('action');

        const callback = (response) => {
            const fields = util.getIdsForm(idForm);
            if (response.error) {
                util.handleValidationErrors(fields, response.error);
            } else {
                const tables = Array.isArray(table) ? table : [table];
                util.handleSubmitSuccess(response.success, tables);
            }
        };

        const datas = {
            url,
            type: "POST",
            data: new FormData(form)
        };

        submitAjax(datas, callback);
        return false;
    };

    const fillForm = (data, form, mappings) => {
        mappings.forEach(([field, value]) => {
            const element = form.find(`[name='${field}']`);
            if (element.is('input') || element.is('textarea')) {
                element.val(data[value]);
            } else if (element.is('select')) {
                if (field === "kat_id" || field === "anggota_id") {
                    element.html(`<option value="${data[field]}" selected>${data[value]}</option>`);
                } else {
                    element.val(data[value]);
                }
            }
        });
    };

    const setButtonState = (selector, isDisabled, text, iconClass) => {
        const button = $(selector);
        if (isDisabled) {
            button.attr('disabled', 'disabled');
            button.html(`<i class="${iconClass}"></i>`);
        } else {
            button.removeAttr('disabled');
            button.text(text);
        }
    };

    const handleViewRestore = (title, callback) => {
        $(`.table-${title}`).hide();
        if (title == "unit" || title == "anggota") {
            $(`.table-restore${title}`).show();
        } else {
            $(`.table-restore`).show();
        }
        $(`.datalist-${title} h4`).html(`Restore Data ${capitalize(title)}`);
        $(`.viewdata`).hide();
        $(`.btn-data${title}`).hide();
        $(`.btn-datarestore${title}`).show();
        if (callback) {
            callback()
        }
    }

    const handleMultipleDelete = (form, event, tables, checkRowSelector, string, keterangan) => {
        event.preventDefault();
        let titles = string ? string : title;
        const jmldata = $(checkRowSelector + ':checked');
        const formdata = new FormData(form);
        if (keterangan) {
            formdata.append('jenis_kat', keterangan)
        }

        if (jmldata.length === 0) {
            Swal.fire(
                'Gagal!',
                `Tidak ada data ${titles.toLowerCase()} yang dipilih`,
                'error'
            );
            return;
        }
        let textTitle = `Multiple Delete`;
        let text = `Apakah kamu yakin ingin menghapus ${jmldata.length} data secara temporary?`;
        let url = `${nav}/multipledelete${string}`;
        handleDelete(url, formdata, textTitle, tables, "temporary", text);
        return false;
    }

    return {
        submitAjax,
        getForm,
        swalWarning,
        initDataTable,
        handleFormSubmit,
        handleRestore,
        handleRestoreAll,
        handleDeleteAll,
        handleViewRestore,
        handleMultipleDelete,
        handleDelete,
        fillForm,
        renderFormatTime,
        viewDtControl
    }
})()