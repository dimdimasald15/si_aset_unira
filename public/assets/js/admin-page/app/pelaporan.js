import { crud } from "./crud.js";
import { util } from "./util.js";

export const pelaporan = (() => {
    // Function to toggle the sidebar
    const toggleSidebar = (isBurgerVisible) => {
        $('#logo-unira').toggle(!isBurgerVisible);
        $('.sidebar2-x').toggle(!isBurgerVisible);
        $('.sidebar2-burger').toggle(isBurgerVisible);
        $('.sidebar-text').toggle();
        $('.sidebar-left').css('width', isBurgerVisible ? '80px' : '25%');
        $('.email-app-menu').css('width', isBurgerVisible ? '80px' : '100%');
    }
    const initDocReady = () => {
        $('.sidebar2-burger').hide();
        $('#checkall').prop('checked', false);
        util.handleCheckAll('#checkall', `.checkrow`);
    }

    const inboxMenu = (form, no_laporan) => {
        console.log(no_laporan);
        $(form).addClass('active');
        $('#trash-menu').removeClass('active');
        toggleElements(["#restoredata", "#multipledeletepermanen", "#search2"], ["#multipledelete", "#search1", "checkall1"]);

        if (no_laporan !== "") {
            showEmailAction();
            fetchDataAndUpdateUI(`${nav}/tampilcardpelaporan?isRestored=0`);
        } else {
            $('.pelaporan-detail').hide(500);
            $('.email-user-list').show(500);
            showEmailAction();
        }
    };

    const trashMenu = (no_laporan) => {
        $('#trash-menu').addClass('active');
        $('#inbox-menu').removeClass('active');
        toggleElements(["#multipledelete", "#search1", "checkall1"], ["#restoredata", "#multipledeletepermanen", "#search2"]);

        if (no_laporan !== "") {
            showEmailAction();
            fetchDataAndUpdateUI(`${nav}/tampilcardpelaporan?isRestored=1`);
        } else {
            $('.email-user-list').hide(500);
            showEmailAction();
            fetchDataAndUpdateUI(`${nav}/tampilcardpelaporan?isRestored=1`, updatePelaporanDetail);
        }
    };

    const toggleElements = (elementsToHide, elementsToShow) => {
        util.toggleElements(elementsToHide, elementsToShow);
    };

    const showEmailAction = () => {
        $('.email-action').removeClass('d-none');
    };

    const fetchDataAndUpdateUI = (url, callback = updateSemuapelaporan) => {
        const datas = { type: "get", url: url };
        util.fetchData(datas, callback);
    };

    const updateSemuapelaporan = (response) => {
        $('#detail_laporan_kerusakan').hide(500);
        $('#semuapelaporan').html(response.data).show(500);
    };

    const updatePelaporanDetail = (response) => {
        $('.pelaporan-detail').html(response.data).show(500);
    };

    const multipleDelete = (form, event) => crud.handleMultipleDelete(form, event, [], '.checkrow', '');

    const setActionType = (type) => {
        $('#actionType').val(type); // Set the action type
    }

    const handleSubmitformRecycle = (form, event) => {
        event.preventDefault();
        const jmldata = $(form).find('input.checkrow:checked');
        const formdata = new FormData(form);
        const actionType = $("#actionType").val();
        if (jmldata.length === 0) {
            Swal.fire(
                'Gagal!',
                `Tidak ada data ${title.toLowerCase()} yang dipilih`,
                'info'
            );
            return;
        }
        if (actionType === "restore") {
            let textTitle = `Apakah anda ingin memulihkan semua data ${title.toLowerCase()} yang telah terhapus?`;
            let url = `${nav}/restore`;
            crud.handleRestore(formdata, textTitle, "", "restore", url, false);
        } else {
            let textTitle = `Apakah kamu yakin ingin menghapus ${jmldata.length} data secara permanen?`;
            let text = `Data akan terhapus selamanya dan tidak dapat dipulihkan lagi!`;
            let url = `${nav}/multipledeletepermanen`;
            crud.handleDelete(url, formdata, textTitle, "", "permanent", text);
        }
        return false;
    }

    const detailLaporan = (string, viewed) => {
        $('.email-user-list').hide(500);
        $('.email-action').addClass('d-none', true);
        const datas = {
            url: `${nav}/tampildetailpelaporan/` + string,
            data: { viewed },
        }
        function callback(response) {
            $('.pelaporan-detail').empty();
            $('.pelaporan-detail').html(response.data).show(500);
        }
        util.fetchData(datas, callback);
    }
    const searchFilter = (bool) => {
        let keywords = $('#search1').val() || $('#search2').val() || '';
        $('.email-user-list').hide();
        if (keywords !== '') {
            $.ajax({
                type: 'get',
                url: `${nav}/tampilcardpelaporan`,
                data: { keywords, isRestored: bool },
                dataType: 'json',
                beforeSend: () => { $('.loading').show(); },
                complete: () => { $('.loading').fadeOut("slow"); },
                success: function (response) {
                    $('.pelaporan-detail').html('');
                    $('.pelaporan-detail').html(response.data).show();
                }
            });
        } else if (keywords == '' && bool == 0) {
            $('.pelaporan-detail').html('').hide();
            $('.email-user-list').show();
        } else if (keywords == '' && bool == 1) {
            trashMenu();
        }
    }
    return {
        inboxMenu,
        trashMenu,
        searchFilter,
        initDocReady,
        toggleSidebar,
        detailLaporan,
        setActionType,
        multipleDelete,
        handleSubmitformRecycle,
    }
})()