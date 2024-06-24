import { util } from "./util.js";

export const auth = (() => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    const login = (form, event) => {
        event.preventDefault();
        $.ajax({
            type: "post",
            url: $(form).attr('action'),
            data: $(form).serialize(),
            dataType: "json",
            beforeSend: function () {
                $('.btnlogin').attr('disable', 'disabled');
                $('.btnlogin').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function () {
                $('.btnlogin').removeAttr('disable');
                $('.btnlogin').html('Simpan');
            },
            success: function (response) {
                const fields = ['email', 'password'];
                if (response.error) {
                    util.handleValidationErrors(fields, response.error);
                }
                if (response.sukses) {
                    Toast.fire({
                        icon: "success",
                        title: "Login successfully"
                    });
                    setTimeout(() => {
                        window.location = response.sukses.link;
                    }, 2000);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    };

    return {
        login
    };
})();
