import { util } from "./util.js";

export const selectOption = (() => {
    const formatResult = (data) => {
        if (!data.id) {
            return data.text;
        }
        let result = '';
        if (data.unit) {
            let identifier = data.level === "Karyawan" ? `NIP: ${data.no}` : `NIM: ${data.no}`;
            result = $(`<span><i class="bi bi-layers"> </i>${data.text} (${identifier}) - ${data.unit}</span>`);
        } else if (data.nama !== undefined) {
            result = $(
                `<span><i class="bi bi-person"> </i>${data.text} - ${data.nama}</span>`
            );
        } else {
            result = $(`<span><i class="bi bi-layers"> </i>${data.text}</span>`);
        }
        return result;
    };

    const formatResult2 = (data) => {
        if (!data.id) {
            return data.text;
        }
        var $result = $(
            `<span><i class="bi bi-palette"> </i>${data.text} <span class="dot" style="height: 25px;
                        width: 25px;
                        background-color: ${data.kode};
                        border-radius: 50%;
                        display: inline-block;"></span></span>`
        );
        return $result;
    }

    const select2Option = (datas) => {
        const jenis_kat = datas.jenis_kat || '';
        $(`#${datas.id}`).select2({
            placeholder: datas.placeholder,
            minimumInputLength: datas.length ? datas.length : 1,
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

    const category = (id, form) => {
        const jenis_kat = form ? $(form).val() : '';
        const datas = {
            id,
            jenis_kat,
            url: `${nav}/pilihkategori`,
            templateResult: formatResult,
            placeholder: "Pilih Kategori",
        }
        select2Option(datas);
        util.rmIsInvalid(`jenis_kat`);
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

        util.rmIsInvalid(`jenis_kat`);
    }

    const warna = (id, width) => {
        const datas = {
            id,
            url: `${nav}/pilihwarna`,
            templateResult: formatResult2,
            placeholder: "Pilih Warna",
            width,
        }
        select2Option(datas);
    }

    const satuan = (id) => {
        const datas = {
            id,
            url: `${nav}/pilihsatuan`,
            templateResult: formatResult,
            placeholder: "Pilih Satuan",
        }
        select2Option(datas);
    }

    const anggota = (id, level, placeholder, length) => {
        const datas = {
            id, jenis_kat: level,
            url: `${nav}/pilihanggota`, length,
            templateResult: formatResult,
            placeholder: placeholder ? placeholder : "Pilih Anggota",
            width: "100%"
        }
        select2Option(datas);
    }

    const unit = (id, level) => {
        const datas = {
            id, jenis_kat: level,
            url: `${nav}/pilihunit`,
            templateResult: formatResult,
            placeholder: "Pilih Unit",
            width: "100%"
        }
        select2Option(datas);
    }

    const barang = (id, jenis_kat) => {
        const datas = {
            id,
            url: `${nav}/pilihbarang`,
            templateResult: formatResult,
            placeholder: "Pilih Barang",
            jenis_kat,
        }
        select2Option(datas);
    }

    const peminjam = () => {
        let datas = {
            type: "get",
            url: `${nav}/pilihpeminjam`,
        }
        function callback(response) {
            $('#anggota_id').empty();
            $('#anggota_id').append('<option value="">Pilih Anggota</option>');
            $.each(response, function (key, val) {
                $('#anggota_id').append(`<option value="${val.id}">${val.nama_anggota} - ${val.level == "Mahasiswa" ? `NIM ${val.no_anggota}` : `NIDN/NIY ${val.no_anggota}`} - ${val.singkatan}</option>`);
            });
        }
        util.fetchData(datas, callback);
    }

    return {
        unit,
        warna,
        satuan,
        barang,
        anggota,
        peminjam,
        category,
        multiCategory,
    }
})()