import { util } from "./util.js";

export const selectOption = (() => {
    const select2Option = (datas) => {
        const jenis_kat = datas.jenis_kat || '';
        $(`#${datas.id}`).select2({
            placeholder: datas.placeholder,
            minimumInputLength: 1,
            allowClear: true,
            width: datas.width || "100%",
            ajax: {
                url: datas.url,
                dataType: 'json',
                delay: 250,
                data: (params) => ({ search: params.term, jenis_kat }),
                processResults: (data) => ({ results: data }),
                cache: true
            },
            templateResult: datas.templateResult,
        });
    }

    const category = (id, jenis) => {
        const jenis_kat = $(jenis).val();
        const datas = {
            id,
            jenis_kat,
            url: `${nav}/pilihkategori`,
            templateResult: util.formatResult,
            placeholder: "Pilih Kategori",
        }

        select2Option(datas);

        $('#jenis_kat').removeClass('is-invalid');
        $('.errjenis_kat').html('');
    }

    const selectizeOption = (datas) => {
        const jenis_kat = datas.jenis_kat || '';
        var $select = $(`#${datas.id}`).selectize({
            preload: true,
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            create: false,
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: datas.url,
                    type: 'GET',
                    dataType: 'json',
                    data: { search: query, jenis_kat },
                    success: function (res) {
                        callback(res);
                    },
                    error: function () {
                        callback();
                    }
                });
            }
        });

        // Contoh penggunaan untuk clear button
        var control = $select[0].selectize;

        $('#button-clear').on('click', function () {
            control.clear();
        });

    }

    const multiCategory = (id, form) => {
        $(`#${id}`).attr('multiple', 'multiple');
        const jenis_kat = $(form).val();
        const datas = {
            id,
            jenis_kat,
            url: `${nav}/pilihkategori`,
        }

        selectizeOption(datas);

        $('#jenis_kat').removeClass('is-invalid');
        $('.errjenis_kat').html('');
    }

    const warna = (id, width) => {
        const datas = {
            id,
            url: `${nav}/pilihwarna`,
            templateResult: util.formatResult2,
            placeholder: "Pilih Warna",
            width,
        }

        select2Option(datas);
    }

    const satuan = (id) => {
        const datas = {
            id,
            url: `${nav}/pilihsatuan`,
            templateResult: util.formatResult2,
            placeholder: "Pilih Satuan",
        }

        select2Option(datas);
    }



    return {
        category,
        multiCategory,
        warna,
        satuan
    }
})()