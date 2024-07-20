import { crud } from "./crud.js";

const util = (() => {
    const clearIsInvalid = (idCard) => {
        if ($(idCard).find('input').hasClass('is-invalid') || $(idCard).find('select').hasClass('is-invalid')) {
            $(idCard).find('input').removeClass('is-invalid');
            $(idCard).find('select').removeClass('is-invalid');
        }
    }

    const closeBtn = (idCard) => {
        clearIsInvalid(idCard);
        $(idCard).hide(500);
    }

    const plusBtn = () => {
        var qtyplus = $('#qty-input').val();
        qtyplus++;
        $('#qty-input').val(qtyplus);
    }
    const minusBtn = (qtymin) => {
        if ($('#qty-input').val() > 1) {
            qtymin--;
            $('#qty-input').val(qtymin);
        }
    }

    const checkrowDef = (data) => {
        data.forEach(element => {
            $(`.checkrow-${element}`).prop('checked', false);
        });
    }

    const fetchData = (datas, callback) => {
        $.ajax({
            url: datas.url,
            data: datas.data,
            type: datas.type,
            dataType: "json",
            success: callback,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    const fetchDataFilter = (url, jenis_kat, selectId) => {
        let datas = {
            type: "get",
            url,
            data: { jenis_kat },
        }
        function callback(response) {
            const $select = $(`#${selectId}`);
            $select.empty(); // Clear existing options
            $select.append('<option value="">Pilih Semua</option>');
            response.forEach(item => {
                $select.append(`<option value="${item.id}">${item.text}</option>`);
            });
        }
        fetchData(datas, callback);
    }

    const filteringData = (jenis_kat) => {
        fetchDataFilter(`${nav}/pilihbarang`, jenis_kat, 'selectbarang');
        fetchDataFilter(`${nav}/pilihkategori`, jenis_kat, 'selectkategori');
    }

    const handleCheckAll = (checkbox, target) => {
        $(checkbox).click(function () {
            $(target).prop('checked', this.checked);
        });

        $(document).on('click', target, function () {
            $(checkbox).prop('checked', $(target).length === $(target + ':checked').length);
        });
    }

    const imgQR = (qrCanvas, centerImage, factor) => {
        var h = qrCanvas.height;
        //center size
        var cs = h * factor;
        // Center offset
        var co = (h - cs) / 2;
        var ctx = qrCanvas.getContext("2d");
        ctx.drawImage(centerImage, 0, 0, centerImage.width, (centerImage.height - 50), co, co, cs, cs + 10);
        ctx.strokeStyle = "#ffffff";
        ctx.lineWidth = 15 // ketebalan garis tepi 2 piksel
        ctx.strokeRect(co, co, cs, cs + 10); // membuat garis tepi persegi panjang di sekitar gambar
    }

    const rmIsInvalid = (id) => {
        $(`#${id}`).removeClass('is-invalid');
        $(`.err${id}`).html('');
    }

    const showPassword = (value) => {
        if ($(value).is(':checked')) {
            $('#password').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
        }
    }

    const handleValidationErrors = (fields, errors) => {
        fields.forEach(field => {
            const id = field.includes('.') ? `#${field.replace(/\./g, '\\.')}` : `#${field}`;
            if (errors[field]) {
                $(id).addClass('is-invalid');
                $(`.err${field.replace(/\./g, '\\.')}`).html(errors[field]);
            } else {
                $(id).removeClass('is-invalid');
                $(`.err${field.replace(/\./g, '\\.')}`).html('');
            }
        });
    };

    const clearFormatMt = (form, row) => {
        $(form).find(`.inputrow-${row}`).val("");
        $(form).find(`.selectrow-${row}`).each(function () {
            let idAttr = $(this).attr('id');
            if (idAttr === `katid${row}` || idAttr === `warna${row}` || idAttr === `satuan${row}`) {
                $(this).html(""); // Mengosongkan select
            }
        });
        // Mengosongkan radio button di baris tertentu
        $(form).find(`.radiorow-${row}`).prop('checked', false);
        $(`.hibah${row}`).hide();
        $(`.belibaru${row}`).hide();
        $(`.radiobelibekas${row}`).hide();
        $(`#skbarang-other${row}`).hide();
    }

    const setFieldError = (selector, errorMessage) => {
        if (errorMessage) {
            $(selector).addClass('is-invalid');
            $(selector).next('.invalid-feedback').html(errorMessage);
        } else {
            $(selector).removeClass('is-invalid');
            $(selector).next('.invalid-feedback').html('');
        }
    }

    const handleSubmitSuccess = (success, tables) => {
        $('.viewdata').hide(500);
        Swal.fire(
            'Berhasil!',
            success,
            'success'
        ).then((result) => {
            tables.forEach(table => {
                table.ajax.reload();
            });
        })
    }

    const selectReload = () => {
        if (tableBrgTetap) {
            tableBrgTetap.ajax.reload();
        }
        if (tableBrgPersediaan) {
            tableBrgPersediaan.ajax.reload();
        }
        if (tableAlokasiBrg) {
            tableAlokasiBrg.ajax.reload();
        }
        if (datarestore) {
            datarestore.ajax.reload();
        }
    }

    const hapusForm = (form) => {
        // hapus tr yang diklik
        $(form).parents('tr').remove();
        currIndex--;
        if (currIndex <= lastNumb) {
            currIndex = lastNumb + 1;
        }
        //hapus tr sebelumnya
        rowCount = $('.formtambahrow tr').length;
        for (var i = 0; i < rowCount; i++) {
            $('.formtambahrow tr').find('.btnhapusrow').hide();
        }

        rowCount === 1 ? $('.formtambahrow tr').find('.btnhapusrow').hide() :
            $(".formtambahrow tr:last-child .btnhapusrow").show();
    }

    const getIdsForm = (selector) => {
        // Array untuk menyimpan ID
        let ids = [];
        $(`#${selector}`).find('input, select, textarea').each(function () {
            let id = $(this).attr('id');
            if (id) {
                ids.push(id);
            }
        });
        return ids;
    }

    const rmValidationError = (selector, errorSelector) => {
        $(selector).on('input change', function (e) {
            e.preventDefault();
            $(this).removeClass('is-invalid');
            $(errorSelector).html('');
        });
    };

    const initializeValidationHandlers = (input, j) => {
        input.forEach((value) => {
            rmValidationError(`#${value}${j ? j : ''}`, `.err${value}${j ? j : ''}`);
        });
    }

    const getForm = (saveMethod, id, path) => {
        let url = `${path ? path : `${nav}/tampilform`}`
        const datas = {
            url,
            method: "GET",
            data: {
                saveMethod, id
            }
        };
        crud.getForm(datas);
    }
    const clearForm = (form, selector) => {
        $(`#${selector}`).find("input").val("")
        $(`#${selector}`).find("select").each(() => {
            if ($(this).attr('name') !== form) {
                $(this).html("");
            }
        })
    }

    return {
        imgQR,
        getForm,
        plusBtn,
        minusBtn,
        closeBtn,
        fetchData,
        clearForm,
        hapusForm,
        getIdsForm,
        checkrowDef,
        rmIsInvalid,
        selectReload,
        showPassword,
        setFieldError,
        clearFormatMt,
        filteringData,
        handleCheckAll,
        clearIsInvalid,
        handleSubmitSuccess,
        handleValidationErrors,
        initializeValidationHandlers
    }
})()

export { util }