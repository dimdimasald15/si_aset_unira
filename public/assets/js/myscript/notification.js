export const notification = (() => {
    var pusher = new Pusher('f04a9e3d37bbfe1cfb52', {
        cluster: 'ap1'
    });

    // Subscribe to the channel and bind to events
    var channel = pusher.subscribe('notifications-channel');
    const getNotification = () => {
        reportMsg();
        supplyItems();
        // Bind to pelaporan event
        channel.bind('pelaporan-event', function (data) {
            updateReport(data);
        });
        // Bind to notifpersediaan event
        channel.bind('supplyItems-event', function (data) {
            updateSupplyItems(data);
        });
    }

    const reportMsg = () => {
        $.post("notification/getnotifikasipelaporan", { view: 'view' });
    }

    const showNotification = (show, off) => {
        $(`#${show}`).toggleClass('show');
        $(`#${off}`).removeClass('show');
    }

    function updateReport(data) {
        $('#showpelaporan').html(data.notification);
        $('#showpelaporan').append(`
            <hr class="dropdown-divider">
            <li><a class="dropdown-item" href="${BASE_URL}/admin/notification">Lihat Semua Pelaporan</a></li>
        `);
        if (data.unseen_notification > 0) {
            $('#pelaporanmasuk').html(`
                <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                <span class="badge rounded-pill badge-sm badge-notification bg-warning" style="color:black;cursor:pointer;" id="notification_count">${data.unseen_notification}</span>
            `);
        } else {
            $('#pelaporanmasuk').html(`
                <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
            `);
        }
    }

    // Function to update notifpersediaan notifications
    function updateSupplyItems(data) {
        $('#shownotif').html(data.notification);
        $('#shownotif').append(`
            <hr class="dropdown-divider">
            <li><a class="dropdown-item" href="${BASE_URL}/admin/kelola-barang#brgpersediaan">Lihat Selengkapnya</a></li>
            `);
        if (data.unseen_notification > 0) {
            $('#notifpersediaan').html(`
                <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                <span class="badge rounded-pill badge-sm badge-notification bg-danger" style="color:white;cursor:pointer;" id="notification_count">${data.unseen_notification}</span>
            `);
        } else {
            $('#notifpersediaan').html(`
                <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
            `);
        }
    }

    const supplyItems = () => {
        $.post("notification/notifikasipersediaan");
    }

    return {
        reportMsg,
        supplyItems,
        getNotification,
        showNotification
    }

})()