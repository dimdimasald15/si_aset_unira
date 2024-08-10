<div class="card mb-3" id="cardmultipleinsert">
    <div class="card-header shadow-sm">
        <h5 class="card-title">Form Tambah <?= ucwords($title); ?></h5>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form class="form form-vertical py-2" id="formsimpanmultiple" onSubmit="formbrg.insertMultiple(this, $('.table-body tr').length, event)">
                <?= csrf_field() ?>
                <?php $no = 1; ?>
                <table class="table table-responsive-lg">
                    <thead>
                        <th>Form</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="table-body">
                        <tr>
                            <td>
                                <div class="form-body">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-12">
                                            <h5>Form <?= $no ?></h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="jenis_kat<?= $no ?>">Jenis Kategori
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-layers"></i>
                                                        </span>
                                                        <select name="jenis_kat[]" class="form-select selectrow-<?= $no ?> p-2" id="jenis_kat<?= $no ?>">
                                                            <option value="">Pilih Jenis Kategori Barang</option>
                                                            <option value="Barang Tetap">Barang Tetap</option>
                                                            <option value="Barang Persediaan">Barang Persediaan</option>
                                                        </select>
                                                        <div class="invalid-feedback errjenis_kat<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="katid<?= $no ?>">Nama
                                                        Kategori</label>
                                                    <div class="input-group mb-3">
                                                        <select name="kat_id[]" class="form-select selectrow-<?= $no ?> p-2" id="katid<?= $no ?>"></select>
                                                        <div class="invalid-feedback errkatid<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="subkdkategori<?= $no ?>">Kode Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-upc"></i>
                                                        </span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" name="kd_kategori[]" placeholder="Kode Kategori" id="subkdkategori<?= $no ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="skbarang<?= $no ?>"></label>
                                                    <div class="input-group mb-3">
                                                        <select name="skbrg[]" class="form-select selectrow-<?= $no ?>" id="skbarang<?= $no ?>"></select>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Kode Barang" id="skbarang-other<?= $no ?>" name="skbrg_lain[]" style="display:none;">
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" id="skbrgfix<?= $no ?>" name="kode_brg[]" readonly style="display:none;">
                                                        <div class="invalid-feedback errskbarang<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="merk<?= $no ?>">Merk</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-tags"></i></span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan Merk" id="merk<?= $no ?>" name="merk[]">
                                                        <div class="invalid-feedback errmerk<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tipe<?= $no ?>" class="form-label">Tipe Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan tipe" id="tipe<?= $no ?>" name="tipe[]">
                                                        <div class="invalid-feedback errtipe<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="warna<?= $no ?>" class="form-label">Warna</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-palette"></i></span>
                                                        <select class="form-select selectrow-<?= $no ?>" id="warna<?= $no ?>" name="warna[]"></select>
                                                        <div class="invalid-feedback errwarna<?= $no ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row mb-1">
                                                <label class="form-label" for="namabarang<?= $no ?>">Nama Barang</label>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                                    <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan Nama Barang" id="namabarang<?= $no ?>" name="nama_brg[]">
                                                    <div class="invalid-feedback errnamabarang<?= $no ?>"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-5 mb-3 asalbrg<?= $no ?>">
                                                    <label class="form-label">Asal <?= $title; ?></label>
                                                    <div class="form-check">
                                                        <input class="form-check-input radiorow-<?= $no ?>" type="radio" name="asal<?= $no ?>" id="belibaru<?= $no ?>" value="beli baru">
                                                        <label class="form-check-label" for="belibaru<?= $no ?>">
                                                            Beli Baru
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input radiorow-<?= $no ?>" type="radio" name="asal<?= $no ?>" id="belibekas<?= $no ?>" value="beli bekas">
                                                        <label class="form-check-label" for="belibekas<?= $no ?>">
                                                            Beli Bekas
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input radiorow-<?= $no ?>" type="radio" name="asal<?= $no ?>" id="hibah<?= $no ?>" value="hibah">
                                                        <label class="form-check-label" for="hibah<?= $no ?>">
                                                            Hibah
                                                        </label>
                                                        <div class="invalid-feedback errasalbrg<?= $no ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 radiobelibekas<?= $no ?>" style="display:none;">
                                                    <label class="form-label">Beli bekas dimana?</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input radiorow-<?= $no ?>" type="radio" id="radiotoko<?= $no ?>">
                                                        <label class="form-check-label" for="radiotoko<?= $no ?>">
                                                            Beli di toko
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input radiorow-<?= $no ?>" type="radio" id="radioinstansi<?= $no ?>">
                                                        <label class="form-check-label" for="radioinstansi<?= $no ?>">
                                                            Beli di Instansi
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 mb-3 belibaru<?= $no ?>" style="display:none;">
                                                    <label for="toko<?= $no ?>" class="form-label">Nama Toko</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan nama toko" id="toko<?= $no ?>" name="toko[]">
                                                        <div class="invalid-feedback errtoko"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 hibah<?= $no ?>" style="display:none;">
                                                    <label for="instansi<?= $no ?>" class="form-label">Nama
                                                        Instansi</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan Nama Instansi" id="instansi<?= $no ?>" name="instansi[]">
                                                        <div class="invalid-feedback errinstansi"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="noseri<?= $no ?>" class="form-label">Nomor seri
                                                        barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan No Seri" id="noseri<?= $no ?>" name="no_seri[]">
                                                        <div class="invalid-feedback errnoseri"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="nodokumen<?= $no ?>" class="form-label">Nomor
                                                        Dokumen</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                                        <input type="text" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan No Dokumen" id="nodokumen<?= $no ?>" name="no_dokumen[]">
                                                        <div class="invalid-feedback errnodokumen"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="hargabeli<?= $no ?>" class="form-label">Harga Beli
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan Harga Beli" id="hargabeli<?= $no ?>" name="harga_beli[]">
                                                        <div class="invalid-feedback errhargabeli<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="hargajual<?= $no ?>" class="form-label">Harga Jual
                                                        Barang</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">Rp</span>
                                                        <input type="number" class="form-control inputrow-<?= $no ?>" placeholder="Masukkan Harga Jual" id="hargajual<?= $no ?>" name="harga_jual[]">
                                                        <div class="invalid-feedback errhargajual<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2 mb-1">
                                                <div class="col-md-6">
                                                    <label for="tglbeli<?= $no ?>" class="form-label">Tanggal
                                                        Pembelian</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                                                        <input type="date" class="form-control inputrow-<?= $no ?>" placeholder="dd/mm/yyyy" id="tglbeli<?= $no ?>" name="tgl_pembelian[]">
                                                        <div class="invalid-feedback errtglbeli<?= $no ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="lokasi<?= $no ?>">Lokasi Penempatan
                                                        <?= $title ?></label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-geo-alt"></i></span>
                                                        <select class="form-select selectrow-<?= $no ?>" id="lokasi<?= $no ?>" name="ruang_id[]">
                                                            <option value="54">Sarana dan Prasarana</option>
                                                        </select>
                                                        <div class="invalid-feedback errlokasi"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="col-12">
                                                <div class="row g-2 mb-1">
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="jmlmasuk<?= $no ?>" class="mb-1">Jumlah Barang Masuk</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-box-seam"></i></span>
                                                            <input type="number" min="1" class="form-control inputrow-${index}" id="jmlmasuk<?= $no ?>" placeholder="Masukkan Jumlah Barang Masuk" name="jumlah_masuk[]">
                                                            <div class="invalid-feedback errjmlmasuk<?= $no ?>"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" for="satuan<?= $no ?>" class="mb-1">Satuan <?= $title; ?></label>
                                                        <div class="input-group mb-3">
                                                            <select name="satuan_id[]" class="form-select selectrow-<?= $no ?> p-2 " id="satuan<?= $no ?>"></select>
                                                            <div class="invalid-feedback errsatuan<?= $no ?>"></div>
                                                        </div>
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
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6 d-flex justify-content-start">
                        <button type="button" class="btn btn-primary my-4 btn-sm btntambahrow" onClick="formbrg.handleAddRow($('#formsimpanmultiple'), $('.table-body tr').length+1)">
                            <i class="fa fa-plus"></i> Tambah Form
                        </button>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <button type="button" class="btn btn-white my-4" onclick="formbrg.closeBtnMultiple()">&laquo; Kembali</button>
                        <button type="submit" class="btn btn-success my-4 btnsimpan">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var kdbrgother = '';
    kodebrgSet = new Set();
    var newkode = '';

    $(document).ready(function() {
        var formId = $('#formsimpanmultiple');
        var rowCount = $('.table-body tr').length;
        formbrg.looping(formId, rowCount);
    });
</script>