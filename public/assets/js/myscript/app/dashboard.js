export const dashboard = (() => {
    const getCards = (cards, bulan, tahun) => {
        return cards.forEach((val, i) => {
            if (val.id == "brgtetap" || val.id == "brgpersediaan") {
                getCountBarang('getcountbrg', `${val.title}`, `#${val.id}`, `kelola-barang#${val.id}`, bulan, tahun);
            } else if (val.id == "permintaan" || val.id == "peminjaman") {
                getCountBrgKeluar(`${capitalize(val.id).replace(/\s+/g, '')}`, `#${val.id}`, `${val.id}-barang`, bulan, tahun);
            } else if (val.id == "gedung" || val.id == "ruang") {
                getCountProp(`getcount${val.id}`, `#${val.id}`, `${val.id}`);
            }
        })
    }
    const getCountBarang = (method, jenis_kat, targetId, hrefLink, bulan = null, tahun = null) => {
        $.ajax({
            url: `${nav}/${method}`,
            data: {
                jenis_kat,
                m: bulan,
                y: tahun,
            },
            dataType: "json",
            success: function (response) {
                let totalval = Number(response.total_valuasi);
                let valuasiFormatted = 'Rp ' + totalval.toLocaleString('id-ID') + ',-';
                $(targetId).find('h6').after(`
                    <div class="refreshCard">
                    <h6 class="count font-extrabold">${response.result}</h6>
                    <h6 class="text-muted font-semibold">Total Valuasi</h6>
                    <h6 class="count2 font-extrabold">${valuasiFormatted}</h6>
                    </div>
                `);
                counterNumber(`${targetId} .count`, response.result, response.result);
                counterNumber(`${targetId} .count2`, totalval, valuasiFormatted);
                if (!bulan && !tahun) {
                    $(targetId).after(`
                        <div class="col-md-12 mt-0">
                        <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
                        </div>
                    `);
                }
            }
        });
    }
    function getCountBrgKeluar(jenistrx, targetId, hrefLink, bulan = null, tahun = null) {
        $.ajax({
            type: "get",
            url: `${nav}/getcountbrgkeluar`,
            data: {
                jenistrx,
                m: bulan,
                y: tahun,
            },
            dataType: "json",
            success: function (response) {
                if (response.jenistrx == "Peminjaman") {
                    $(targetId).find('h6').after(`
                        <div class="refreshCard">
                        <h6 class="count font-extrabold">${response.data.pengguna}</h6>
                        <h6 class="text-muted font-semibold">Barang dipinjam</h6>
                        <h6 class="count2 font-extrabold">${(response.data.total_brg !== null) ? `${response.data.total_brg}` : `0`}</h6>
                        </div>
                    `);
                } else if (response.jenistrx == "Permintaan") {
                    $(targetId).find('h6').after(`
                        <div class="refreshCard">
                        <h6 class="count font-extrabold">${response.data.pengguna}</h6>
                        <h6 class="text-muted font-semibold">Barang diminta</h6>
                        <h6 class="count2 font-extrabold">${(response.data.total_brg !== null) ? `${response.data.total_brg}` : `0`}</h6>
                        </div>
                    `);
                }
                counterNumber(`${targetId} .count`, response.data.pengguna, response.data.pengguna);
                counterNumber(`${targetId} .count2`, response.data.total_brg, response.data.total_brg);
                if (!bulan && !tahun) {
                    $(targetId).after(`
                        <div class="col-md-12 mt-0">
                        <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
                        </div>
                    `);
                }
            }
        });
    }

    const getCountProp = (method, targetId, hrefLink) => {
        $.ajax({
            type: "get",
            url: `${nav}/${method}`,
            dataType: "json",
            success: function (response) {
                $(targetId).find('h6').after(`
            <h6 class="count font-extrabold">${response.result}</h6>
          `);
                counterNumber(`${targetId} .count`, response.result, response.result);
                $(targetId).after(`
            <div class="col-md-12 mt-5">
              <p class="text-end m-0"><a href="${hrefLink}">Selengkapnya <i class="fa fa-arrow-circle-right"></i></a></p>
            </div>
          `);
            }
        });
    }

    return {
        getCards
    }
})()