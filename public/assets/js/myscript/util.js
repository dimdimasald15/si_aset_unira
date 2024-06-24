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

    const getCardOrModal = (datas) => {
        let data = datas.data;
        $.ajax({
            type: "post",
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

    const fetchDataFilter = (url, jenis_kat, selectId) => {
        $.ajax({
            type: "get",
            url: url,
            data: { jenis_kat: jenis_kat },
            dataType: "json",
            success: function (response) {
                const $select = $(`#${selectId}`);
                $select.empty(); // Clear existing options
                $select.append('<option value="">Pilih Semua</option>');
                response.forEach(item => {
                    $select.append(`<option value="${item.id}">${item.text}</option>`);
                });
            }
        });
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

    const formatResult = (data) => {
        if (!data.id) {
            return data.text;
        }
        var $result = $(
            `<span><i class="bi bi-layers"> </i>${data.text}</span>`
        );
        return $result;
    }

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
            const id = field === "asal" ? `.${field}brg .form-check-input` : `#${field}`
            if (errors[field]) {
                $(id).addClass('is-invalid');
                $(`.err${field}`).html(errors[field]);
            } else {
                $(id).removeClass('is-invalid');
                $(`.err${field}`).html('');
            }
        });
    };

    const clearFormatMt = (row) => {
        $('.formsimpanmultiple').find("input").val("")
        $('.formsimpanmultiple').find("select").html("")
        $('.formsimpanmultiple').find("input[type='radio']").prop('checked', false);
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

    return {
        imgQR,
        plusBtn,
        minusBtn,
        closeBtn,
        checkrowDef,
        clearFormatMt,
        formatResult,
        rmIsInvalid,
        showPassword,
        setFieldError,
        filteringData,
        formatResult2,
        handleCheckAll,
        getCardOrModal,
        clearIsInvalid,
        handleSubmitSuccess,
        handleValidationErrors,
    }
})()

export { util }