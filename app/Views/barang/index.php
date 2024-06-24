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
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-8 order-md-1 order-last">
                <h3>Daftar <?= $title; ?></h3>
                <p class="text-subtitle text-muted">Kelola menu <?= strtolower($title) ?> di Universitas Islam Raden
                    Rahmat Malang</p>
            </div>
            <div class="col-12 col-md-4 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="fa fa-home"></i></a></li>
                        <?php foreach ($breadcrumb as $crumb) : ?>
                        <?php if (end($breadcrumb) == $crumb) : ?>
                        <li class="breadcrumb-item"><?= $crumb['name'] ?></li>
                        <?php else : ?>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#"><?= $crumb['name'] ?></a>
                        </li>
                        <?php endif ?>
                        <?php endforeach ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="col-12 col-md-12 bg-dark viewdata" style="display:none;"></div>
    <div class="card shadow mb-3 text-white bg-dark shadow">
        <div class="card-header text-white bg-dark shadow-sm">
            <h4 class="card-title">Custom Filter</h4>
        </div>
        <div class=" card-body">
            <div class="row mt-3">
                <div class="col-sm-6 d-flex justify-content-start">
                    <label class="col-sm-4 col-form-label" for="selectbarang">Barang</label>
                    <div class="col-sm-8">
                        <select id="selectbarang" class="form-select"></select>
                    </div>
                </div>
                <div class="col-sm-6 d-flex justify-content-start">
                    <label class="col-sm-4 col-form-label" for="selectkategori">Kategori</label>
                    <div class="col-sm-8">
                        <select id="selectkategori" class="form-select"></select>
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
                            <button type="button" class="btn btn-primary" id="btn-restore"><i class="fa fa-recycle"></i>
                                Recycle Bin</button>
                        </div>
                    </div>
                    <div class="col-md-auto btn-datarestorebarang" style="display:none;">
                        <button class="btn btn-success" onclick="restoreall()"><i class="fa fa-undo"></i> Pulihkan
                            semua</button>
                        <button class="btn btn-danger" onclick="hapuspermanenall()"><i class="fa fa-trash"></i> Hapus
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
            <form class="formmultipledelete">
                <div class="row m-1">
                    <div class="col-md-6 pb-0 pt-3 px-0 d-flex flex-row justify-content-start">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Input Barang
                            </button>
                            <ul class="dropdown-menu shadow-lg">
                                <li><a class="dropdown-item" onclick="barang.formTambahBaru()"><i
                                            class="fa fa-plus-square-o"></i> Barang Baru</a>
                                </li>
                                <li><a class="dropdown-item" onclick="barang.formTambahStok()"><i class="fa fa-file-text"></i>
                                        Tambah Stok Barang</a>
                                </li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Import Excel
                            </button>
                            <ul class="dropdown-menu shadow-lg">
                                <li><a class="dropdown-item" onclick="barang.tampilExportExcel()"><i
                                            class="fa fa-file-text"></i> Download Template</a>
                                </li>
                                <li><a class="dropdown-item" onclick="barang.tampilImportExcel()"><i class="fa fa-upload"></i>
                                        Upload Excel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 pb-0 pt-3 px-0 d-flex justify-content-end">
                        <button class="btn btn-warning mx-3" onclick="barang.transferBarang()" type="button"><i
                                class="fa fa-exchange"></i> Transfer Barang</button>
                        <button type="submit" class="btn btn-danger btn-multipledelete">
                            <i class="fa fa-trash-o"></i> Multiple Delete
                        </button>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <?php foreach ($tabId as $i=>$row): ?>
                        <li class="nav-item" role="presentation">
                            <a 
                            class="nav-link <?= $row === 'brgtetap'? 'active': '' ?>" 
                            id="<?= $row ?>-tab" 
                            data-bs-toggle="tab" 
                            href="#<?= $row ?>" 
                            role="tab"
                                aria-controls="<?= $row ?>" aria-selected="true"><?= $tabName[$i] ?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <?php foreach($tabId as $i=>$row): ?>
                        <div class="tab-pane fade <?= $row === 'brgtetap'? 'show active':'' ?>" id="<?= $row ?>" role="tabpanel"
                            aria-labelledby="<?= $row ?>-tab">
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
let jenistrx = '<?= strtolower($title) ?>';
let tableBrgTetap, tableBrgPersediaan, tableAlokasiBrg, datarestore;
// deklarasi variabel untuk menyimpan data lokasi
var lokasiSarprasCache = null;
let kd_brg = null;
let katid = null;
const tabId = <?= json_encode($tabId) ?>;
const checkall = <?= json_encode($checkall) ?>;

$(document).ready(function() {
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
    tableBrgTetap = barang.listDataBarang('table-brgtetap',
        '<?= $nav ?>/listdatabarang?jenis_kat=Barang%20Tetap&isRestore=0');
    tableAlokasiBrg = barang.listDataBarang('table-alokasibrg',
        '<?= $nav ?>/listdatabarang?jenis_kat=Barang%20Tetap&isRestore=0&hal=Alokasibrg');
    tableBrgPersediaan = barang.listDataBarang('table-brgpersediaan',
        '<?= $nav ?>/listdatabarang?jenis_kat=Barang%20Persediaan&isRestore=0');

    util.filteringData('Barang Tetap');

    // Event handler for tab clicks
    $('.nav-link').on('click', function() {
        // Hide all tab content
        $('.tab-pane').removeClass('show active');

        // Show the corresponding tab content based on the clicked tab
        var targetTab = $(this).attr('href');
        $(targetTab).addClass('show active');
        // Redraw the DataTable for the current tab to load the data from the server
        util.checkrowDef(tabId);
        if (targetTab === '#brgtetap') {
            tableBrgTetap.ajax.reload();
            util.filteringData('Barang Tetap');
        } else if (targetTab === '#alokasibrg') {
            tableAlokasiBrg.ajax.reload();
            util.filteringData('Barang Tetap');
        } else if (targetTab === '#brgpersediaan') {
            tableBrgPersediaan.ajax.reload();
            util.filteringData('Barang Persediaan');
        }
    });

    $('#selectbarang').on('change', function(e) {
        e.preventDefault();
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
    })
    $('#selectkategori').on('change', function(e) {
        e.preventDefault();
        if (tableBrgTetap) {
            tableBrgTetap.ajax.reload();
        }
        if (tableAlokasiBrg) {
            tableAlokasiBrg.ajax.reload();
        }
        if (tableBrgPersediaan) {
            tableBrgPersediaan.ajax.reload();
        }
        if (datarestore) {
            datarestore.ajax.reload();
        }
    })

    // Call the function for each group of checkboxes
    tabId.forEach((val, i) => {
        util.handleCheckAll(`#${checkall[i]}`, `.checkrow-${val}`);
    });
    
    $('#btn-restore').on('click', function() {
        $('.table-barang').hide();
        $('.table-restore').show();
        $('.datalist-barang h4').html('Restore Data <?= $title; ?>');
        $('.btn-databarang').hide();
        $('.btn-datarestorebarang').show();

        datarestore = barang.listDataBarang('table-restore', '<?= $nav ?>/listdatabarang?isRestore=1');
    });

    //Temporary multiple delete
    $('.formmultipledelete').submit(function(e) {
        e.preventDefault();
        let selectedRows = $('td input[type="checkbox"]:checked');
        var keterangan;
        if (selectedRows.attr('class') == "checkrow-brgpersediaan") {
            keterangan = "Barang Persediaan";
        } else if (selectedRows.attr('class') == "checkrow-brgtetap") {
            keterangan = "Barang Tetap";
        } else if (selectedRows.attr('class') == "checkrow-alokasibrg") {
            keterangan = "Alokasi Barang Tetap";
        }
        var selectedIds = $('td:nth-child(1) input[type="checkbox"]:checked').map(function() {
            return $(this).val();
        }).get();
        var jmldata = selectedIds.length;
        var formdata = new FormData(this);
        formdata.append('jenis_kat', keterangan);

        if (jmldata === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Maaf silahkan pilih data <?= strtolower($title) ?> yang mau dihapus'
            })
        } else {
            Swal.fire({
                title: 'Multiple Delete',
                text: `Apakah kamu yakin ingin menghapus ${jmldata} data ${keterangan.toLowerCase()} secara temporary?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus saja!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: `<?= $nav ?>/multipledelete`,
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                            var response = JSON.parse(result);
                            if (response.sukses) {
                                Swal.fire(
                                    'Berhasil', response.sukses, 'success'
                                ).then((result) => {
                                    tableBrgTetap.ajax.reload();
                                    tableBrgPersediaan.ajax.reload();
                                    tableAlokasiBrg.ajax.reload();
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status, +"\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    });
                } else {
                    Swal.fire(
                        'Gagal', 'Tidak ada data <?= strtolower($title) ?> yang dihapus',
                        'info'
                    )
                }
            });
        }

        return false;
    })
});

function restore(id, ruangId, barangId, namabrg, namaruang) {
    Swal.fire({
        title: `Memulihkan data ${namabrg} di ${namaruang}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= $nav ?>/restore",
                data: {
                    id: id,
                    nama_brg: namabrg,
                    nama_ruang: namaruang,
                    ruangId: ruangId,
                    barangId: barangId,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire(
                            'Berhasil', response.sukses, 'success'
                        ).then((result) => {
                            datarestore.ajax.reload();
                        })
                    } else if (response.error) {
                        Swal.fire(
                            'Gagal!',
                            response.error,
                            'error'
                        );
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    });
}

function restoreall() {
    var api = $('#table-restore').DataTable().rows();
    var id = api.data().toArray().map(function(d) {
        return d.id;
    });
    var ruang_id = api.data().toArray().map(function(d) {
        return d.ruang_id;
    })
    var barang_id = api.data().toArray().map(function(d) {
        return d.barang_id;
    })
    var nama_brg = api.data().toArray().map(function(d) {
        return d.nama_brg;
    })
    var nama_ruang = api.data().toArray().map(function(d) {
        return d.nama_ruang;
    })

    if (api.count() === 0) { // jika tidak ada data
        Swal.fire(
            'Gagal!',
            'Tidak ada data <?= strtolower($title) ?> yang dapat dipulihkan',
            'error'
        );
    } else if (api.count() === 1) {
        Swal.fire({
            title: `Apakah anda ingin memulihkan semua data  <?= strtolower($title) ?> yang telah terhapus?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batalkan',
        }).then((result) => {
            restore(id.toString(), ruang_id.toString(), barang_id.toString(), nama_brg.toString(), nama_ruang
                .toString());
        });
    } else {
        Swal.fire({
            title: `Apakah anda ingin memulihkan semua data  <?= strtolower($title) ?> yang telah terhapus?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batalkan',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= $nav ?>/restore",
                    data: {
                        id: id.join(","),
                        barangId: barang_id.join(","),
                        ruangId: ruang_id.join(","),
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Berhasil', response.sukses, 'success'
                            ).then((result) => {
                                location.reload();
                            })
                        } else if (response.error) {
                            Swal.fire(
                                'Gagal!',
                                response.error,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }
}

</script>
<?= $this->endSection() ?>