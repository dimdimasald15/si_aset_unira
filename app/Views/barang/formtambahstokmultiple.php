<div class="card mb-3" id="cardTambahStokMultiple">
    <div class="card-header shadow-sm">
        <h5 class="card-title">Form Tambah Stok <?= ucwords($title); ?></h5>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form class="form form-vertical py-2" id="formtambahstok" onSubmit="formAddStock.insertMultiple(this, $('.table-body tr').length, event)">
                <?= csrf_field() ?>
                <?php $row = 1; ?>
                <table class=" table table-responsive-lg">
                    <thead>
                        <th>Form Tambah Stok Multiple</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="table-body">
                        <tr>
                            <td>
                                <div class="form-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-12">
                                            <h5>Form <?= $row; ?></h5>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="hidden" name="id[]" id="id<?= $row ?>">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="jenis_kat<?= $row ?>">Jenis Kategori
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-layers"></i>
                                                        </span>
                                                        <select name="jenis_kat[]" class="form-select p-2" id="jenis_kat<?= $row ?>">
                                                            <option value="">Pilih Jenis Kategori Barang</option>
                                                            <option value="Barang Tetap">Barang Tetap</option>
                                                            <option value="Barang Persediaan">Barang Persediaan</option>
                                                        </select>
                                                        <div class="invalid-feedback errjenis_kat<?= $row ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="barang_id<?= $row ?>">Nama Barang</label>
                                                    <div class="row mb-1">
                                                        <div class="input-group mb-3">
                                                            <select name="barang_id[]" class="form-select p-2" id="barang_id<?= $row; ?>"></select>
                                                            <div class="invalid-feedback errbarang_id<?= $row; ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row mb-1">
                                                    <label for="ruang_id<?= $row ?>">Lokasi Penempatan
                                                        <?= ucwords($title) ?></label>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                                        <select class="form-select" id="ruang_id<?= $row; ?>" name="ruang_id[]">
                                                            <option value="54">Sarana dan Prasarana</option>
                                                        </select>
                                                        <div class="invalid-feedback errruang_id<?= $row; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row g-2 mb-1">
                                                    <div class="col-md-6">
                                                        <label class="mb-1">Sisa Stok</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                                            <input type="number" min="1" class="form-control" placeholder="Stok Barang Saat ini" name="sisa_stok[]" id="sisastok<?= $row ?>" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="jumlah_masuk<?= $row ?>" class="mb-1">Jumlah
                                                            <?= $title ?></label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" min="1" class="form-control" id="jumlah_masuk<?= $row; ?>" placeholder="Masukkan Jumlah <?= $title ?>" name="jumlah_masuk[]">
                                                            <div class="invalid-feedback errjumlah_masuk<?= $row; ?>"></div>
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
                                                        <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tglbelilama<?= $row ?>" name="tgl_belilama[]" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="tgl_pembelian<?= $row ?>" class="mb-1">Tanggal Pembelian
                                                        Baru</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar3"></i></span>
                                                        <input type="date" class="form-control" placeholder="Masukkan Tanggal" id="tgl_pembelian<?= $row; ?>" name="tgl_pembelian[]">
                                                        <div class="invalid-feedback errtgl_pembelian<?= $row; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-bottom" style="width:1px; white-space:nowrap;">
                                <button type="button" class="btn btn-danger my-4 btn-sm btnhapusrow" onClick="util.hapusForm(this)" style="display:none;">
                                    <i class="fa fa-times"></i> Hapus form</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6 d-flex justify-content-start">
                        <button type="button" class="btn btn-primary my-4 btn-sm btntambahrow" onClick="formAddStock.handleAddRow($('.table-body tr').length+1)">
                            <i class="fa fa-plus"></i>Tambah Form</button>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-white my-4" onclick="formAddStock.closeBtnMultiple()">&laquo; Kembali</button>
                        <button type=" submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    idbrgSet = new Set();

    $(document).ready(function() {
        var formId = $('#formtambahstok');
        let rowCount = $('.table-body tr').length;
        formAddStock.looping(rowCount);
    });
</script>