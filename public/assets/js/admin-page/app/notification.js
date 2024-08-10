export const notification = (() => {
    let pusher; // Declare pusher variable here
    let channel; // Declare channel variable here
    const pusherInitPromise = new Promise((resolve, reject) => {
        fetch(`dashboard/pusherconfig`, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}` // Tambahkan header Authorization
            }
        })
            .then(response => response.json())
            .then(config => {
                pusher = new Pusher(config.key, {
                    cluster: config.cluster
                });
                // Subscribe to the channel
                channel = pusher.subscribe('notifications-channel');
                // Resolve the promise
                resolve();
            })
            .catch(error => {
                console.error('Error fetching Pusher config:', error);
                reject(error);
            });
    });

    const getNotification = () => {
        pusherInitPromise.then(() => {
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
        }).catch(error => {
            console.error('Pusher initialization failed:', error);
        });
    };

    const reportMsg = () => {
        $.ajax({
            type: "POST",
            url: "notification/getnotifikasipelaporan",
            data: { view: 'view' },
            headers: {
                'Authorization': `Bearer ${token}` // Tambahkan header Authorization
            },
        })
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
        $.ajax({
            type: "POST",
            url: "notification/notifikasipersediaan",
            data: { view: 'view' },
            headers: {
                'Authorization': `Bearer ${token}` // Tambahkan header Authorization
            },
        })
    }

    return {
        reportMsg,
        supplyItems,
        getNotification,
        showNotification
    }

})()