
export const reportAssets = (() => {
    const handleBtnNext1 = () => {
        let optionSelected = false;
        $('.option .form-check-input').each(function () {
            if ($(this).is(':checked')) {
                optionSelected = true;
                $(".option .form-check-input").removeClass("is-invalid");
                $(".erroption").html('');
                return false; // keluar dari loop
            }
        });
        if (!optionSelected) {
            $(".option .form-check-input").addClass("is-invalid");
            $(".erroption").html('Pilih salah satu opsi');
            return; // berhenti di sini, jangan lanjut ke form berikutnya
        }

        if ($('#opsi1').is(':checked')) {
            util.toggleElements(['#intro', '.oldmember', '#anggota_id', '#formbrgrusak', '.btn-cancel1'], ['#newmember']);
        } else if ($('#opsi2').is(':checked')) {
            util.toggleElements(['#intro', '#newmember'], ['#formbrgrusak', '.oldmember', '#anggota_id', '.btn-cancel1', '.level2']);
            $('#btn-cancel2').hide();
        }
    }

    const clearForm = () => {
        const title = $('#title').val() || "";
        const nolaporan = $('#nolaporan').val() || "";
        $('#formlaporbrg').find("input").val("")
        $('#title').val(title)
        $('#nolaporan').val(nolaporan)
        $('#unit_id').html('');
        $('#level').val('');
        $('#anggota_id').val('');
        $('.previewimage').empty();
    }

    const defaulthide = () => {
        const elementsToHide = ['#newmember', '#formbrgrusak', '.oldmember',
            '.noanggota', '#anggota_id', '.btngroup1', '.btngroup2', '.btn-cancel1',
            '#btn-cancel2', '#opsiubahlaporan'];
        hideElements(elementsToHide);
        $('#formbrgrusak').hide(500); // Separate handling for the animation duration
    }

    const handleBtnCancel1 = () => {
        $('#intro').show(500);
        clearForm();
        defaulthide();
        util.clearIsInvalid("#formlaporbrg");
    }

    const handleBtnCancel2 = () => {
        const hideElements = ["#intro", "#formbrgrusak", ".btngroup2"];
        const showElements = ["#newmember", ".btn-cancel1"];
        util.clearIsInvalid("#formlaporbrg");
        util.toggleElements(hideElements, showElements)
    }

    function hideElements(selectors) {
        selectors.forEach(selector => $(selector).hide());
    }

    function handleValidationRemoval(inputSelector, errorSelector) {
        $(inputSelector).removeClass('is-invalid');
        $(errorSelector).html('');
    }

    function handleAnggotaIdChange(e) {
        e.preventDefault();

        handleValidationRemoval('#anggota_id', '.erranggota_id');
        toggleButtons('.btngroup2', true);
        toggleButtons('.btn-cancel1', true);
        toggleButtons('#btn-cancel2', false);
    }

    function handleNamaAnggotaKeyup(e) {
        e.preventDefault();
        handleValidationRemoval('#nama_anggota', '.errnama_anggota');
        if ($("#nama_anggota").val() !== "") {
            toggleButtons('.btngroup1', true);
            toggleButtons('.btn-cancel1', true);
        } else {
            toggleButtons('.btngroup1', false);
            toggleButtons('.btn-cancel1', false);
        }
    }

    function handleNoAnggotaKeyup(e) {
        e.preventDefault();
        handleValidationRemoval('#no_anggota', '.errno_anggota');
    }

    function handleUnitChange(e) {
        e.preventDefault();
        handleValidationRemoval('#unit_id', '.errunit_id');
    }

    function handleNoHpChange(e) {
        e.preventDefault();
        handleValidationRemoval('#nohp', '.errnohp');
    }

    function handleBtnNext2Click() {
        const formData = {
            nama_anggota: $('#nama_anggota').val(),
            level: $('#level').val(),
            unit_id: $('#unit_id').val(),
            no_anggota: $('#no_anggota').val(),
            nohp: $('#nohp').val()
        };

        $.ajax({
            type: "post",
            url: `${nav}/cekanggota`,
            data: formData,
            dataType: "json",
            success: handleAjaxSuccess
        });
    }

    function handleAjaxSuccess(response) {
        const fields = ['nama_anggota', 'no_anggota', 'level', 'unit_id', 'nohp'];
        if (response.error) {
            util.handleValidationErrors(fields, response.error);
        } else if (response.success) {
            handleSuccessResponse();
        }
    }

    function handleSuccessResponse() {
        $('#newmember').hide(500);
        $('#formbrgrusak').show(500);
        $('.oldmember').hide(500);
        $('#anggota_id').hide();
        toggleButtons('.btngroup2', true);
        toggleButtons('#btn-cancel2', true);
        toggleButtons('.btn-cancel1', false);
        $('.level2').hide();
    }

    function toggleButtons(selector, show) {
        show ? $(selector).show(500) : $(selector).hide();
    }

    const initializeForm = () => {
        defaulthide();
        $('.btn-cancel1').on('click', function () {
            handleBtnCancel1();
        });

        $('#level2').on('change', function (e) {
            e.preventDefault();
            var level = $(this).val();
            var placeholder, length = 8;
            if (level == "Karyawan") {
                placeholder = 'Masukkan NIY/NIDN';
            } else {
                placeholder = 'Masukkan NIM'
            };
            selectOption.anggota("anggota_id", level, placeholder, length);
        })

        // Event handler mapping
        const eventHandlers = [
            { selector: '#anggota_id', event: 'change', action: handleAnggotaIdChange },
            { selector: '#nama_anggota', event: 'keyup', action: handleNamaAnggotaKeyup },
            { selector: '#no_anggota', event: 'keyup', action: handleNoAnggotaKeyup },
            { selector: '#unit_id', event: 'change', action: handleUnitChange },
            { selector: '#nohp', event: 'change', action: handleNoHpChange },
            { selector: '#btn-next2', event: 'click', action: handleBtnNext2Click }
        ];
        // Register event handlers
        eventHandlers.forEach(handler => {
            $(handler.selector).on(handler.event, handler.action);
        });
        const fields = ["jml_barang", "files"];
        util.initializeValidationHandlers(fields);
    }


    return {
        handleBtnNext1,
        clearForm,
        defaulthide,
        handleBtnCancel1,
        handleBtnCancel2,
        handleNamaAnggotaKeyup,
        handleNoAnggotaKeyup,
        handleNoHpChange,
        handleUnitChange,
        handleBtnNext2Click,
        handleAnggotaIdChange,
        initializeForm
    }
})()