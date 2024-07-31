export const kodebrg = (() => {
    const fetchData = (url, katid, method, callback) => {
        $.ajax({
            url,
            type: method,
            data: { katid },
            dataType: "json",
            success: callback,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    const getSubKodeBrg = (katid, row, kode1) => {
        const url = `${nav}/getsubkdbarang`;
        function callback(response) {
            $(`#skbarang${row}`).empty();
            $(`#skbarang${row}`).append('<option value="">Sub-Kode Barang</option>');
            if (response.subkdbarang == undefined) {
                $(`#subkdkategori${row}`).val(response[0].kd_kategori);
            }
            if (response[0].subkdbarang !== undefined) {
                $(`#subkdkategori${row}`).val(response[0].kd_kategori);
                $.each(response, function (key, value) {
                    $(`#skbarang${row}`).append('<option value="' + value.subkdbarang + '">' + value
                        .subkdbarang + '</option>');
                });
            }
            $(`#skbarang${row}`).append('<option value="otherbrg' +
                row + '">Lainnya</option>');
            if (kode1 !== undefined) {
                $('#skbarang').attr('disabled', 'disabled');
                $("#skbarang option").each(function () {
                    if ($(this).val() === kode1) {
                        $(this).attr("selected", "selected");
                    }
                });
            }
        }

        fetchData(url, katid, "POST", callback)
    }

    const getSubKdOtherBrg = (katid) => {
        if (katid !== null) {
            const url = `${nav}/getkdbrgbykdkat`;
            function callback(response) {
                kdbrgother = response.subkdbrgother;
            }
            fetchData(url, katid, "GET", callback)
        }
    }

    const isDuplicate = (row, value) => {
        let kodeBarang = $(`#skbrgfix${row}`).val();
        var kdbrglain = parseInt($(`#skbarang-other${row}`).val()) + 1;
        let sbkdbrgbaru = kdbrglain.toString().padStart(4, '0');

        if (kodebrgSet.has(kodeBarang)) {
            newkode = `${sbkdbrgbaru}`;
            Swal.fire({
                icon: 'info',
                text: 'Kode barang ' + kodeBarang +
                    ' sudah dimasukkan sebelumnya. Sistem akan merekomendasikan subkode barang yang baru.',
            }).then((result) => {
                $(`#skbarang-other${row}`).val(sbkdbrgbaru);
            })
        } else {
            if (value !== "kosong" && kodeBarang !== "") {
                // Tambahkan kode barang ke Set jika belum ada dan value tidak bernilai "kosong"
                kodebrgSet.add(kodeBarang);
            } else if (value === "kosong") {
                // Jika value bernilai "kosong", hapus kodeBarang dari Set berdasarkan row
                let kodeBarangLama = $(`#skbrgfix${row}`).data('kodeBarangLama');
                if (kodeBarangLama && kodebrgSet.has(kodeBarangLama)) {
                    kodebrgSet.delete(kodeBarangLama);
                }
                $(`#skbrgfix${row}`).data('kodeBarangLama', '');
            }
        }

        // Perbarui data kodeBarangLama dengan kodeBarang baru
        $(`#skbrgfix${row}`).data('kodeBarangLama', kodeBarang);
    }

    return {
        isDuplicate,
        getSubKodeBrg,
        getSubKdOtherBrg,
    }
})()