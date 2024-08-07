import { crud } from "./crud.js";

export const formAddStock = (() => {
    const closeBtnMultiple = () => util.closeBtnMt('#formtambahstok', '#cardTambahStokMultiple');
    const handleAddRow = (currIndex) => {
        var index = currIndex++;
        console.log(currIndex, index);
        var appendRow = forms(index);
        $(".table-body").append(appendRow);
        looping(index);
        $(".table-body tr:last-child .btnhapusrow").show();
    }
    const forms = (index) => {
        return ` <tr>
        <td>
            <div class="form-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-12">
                        <h5>Form ${index}</h5>
                    </div>
                    <div class="col-lg-12">
                        <input type="hidden" name="id[]" id="id${index}">
                        <div class="row g-2 mb-1">
                            <div class="col-md-6">
                                <label class="form-label" for="jenis_kat${index}">Jenis Kategori
                                    Barang</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-layers"></i>
                                    </span>
                                    <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat${index}">
                                        <option value="">Pilih Jenis Kategori Barang</option>
                                        <option value="Barang Tetap">Barang Tetap</option>
                                        <option value="Barang Persediaan">Barang Persediaan</option>
                                    </select>
                                    <div class="invalid-feedback errjenis_kat${index}"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="barang_id${index}">Nama Barang</label>
                                <div class="row mb-1">
                                    <div class="input-group mb-3">
                                        <select name="barang_id[]" class="form-select p-2" id="barang_id${index}"></select>
                                        <div class="invalid-feedback errbarang_id${index}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-1">
                                <label for="ruang_id${index}">Lokasi Penempatan
                                    ${capitalize(title)}</label>
                            </div>
                            <div class="row mb-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                    <select class="form-select" id="ruang_id${index}" name="ruang_id[]">
                                        <option value="54">Sarana dan Prasarana</option>
                                    </select>
                                    <div class="invalid-feedback errruang_id${index}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row g-2 mb-1">
                                <div class="col-md-6">
                                    <label class="mb-1">Sisa Stok</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                        <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok${index}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="jumlah_masuk${index}" class="mb-1">Jumlah
                                        ${title}</label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="1" class="form-control" id="jumlah_masuk${index}" placeholder="Masukkan Jumlah ${title}" name="jumlah_masuk[]">
                                        <div class="invalid-feedback errjumlah_masuk${index}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row g-2 mb-1">
                            <div class="col-md-5">
                                <label class="mb-1">Tanggal Pembelian Sebelumnya</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama${index}" name="tgl_belilama[]" readonly>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="tgl_pembelian${index}" class="mb-1">Tanggal Pembelian
                                    Baru</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                                    <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tgl_pembelian${index}" name="tgl_pembelian[]">
                                    <div class="invalid-feedback errtgl_pembelian${index}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td class="align-bottom" style="width:1px; white-space:nowrap;">
          <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" onClick="util.hapusForm(this)" style="display:none;"><i class="fa fa-times"></i> Hapus form</button>
        </td>
      </tr>`;
    }
    const looping = (row) => {
        for (var i = 1; i <= row; i++) {
            $('.table-body tr').find('.btnhapusrow').hide();
            (function (j) {
                const inputId = ["jenis_kat", "barang_id", "ruang_id", "jumlah_masuk", "tgl_pembelian"];
                util.initializeValidationHandlers(inputId, j);
                $(`#jenis_kat${j}`).on('change', function (e) {
                    e.preventDefault();
                    var jenis_kat = $(this).val();
                    selectOption.barang(`barang_id${j}`, jenis_kat)
                    // util.rmIsInvalid(`jenis_kat${j}`);
                })

                $(`#barang_id${j}`).on('change', function (e) {
                    e.preventDefault();
                    // util.rmIsInvalid(`barang_id${j}`);
                    let barang_id = $(`#barang_id${j}`).val();
                    const fieldsToReset = ["barang_id", "sisastok", "tglbelilama"]
                    barang.isDuplicate(barang_id, fieldsToReset, j);

                    var b_id = $(`#barang_id${j}`).val();
                    var r_id = $(`#ruang_id${j}`).val();

                    if (b_id != null && r_id != null) {
                        function successCallback(response) {
                            if (response) {
                                $(`#id${j}`).val(response.id);
                                $(`#sisastok${j}`).val(response.sisa_stok);
                                $(`#tglbelilama${j}`).val(response.tgl_beli);
                            }
                        }
                        const datas = {
                            barang_id: b_id,
                            ruang_id: r_id
                        }
                        barang.checkRuangBrg(datas, successCallback);
                    } else {
                        $(`#id_${j}`).val('');
                        $(`#sisastok${j}`).html('');
                        $(`#tglbelilama${j}`).html('');
                    }
                });

            })(i);
        }
    }

    const insertMultiple = (form, rowCount, event) => {
        event.preventDefault();
        let formdata = new FormData(form);
        formdata.append('jmldata', rowCount);
        const callback = (response) => {
            if (response.error) {
                handleSubmitError(response.error, rowCount);
            } else {
                const tables = [tableBrgTetap, tableBrgPersediaan];
                util.handleSubmitSuccess(response.success, tables);
            }
        };
        const datas = {
            type: "post",
            url: `${nav}/updatedatastokmultiple`,
            data: formdata,
        }
        crud.submitAjax(datas, callback);
        return false;
    }

    const handleSubmitError = (errors, rowCount) => {
        for (let i = 1; i <= rowCount; i++) {
            util.setFieldError(`#jenis_kat${i}`, errors[`jenis_kat.${i - 1}`]);
            util.setFieldError(`#barang_id${i}`, errors[`barang_id.${i - 1}`]);
            util.setFieldError(`#jumlah_masuk${i}`, errors[`jumlah_masuk.${i - 1}`]);
            util.setFieldError(`#tgl_pembelian${i}`, errors[`tgl_pembelian.${i - 1}`]);
        }
    }

    return {
        closeBtnMultiple,
        handleAddRow,
        looping,
        insertMultiple
    }
})()