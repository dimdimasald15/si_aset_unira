import { crud } from "./crud.js";
const profile = (() => {
    const initDocReady = () => {
        const idFormProfile = util.getIdsForm('form-profile');
        util.initializeValidationHandlers(idFormProfile);
    }
    const submit = (form, event) => crud.handleFormSubmit(form, event, []);
    const updatePassword = (form, event) => crud.handleFormSubmit(form, event, []);
    function toggleFormInputs(form, enable) {
        const inputId = util.getIdsForm(form);
        inputId.forEach((val) => {
            if (val === "role") {
                $(`#${val}`).attr("disabled", !enable);
            } else if (val === "email2") {
                $(`#${val}`).toggle(!enable);
            } else {
                $(`#${val}`).attr("readonly", !enable);
            }
        });
    };
    function toggleVisibility(showEdit) {
        $(".btn-edit").toggle(showEdit);
        $("#email").toggle(!showEdit);
        $(".buttonAction").toggleClass("d-none", showEdit);
    };
    const handleEditBtn = (form) => {
        toggleFormInputs(form, true);
        toggleVisibility(false);
    };
    const handleCancelBtn = (form) => {
        toggleFormInputs(form, false);
        toggleVisibility(true);
    };

    const getForm = (id, keterangan) => {
        let url = `${nav}/tampilform`
        const datas = {
            url, method: "POST",
            data: { id, keterangan }
        };
        crud.getForm(datas);
    }
    return {
        submit,
        getForm,
        initDocReady,
        handleEditBtn,
        updatePassword,
        handleCancelBtn,
    }
})()


class PictureUpdate {
    constructor() {
        this.profile = $('.profile-pic');
        this.cover = $('.cover');

        this.updateProfile();
    }

    updateProfile() {
        const input = $('#changePicture', this.profile);
        input.change((e) => {
            const file = e.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('foto', file);
                this.fireAJAX(`${nav}/gantifoto`, formData, this.profile);
            }
        });
    }

    fireAJAX(url, data, element) {
        $.ajax({
            url: url,
            headers: {
                authorization: `Bearer ${token}`
            },
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            beforeSend: () => {
                this.startLoader(element);
            },
            success: (response) => {
                setTimeout(() => {
                    this.destroyLoader(element);
                    if (response.error) {
                        if (response.error.foto) {
                            $('#foto').addClass('is-invalid');
                            $('.errfoto').html(response.error.foto);
                        } else {
                            $('#foto').removeClass('is-invalid');
                            $('.errfoto').html('');
                        }
                    } else {
                        $('> img', element).attr("src", response.image_url);
                    }
                }, 2000);
            },
            error: (xhr) => {
                this.destroyLoader(element);
                alert(`Error: ${xhr.status} - ${xhr.statusText}`);
            }
        });
    }

    startLoader(element) {
        const loader = $('.layer', element);
        loader.addClass("visible");
    }

    destroyLoader(element) {
        const loader = $('.layer', element);
        loader.removeClass("visible");
    }
}

export { profile, PictureUpdate }
