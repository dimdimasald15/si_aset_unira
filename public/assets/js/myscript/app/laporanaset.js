import { crud } from "./crud.js"

export const laporanaset = (() => {
    let tableLokasi, tablePermintaan
    const initializeDashboard = (cards, bulan, tahun) => {
        dashboard.getCards(cards, bulan, tahun);
        tableLokasi = crud.initDataTable('table-lokasibrg', `${nav}/getdatalokasibrg`, tlokasiColumns, tlokasiOrder, false);
        tablePermintaan = crud.initDataTable('table-permintaan', `${nav}/getdatatablepermintaan`, tpermintaanColumns, tpermintaanOrder, false);
        viewdtcontrol('table-lokasibrg', tableLokasi);
        viewdtcontrol('table-permintaan', tablePermintaan);
    }
    const commonColumns = [
        {
            className: 'dt-control',
            orderable: false,
            sortable: false,
            data: null,
            defaultContent: '',
        },
        {
            data: 'count_brg',
            render: function (data) {
                return data + ' brg';
            },
            className: 'dt-body-center'
        }
    ];

    const tlokasiColumns = [
        commonColumns[0],
        {
            data: 'nama_ruang'
        },
        commonColumns[1]
    ];

    const tpermintaanColumns = [
        commonColumns[0],
        {
            data: 'nama_unit'
        },
        commonColumns[1],
        {
            data: 'bulan_tahun',
            render: function (data) {
                let text = data;
                let periode = text.split('/');
                const [m, y] = periode;
                var month = '';
                for (let i = 0; i < namaBulan.length; i++) {
                    if (i + 1 == m) {
                        month = namaBulan[i];
                        break;
                    }
                }
                return month + ' ' + y;
            },
            className: 'dt-body-center'
        }
    ];

    const tlokasiOrder = [
        [1, 'asc']
    ];

    const tpermintaanOrder = [
        [3, 'asc']
    ];

    const viewdtcontrol = (index, data) => {
        /* Formatting function for row details - modify as you need */
        function format(d) {
            const total_val = formatCurrency(d.total_valuasi);
            const nama_brg = formatCommaSeparated(d.nama_brg);

            let nama_anggota = '';
            if (d.hasOwnProperty('nama_anggota')) {
                nama_anggota = formatCommaSeparated(d.nama_anggota);
            }

            return `
            <table class="table table-flush cell-border" cellpadding="5" cellspacing="0" border="0" style="padding:20px;">
                ${(nama_anggota !== '') ? `
                <tr>
                    <th>Nama Anggota</th>
                    <td>${nama_anggota}</td>
                </tr>
                ` : ''}
                <tr>
                    <th>Nama Barang</th>
                    <td>${nama_brg}</td>
                </tr>
                <tr>
                    <th>Total Valuasi</th>
                    <td>${total_val}</td>
                </tr>
            </table>
        `;
        }
        crud.viewDtControl(index, data, format)
    };
    const setupChangeListener = (cards) => {
        $(document).on('change', '#selectbulan, #selecttahun', function (e) {
            e.preventDefault();
            let bulan = $('#selectbulan').val();
            let tahun = $('#selecttahun').val();
            handleSelectorChange(cards, bulan, tahun);
        });
    }
    // Function to handle changes in the month and year selectors
    function handleSelectorChange(cards, bulan, tahun) {
        set_empty();
        tableLokasi.ajax.reload();
        refreshAllChart(bulan, tahun)

        if (bulan === '' && tahun !== '') {
            dashboard.getCards(cards, bulan, tahun);
        } else if (bulan !== '' && tahun !== '') {
            dashboard.getCards(cards, bulan, tahun);
        } else if (bulan === '' && tahun === '') {
            dashboard.getCards(cards);
        }

        refreshAllChart(bulan, tahun);
    }

    const refreshAllChart = async (bulan, tahun) => {
        await permintaanChart(bulan, tahun);
    }

    async function permintaanChart(bulan, tahun) {
        try {
            const response = await $.ajax({
                type: "GET",
                url: `${nav}/getdatachartpermintaan?m=${bulan}&y=${tahun}`,
                dataType: "json"
            });

            const chartData = formatChartData(response);
            const chartOptions = getChartOptions();

            const line = document.getElementById('chart-permintaan').getContext('2d');
            new Chart(line, {
                type: 'line',
                data: chartData,
                options: chartOptions
            });
        } catch (error) {
            console.error('Error fetching chart data:', error);
        }
    }

    function formatChartData(response) {
        const labels = Object.keys(response);
        const totalValues = [];
        const abbreviations = [];

        labels.forEach(label => {
            const values = response[label].map(obj => parseInt(obj.total_valuasi));
            const abbrevs = response[label].map(obj => obj.singkatan);

            totalValues.push(values);
            abbreviations.push(abbrevs);
        });

        const colors = generateColors(abbreviations[0]);

        const datasets = abbreviations[0].map((abbr, i) => ({
            label: abbr,
            data: totalValues.map(values => values[i]),
            backgroundColor: colors[i].bgColor,
            borderWidth: 2,
            borderColor: colors[i].bdColor,
            pointBorderWidth: 0,
            pointBorderColor: colors[i].bdColor,
            pointRadius: 2,
            pointBackgroundColor: colors[i].bdColor,
            pointHoverBackgroundColor: colors[i].bdColor
        }));

        return { labels, datasets };
    }

    function getChartOptions() {
        return {
            responsive: true,
            layout: { padding: { top: 10 } },
            tooltips: {
                intersect: false,
                titleFontFamily: 'Helvetica',
                titleMarginBottom: 10,
                xPadding: 10,
                yPadding: 10,
                cornerRadius: 3
            },
            legend: { display: true, position: 'bottom' },
            scales: {
                y: { beginAtZero: true },
                yAxes: [{
                    gridLines: { display: true, drawBorder: true },
                    ticks: { display: true }
                }],
                xAxes: [{
                    gridLines: { drawBorder: true, display: true },
                    ticks: { display: true }
                }]
            }
        };
    }

    function generateColors(query) {
        return query.map((item) => {
            const hash = hashString(item);
            const r = (hash & 0xFF0000) >> 16;
            const g = (hash & 0x00FF00) >> 8;
            const b = (hash & 0x0000FF);

            return {
                bgColor: `rgba(${r}, ${g}, ${b}, 0.6)`,
                bdColor: `rgba(${r}, ${g}, ${b}, 1)`
            };
        });
    }

    function hashString(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
    }

    function set_empty() {
        $(".refreshCard").empty();
        if (myline) {
            myline.destroy();
        }
    }

    return {
        viewdtcontrol,
        initializeDashboard,
        setupChangeListener,
        refreshAllChart
    }
})()