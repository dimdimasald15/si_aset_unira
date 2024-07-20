<?= $this->extend('/layouts/template'); ?>
<?= $this->section('styles') ?>
<style>
    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg {
        max-width: 1000px !important;
    }

    .img-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        /* sesuaikan dengan tinggi gambar yang ingin di crop */
        overflow: hidden;
    }

    .img-container img {
        display: block;
        max-width: 100%;
        max-height: 100%;
        margin: auto;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="col-12 col-md-12 bg-dark viewdata shadow bg-dark shadow" style="display:none;"></div>
    <div class="card shadow mb-3 text-white bg-dark shadow">
        <div class="card-header text-white bg-dark shadow-sm">
            <h4 class="card-title">Custom Filter</h4>
        </div>
        <div class=" card-body">
            <div class="row mt-3">
                <div class="col-sm-6 d-flex justify-content-start">
                    <label class="col-sm-4 col-form-label" for="selectbarang">Barang</label>
                    <div class="col-sm-8">
                        <select onChange="barang.selectItem()" id="selectbarang" class="form-select"></select>
                    </div>
                </div>
                <div class="col-sm-6 d-flex justify-content-start">
                    <label class="col-sm-4 col-form-label" for="selectkategori">Kategori</label>
                    <div class="col-sm-8">
                        <select onChange="barang.selectCategory()" id="selectkategori" class="form-select"></select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3 text-white bg-dark shadow datalist-barang">
        <div class="card-header text-white bg-dark shadow-sm">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-7">
                    <h4 class="card-title">Data Barang</h4>
                </div>
                <div class="col-md-5 d-flex flex-row justify-content-end">
                    <div class="col-md-auto d-flex flex-row justify-content-end">
                        <div class="col-md-auto btn-databarang">
                            <button type="button" class="btn btn-primary" onClick="barang.viewTableRestore()"><i class="fa fa-recycle"></i>
                                Recycle Bin</button>
                        </div>
                    </div>
                    <div class="col-md-auto btn-datarestorebarang" style="display:none;">
                        <button class="btn btn-success" onclick="barang.restoreAll()"><i class="fa fa-undo"></i> Pulihkan
                            semua</button>
                        <button class="btn btn-danger" onclick="barang.hapusPermanenAll()"><i class="fa fa-trash"></i> Hapus
                            semua permanen</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-restore" style="display:none;">
            <div class="table-responsive py-4">
                <table class="table table-flush mb-3" id="table-restore" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="checkall4"></th>
                            <th>No.</th>
                            <th>QR Code</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Asal Pembelian</th>
                            <th>Warna</th>
                            <th>Jumlah Keluar</th>
                            <th>Sisa Stok</th>
                            <th>Lokasi</th>
                            <th>Deleted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body table-barang">
            <form class="formmultipledelete" onSubmit="barang.hapusMultiple(this, event)">
                <div class="row m-1">
                    <div class="col-md-6 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                                Input Barang
                            </button>
                            <ul class="dropdown-menu shadow-lg">
                                <li><a class="dropdown-item" onclick="barang.formTambahBaru()"><i class="fa fa-plus-square-o"></i> Barang Baru</a>
                                </li>
                                <li class="dropend dropdown-submenu">
                                    <a class="dropdown-item test" href="#">
                                        <span class="d-flex justify-content-around align-items-center">
                                            <i class="fa fa-file-excel-o"></i>
                                            <span class="flex-grow-1" style="padding-right:3.0rem;padding-left:0.5rem">Barang Baru Via Excel</span>
                                            <i class="bi bi-caret-right-fill" style="font-size: 12px;"></i>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" onclick="barang.tampilExportExcel()"><i class="fa fa-file-text"></i> Download Template</a></li>
                                        <li><a class="dropdown-item" onclick="barang.tampilImportExcel()"><i class="fa fa-upload"></i>
                                                Upload Excel</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" onclick="barang.formTambahStok()"><i class="fa fa-file-text"></i>
                                        Tambah Stok Barang</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 pb-0 pt-3 px-0 d-flex justify-content-end">
                        <button class="btn btn-warning mx-3" onclick="barang.transferBarang()" type="button"><i class="fa fa-exchange"></i> Transfer Barang</button>
                        <button type="submit" class="btn btn-danger btn-multipledelete">
                            <i class="fa fa-trash-o"></i> Multiple Delete
                        </button>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <?php foreach ($tabId as $i => $row) : ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?= $row === 'brgtetap' ? 'active' : '' ?>" onClick="barang.navLink()" id="<?= $row ?>-tab" data-bs-toggle="tab" href="#<?= $row ?>" role="tab" aria-controls="<?= $row ?>" aria-selected="true"><?= $tabName[$i] ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php foreach ($tabId as $i => $row) : ?>
                        <div class="tab-pane fade <?= $row === 'brgtetap' ? 'show active' : '' ?>" id="<?= $row ?>" role="tabpanel" aria-labelledby="<?= $row ?>-tab">
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="table-<?= $row ?>" data-tab-id="<?= $row ?>" width="100%">
                                    <thead class=" thead-light">
                                        <tr>
                                            <th><input type="checkbox" id="<?= $checkall[$i] ?>"></th>
                                            <th>No.</th>
                                            <th>QR Code</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Asal Pembelian</th>
                                            <th>Warna</th>
                                            <th>Jumlah Keluar</th>
                                            <th>Sisa Stok</th>
                                            <th>Lokasi</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
        <div class="row m-2 btn-datarestorebarang" style="display:none;">
            <h6>
                <a href="<?= $nav ?>">&laquo; Kembali ke data <?= strtolower($title) ?></a>
            </h6>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    let saveMethod, globalId;
    let jenistrx = `${title.toLowerCase()}`;
    let tableBrgTetap, tableBrgPersediaan, tableAlokasiBrg;
    // deklarasi variabel untuk menyimpan data lokasi
    var lokasiSarprasCache = null;
    let kd_brg = null;
    let katid = null;
    const tabId = <?= json_encode($tabId) ?>;
    const checkall = <?= json_encode($checkall) ?>;

    $(document).ready(function() {
        $('.dropdown-submenu a.test').on("click", function(e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
        $('#checkall1, #checkall2, #checkall3').prop('checked', false)
        var hrefTab = window.location.hash;

        if (!hrefTab) {
            hrefTab = '#brgtetap';
        }

        $('.nav-link').removeClass('active');
        $('.nav-link[href="' + hrefTab + '"]').addClass('active');

        $('.tab-pane').removeClass('show active');
        $(hrefTab).addClass('show active');

        // Initialize DataTables for each tab content
        tableBrgTetap = barang.listData('table-brgtetap',
            `${nav}/listdatabarang?jenis_kat=Barang%20Tetap&isRestore=0`);
        tableAlokasiBrg = barang.listData('table-alokasibrg',
            `${nav}/listdatabarang?jenis_kat=Barang%20Tetap&isRestore=0&hal=Alokasibrg`);
        tableBrgPersediaan = barang.listData('table-brgpersediaan',
            `${nav}/listdatabarang?jenis_kat=Barang%20Persediaan&isRestore=0`);

        util.filteringData('Barang Tetap');

        // Call the function for each group of checkboxes
        tabId.forEach((val, i) => {
            util.handleCheckAll(`#${checkall[i]}`, `.checkrow-${val}`);
        });
    });
</script>
<?= $this->endSection() ?>