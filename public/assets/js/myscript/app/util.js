import { crud } from "./crud.js";

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

    const fetchData = (datas, callback) => {
        $.ajax({
            url: datas.url,
            data: datas.data,
            type: datas.type,
            dataType: "json",
            success: callback,
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    const fetchDataFilter = (url, jenis_kat, selectId) => {
        let datas = {
            type: "get",
            url,
            data: { jenis_kat },
        }
        function callback(response) {
            const $select = $(`#${selectId}`);
            $select.empty(); // Clear existing options
            $select.append('<option value="">Pilih Semua</option>');
            response.forEach(item => {
                $select.append(`<option value="${item.id}">${item.text}</option>`);
            });
        }
        fetchData(datas, callback);
    }

    const filteringData = (jenis_kat) => {
        fetchDataFilter(`${nav}/pilihbarang`, jenis_kat, 'selectbarang');
        fetchDataFilter(`${nav}/pilihkategori`, jenis_kat, 'selectkategori');
    }

    const handleCheckAll = (checkbox, target) => {
        $(checkbox).click(function () {
            const isChecked = this.checked;
            $(target).prop('checked', isChecked);
            if (isChecked) {
                $(target).closest('tr').addClass('select_warna');
            } else {
                $(target).closest('tr').removeClass('select_warna');
            }
        });

        $(document).on('click', target, function () {
            const allChecked = $(target).length === $(target + ':checked').length;
            $(checkbox).prop('checked', allChecked);

            const isChecked = $(this).prop('checked');
            if (isChecked) {
                $(this).closest('tr').addClass('select_warna');
            } else {
                $(this).closest('tr').removeClass('select_warna');
            }
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

    const rmIsInvalid = (id) => {
        $(`#${id}`).removeClass('is-invalid');
        $(`.err${id}`).html('');
    }

    const showPassword = (form) => {
        if ($(form).is(':checked')) {
            $('#password').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
        }
    }

    const handleValidationErrors = (fields, errors) => {
        fields.forEach(field => {
            const id = field.includes('.') ? `#${field.replace(/\./g, '\\.')}` : `#${field}`;
            if (errors[field]) {
                $(id).addClass('is-invalid');
                $(`.err${field.replace(/\./g, '\\.')}`).html(errors[field]);
            } else {
                $(id).removeClass('is-invalid');
                $(`.err${field.replace(/\./g, '\\.')}`).html('');
            }
        });
    };

    const clearFormatMt = (form, row) => {
        $(form).find(`.inputrow-${row}`).val("");
        $(form).find(`.selectrow-${row}`).each(function () {
            let idAttr = $(this).attr('id');
            if (idAttr === `katid${row}` || idAttr === `warna${row}` || idAttr === `satuan${row}`) {
                $(this).html(""); // Mengosongkan select
            }
        });
        // Mengosongkan radio button di baris tertentu
        $(form).find(`.radiorow-${row}`).prop('checked', false);
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

    const selectReload = () => {
        if (tableBrgTetap) {
            tableBrgTetap.ajax.reload();
        }
        if (tableBrgPersediaan) {
            tableBrgPersediaan.ajax.reload();
        }
        if (tableAlokasiBrg) {
            tableAlokasiBrg.ajax.reload();
        }
        if (datarestore) {
            datarestore.ajax.reload();
        }
    }

    const hapusForm = (form) => {
        // hapus tr yang diklik
        $(form).parents('tr').remove();
        currIndex--;
        if (currIndex <= lastNumb) {
            currIndex = lastNumb + 1;
        }
        //hapus tr sebelumnya
        rowCount = $('.formtambahrow tr').length;
        for (var i = 0; i < rowCount; i++) {
            $('.formtambahrow tr').find('.btnhapusrow').hide();
        }

        rowCount === 1 ? $('.formtambahrow tr').find('.btnhapusrow').hide() :
            $(".formtambahrow tr:last-child .btnhapusrow").show();
    }

    const getIdsForm = (selector) => {
        // Array untuk menyimpan ID
        let ids = [];
        $(`#${selector}`).find('input, select, textarea').each(function () {
            let id = $(this).attr('id');
            if (id) {
                ids.push(id);
            }
        });
        return ids;
    }

    const rmValidationError = (selector, errorSelector) => {
        $(selector).on('input change', function (e) {
            e.preventDefault();
            $(this).removeClass('is-invalid');
            $(errorSelector).html('');
        });
    };

    const initializeValidationHandlers = (input, j) => {
        input.forEach((value) => {
            rmValidationError(`#${value}${j ? j : ''}`, `.err${value}${j ? j : ''}`);
        });
    }

    const getForm = (saveMethod, id, path) => {
        let url = `${path ? path : `${nav}/tampilform`}`
        const datas = {
            url,
            method: "GET",
            data: {
                saveMethod, id
            }
        };
        crud.getForm(datas);
    }

    const clearForm = (form, selector) => {
        $(`#${selector}`).find("input").val("")
        $(`#${selector}`).find("select").each(() => {
            if ($(this).attr('name') !== form) {
                $(this).html("");
            }
        })
    }

    const appendRowItemTransaction = (row, form) => {
        let saveMethod = form.attr('saveMethod');
        for (var i = 1; i <= row; i++) {
            $('#tambahrow tr').find('.btnhapusrow').hide();
            (function (j) {
                selectOption.barang(`barang_id${j}`, jenis_kat);
                $(`#barang_id${j}`).on('change', function (e) {
                    e.preventDefault();
                    rmIsInvalid(`barang_id${j}`);
                    rmIsInvalid(`satuan${j}`);
                    var b_id = $(`#barang_id${j}`).val();
                    var r_id = 54;
                    const fieldToReset = ["barang_id", "satuan", "jumlah"];
                    barang.isDuplicate(b_id, fieldToReset, j);
                    if (b_id != null && r_id != null) {
                        function callback(response) {
                            $(`#satuan${j}`).prop('disabled', true);
                            $(`#satuan${j}`).html('<option value = "' + response.satuan_id + '" selected >' + response.kd_satuan + '</option>');
                            $(`#sisastok${j}`).val(response.sisa_stok);
                            if (saveMethod == "update") {
                                sisa_stok_lama.pop();
                                $(`#jumlah${j}`).val('');
                            }
                            sisa_stok_lama.push(response.sisa_stok);
                        }
                        const datas = {
                            barang_id: b_id,
                            ruang_id: r_id
                        }
                        barang.checkRuangBrg(datas, callback);
                    } else {
                        $(`#jumlah${j}`).html('');
                        $(`#satuan${j}`).prop('disabled', false);
                        $(`#satuan${j}`).html('');
                    }
                });
                selectOption.satuan(`satuan${j}`);
                $(`#jml_barang${j}`).on('input', function (e) {
                    e.preventDefault();
                    rmIsInvalid(`jml_barang${j}`);
                    if ($(this).val() == '') {
                        if (saveMethod == "update") {
                            var sisa_stok_update = parseInt(sisa_stok_lama[j - 1]) + parseInt(jumlah_lama[j - 1]);
                            form.find(`input[name='sisa_stok${j}']`).val(sisa_stok_update);
                        } else {
                            form.find(`input[name='sisa_stok${j}']`).val(sisa_stok_lama[j - 1]);
                        }
                    } else {
                        var jml_minta = $(this).val();
                        if (saveMethod == "update") {
                            var sisa_stok_baru = parseInt(sisa_stok_lama[j - 1]) + parseInt(jumlah_lama[j - 1]) - parseInt(jml_minta);
                        } else {
                            var sisa_stok_baru = parseInt(sisa_stok_lama[j - 1]) - parseInt(jml_minta);
                        }
                        $(`#sisastok${j}`).val(sisa_stok_baru);
                    }
                    if ($(`#sisastok${j}`).val() < 0) {
                        $(`#sisastok${j}`).val(0)
                        $(`#sisastok${j}`).addClass('is-invalid');
                        $(`.errsisastok${j}`).html('sisa stok tidak boleh kurang dari 0');
                        $(`#jumlah${j}`).addClass('is-invalid');
                        $(`.errjumlah${j}`).html('input tidak boleh lebih dari ' + sisa_stok_lama[j - 1]);
                    } else {
                        $(`#sisastok${j}`).val(sisa_stok_baru);
                        $(`#sisastok${j}`).removeClass('is-invalid');
                        rmIsInvalid(`sisastok${j}`);
                        rmIsInvalid(`jmlkeluar${j}`);
                    }
                })
            })(i)
        }
    }

    const addRowItemTransaction = (form) => {
        var index = currIndex++;
        $("#tambahrow").append(`
      <tr>
        <td>${index}</td>
        <td>
          <select name="barang_id${index}" class="form-select p-2" id="barang_id${index}" style="width: 400px;"></select>
          <div class="invalid-feedback errbarang_id${index}"></div>
        </td>
        <td> <input type="number" class="form-control" id="sisastok${index}" placeholder="Sisa Stok Barang"  name="sisa_stok${index}" readonly>
          <div class="invalid-feedback errsisastok${index}"></div>
        </td>
        <td> <input type="number" min="1" class="form-control" id="jml_barang${index}" placeholder="Masukkan Jumlah Permintaan Barang" name="jml_barang${index}">
          <div class="invalid-feedback errjml_barang${index}"></div>
        </td>
        <td>
          <select name="satuan_id${index}" class="form-select p-2" id="satuan${index}"></select>
          <div class="invalid-feedback errsatuan${index}"></div>
        </td>
        <td style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger btn-sm btnhapusrow" onClick="util.deleteRowItemTransaction(this)">
          <i class="fa fa-times"></i>
          </button>
        </td>
      </tr>
    `);
        rowCount = $('#tambahrow tr').length;
        appendRowItemTransaction(rowCount, form);
        $("#tambahrow tr:last-child .btnhapusrow").show();
    }

    const deleteRowItemTransaction = (form) => {
        $(form).parents('tr').remove();
        currIndex--;
        if (currIndex <= lastNumb) {
            currIndex = lastNumb + 1;
        }
        //hapus tr sebelumnya
        rowCount = $('#tambahrow tr').length;
        for (var i = 0; i < rowCount; i++) {
            $('#tambahrow tr').find('.btnhapusrow').hide();
        }
        rowCount === 1 ? $('#tambahrow tr').find('.btnhapusrow').hide() :
            $("#tambahrow tr:last-child .btnhapusrow").show();
    }

    return {
        imgQR,
        getForm,
        plusBtn,
        minusBtn,
        closeBtn,
        fetchData,
        clearForm,
        hapusForm,
        getIdsForm,
        checkrowDef,
        rmIsInvalid,
        selectReload,
        showPassword,
        setFieldError,
        clearFormatMt,
        filteringData,
        handleCheckAll,
        clearIsInvalid,
        handleSubmitSuccess,
        handleValidationErrors,
        deleteRowItemTransaction,
        appendRowItemTransaction,
        addRowItemTransaction,
        initializeValidationHandlers,
    }
})()

export { util }