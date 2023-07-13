<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->group('', ['filter' => 'login'], function ($routes) {
// });
$routes->get('auth', 'Auth::index');
$routes->get('auth/login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('detail-barang/(:segment)', 'BarangController::detailbarang/$1');
$routes->get('laporan-kerusakan-aset/(:segment)', 'PelaporanController::tampilpelaporanaset/$1');
$routes->post('laporan-kerusakan-aset/simpan-laporan', 'PelaporanController::simpanlaporan');
$routes->get('laporan-kerusakan-aset/edit-laporan/(:segment)', 'PelaporanController::tampileditlaporan/$1');
$routes->post('laporan-kerusakan-aset/update-laporan/(:segment)', 'PelaporanController::updatelaporan/$1');

$routes->group('laporan-kerusakan-aset/pelaporan', function ($routes) {
    $routes->post('simpan-laporan', 'PelaporanController::simpanlaporan');
    $routes->post('update-laporan/(:segment)', 'PelaporanController::updatelaporan/$1');
    $routes->get('pilihanggota', 'PelaporanController::pilihanggota');
    $routes->get('pilihpelapor', 'PermintaanController::pilihanggota');
    $routes->post('cekanggota', 'PelaporanController::cekanggota');
    $routes->get('pilihunit', 'PermintaanController::pilihunit');
});

$routes->group('admin/dashboard', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('getcountbrgkeluar', 'DashboardController::getcountbrgkeluar');
    $routes->get('getcountgedung', 'DashboardController::getcountgedung');
    $routes->get('getcountruang', 'DashboardController::getcountruang');
    $routes->get('getcountbrg', 'DashboardController::getcountbrg');
});

$routes->group('admin/ruang', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'RuangController::index');
    $routes->get('getruangbyid', 'RuangController::getruangbyid');
    $routes->get('tampildataruang', 'RuangController::listdataruang');
    $routes->get('tampildatarestore', 'RuangController::listdataruang');
    $routes->post('simpan', 'RuangController::simpandata');
    $routes->post('update/(:any)', 'RuangController::updatedata/$1');
    $routes->post('hapus/(:any)', 'RuangController::hapusdata/$1');
    $routes->post('restore/(:any)', 'RuangController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'RuangController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'RuangController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'RuangController::hapuspermanen');
});
$routes->group('admin/gedung', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'GedungController::index');
    $routes->get('listdatagedung', 'GedungController::listdatagedung');
    $routes->get('getgedungbyid', 'GedungController::getgedungbyid');
    $routes->post('simpan', 'GedungController::simpandata');
    $routes->match(['get', 'post'], 'pilihkategori', 'GedungController::pilihkategori');
    $routes->post('update/(:any)', 'GedungController::updatedata/$1');
    $routes->post('hapus/(:any)', 'GedungController::hapusdata/$1');
});

$routes->group('admin/kategori-tetap', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'KategoriController::indexkategoritetap');
    $routes->get('listdatakategori', 'KategoriController::listdatakategori');
    $routes->post('getnamakategori', 'KategoriController::getnamakategori');
    $routes->post('simpan', 'KategoriController::simpandata');
    $routes->post('update/(:any)', 'KategoriController::updatedata/$1');
    $routes->post('hapus/(:any)', 'KategoriController::hapusdata/$1');
    $routes->get('tampildatarestore', 'KategoriController::listdatakategori');
    $routes->post('restore/(:any)', 'KategoriController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'KategoriController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'KategoriController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'KategoriController::hapuspermanen');

    $routes->post('getkategoribyid', 'KategoriController::getkategoribyid');
    $routes->post('getsubkode1', 'KategoriController::getsubkode1');
    $routes->post('getsubkode2', 'KategoriController::getsubkode2');
    $routes->post('getsubkode3', 'KategoriController::getsubkode3');
    $routes->post('getsubkode4', 'KategoriController::getsubkode4');
});

$routes->group('admin/kategori-persediaan', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'KategoriController::indexkategoripersediaan');
    $routes->get('listdatakategori', 'KategoriController::listdataKategori');
    $routes->post('getnamakategori', 'KategoriController::getnamakategori');
    $routes->post('simpan', 'KategoriController::simpandata');
    $routes->post('update/(:any)', 'KategoriController::updatedata/$1');
    $routes->post('hapus/(:any)', 'KategoriController::hapusdata/$1');
    $routes->get('tampildatarestore', 'KategoriController::listdatakategori');
    $routes->post('restore/(:any)', 'KategoriController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'KategoriController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'KategoriController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'KategoriController::hapuspermanen');

    $routes->post('getkategoribyid', 'KategoriController::getkategoribyid');
    $routes->post('getsubkode1', 'KategoriController::getsubkode1');
    $routes->post('getsubkode2', 'KategoriController::getsubkode2');
});

$routes->group('admin/barang-tetap-masuk', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'BarangController::indexbarangtetap');
    $routes->get('listdatabarang', 'BarangController::listdatabarang');
    $routes->match(['get', 'post'], 'pilihkategori', 'BarangController::pilihkategori');
    $routes->match(['get', 'post'], 'pilihbarang', 'BarangController::pilihbarang');
    $routes->post('simpanbarang', 'BarangController::simpandatabarang');
    $routes->post('updatestok/(:any)', 'BarangController::updatedatastok/$1');
    $routes->post('insertmultiple', 'BarangController::insertmultiplebarang');
    $routes->post('transferbarang', 'BarangController::transfermultiplebarang');
    $routes->post('updatebarang/(:any)', 'BarangController::updatedatabarang/$1');
    $routes->post('hapus/(:any)', 'BarangController::hapusdata/$1');
    $routes->get('tampildatarestore', 'BarangController::listdatabarang');
    $routes->post('restore/(:any)', 'BarangController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'BarangController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'BarangController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'BarangController::hapuspermanen');
    $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');
    $routes->post('multipledelete', 'BarangController::multipledeletetemporary');

    $routes->post('tampillabelbarang', 'BarangController::tampillabelbarang');
    $routes->post('tampiltransferform', 'BarangController::tampiltransferform');
    $routes->post('tampileditform', 'BarangController::tampileditform');
    $routes->post('tampiltambahbarangmultiple', 'BarangController::tampiltambahbarangmultiple');
    $routes->post('tampiltambahstokmultiple', 'BarangController::tampiltambahstokmultiple');
    $routes->post('tampilcardupload', 'BarangController::tampilcardupload');
    $routes->post('simpanupload', 'BarangController::simpanupload');

    $routes->get('getdatastokbarangbyid', 'BarangController::getdatastokbarangbyid');
    $routes->get('pilihbarang', 'BarangController::pilihbarang');
    $routes->get('pilihsatuan', 'BarangController::pilihsatuan');
    $routes->get('pilihlokasi', 'BarangController::pilihlokasi');
    $routes->post('cekbrgdanruang', 'BarangController::cekbrgdanruang');
    $routes->get('pilihwarna', 'BarangController::pilihwarna');
    $routes->get('getkdbrgbykdkat', 'BarangController::getkdbrgbykdkat');
    $routes->post('getbarangbyany', 'BarangController::getbarangbyany');
    $routes->post('getsubkdbarang', 'BarangController::getsubkdbarang');
    $routes->post('updatedatastokmultiple', 'BarangController::updatedatastokmultiple');
    // $routes->post('simpanstok', 'BarangController::simpanstok');
});

$routes->group('admin/barang-persediaan-masuk', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'BarangController::indexbarangpersediaan');
    $routes->get('listdatabarang', 'BarangController::listdatabarang');
    $routes->match(['get', 'post'], 'pilihkategori', 'BarangController::pilihkategori');
    $routes->match(['get', 'post'], 'pilihbarang', 'BarangController::pilihbarang');
    $routes->post('simpanbarang', 'BarangController::simpandatabarang');
    $routes->post('updatestok/(:any)', 'BarangController::updatedatastok/$1');
    $routes->post('insertmultiple', 'BarangController::insertmultiplebarang');
    $routes->post('transferbarang', 'BarangController::transfermultiplebarang');
    $routes->post('updatebarang/(:any)', 'BarangController::updatedatabarang/$1');
    $routes->post('hapus/(:any)', 'BarangController::hapusdata/$1');
    $routes->get('tampildatarestore', 'PengalokasianController::listdataalokasi');
    $routes->post('restore/(:any)', 'BarangController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'BarangController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'BarangController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'BarangController::hapuspermanen');
    $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');
    $routes->post('multipledelete', 'BarangController::multipledeletetemporary');

    $routes->post('tampillabelbarang', 'BarangController::tampillabelbarang');
    $routes->post('tampiltransferform', 'BarangController::tampiltransferform');
    $routes->post('tampileditform', 'BarangController::tampileditform');
    $routes->post('tampiltambahbarangmultiple', 'BarangController::tampiltambahbarangmultiple');
    $routes->post('tampiltambahstokmultiple', 'BarangController::tampiltambahstokmultiple');
    $routes->post('tampilcardupload', 'BarangController::tampilcardupload');
    $routes->post('simpanupload', 'BarangController::simpanupload');

    $routes->get('getdatastokbarangbyid', 'BarangController::getdatastokbarangbyid');
    $routes->get('pilihbarang', 'BarangController::pilihbarang');
    $routes->get('pilihsatuan', 'BarangController::pilihsatuan');
    $routes->get('pilihlokasi', 'BarangController::pilihlokasi');
    $routes->post('cekbrgdanruang', 'BarangController::cekbrgdanruang');
    $routes->get('pilihwarna', 'BarangController::pilihwarna');
    $routes->get('getkdbrgbykdkat', 'BarangController::getkdbrgbykdkat');
    $routes->post('getbarangbyany', 'BarangController::getbarangbyany');
    $routes->post('getsubkdbarang', 'BarangController::getsubkdbarang');
    $routes->post('updatedatastokmultiple', 'BarangController::updatedatastokmultiple');
    // $routes->post('simpanstok', 'BarangController::simpanstok');
});

$routes->group('admin/alokasi-barang-tetap', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PengalokasianController::index');
    $routes->get('listdataalokasi', 'PengalokasianController::listdataalokasi');
    $routes->match(['get', 'post'], 'pilihkategori', 'PengalokasianController::pilihkategori');
    $routes->match(['get', 'post'], 'pilihbarang', 'PengalokasianController::pilihbarang');
    $routes->match(['get', 'post'], 'pilihlokasi', 'PengalokasianController::pilihlokasi');
    $routes->post('hapus/(:any)', 'PengalokasianController::hapusdata/$1');
    $routes->post('transferbarang', 'BarangController::transfermultiplebarang');
    $routes->get('tampildatarestore', 'BarangController::listdatabarang');
    $routes->post('restore/(:any)', 'PengalokasianController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'PengalokasianController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'PengalokasianController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'PengalokasianController::hapuspermanen');
    $routes->post('multipledelete', 'PengalokasianController::multipledeletetemporary');
    $routes->post('tampillabelbarang', 'BarangController::tampillabelbarang');
    $routes->post('tampiltransferform', 'PengalokasianController::tampiltransferform');
    $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');

    $routes->get('getdatastokbarangbyid', 'BarangController::getdatastokbarangbyid');
    $routes->get('pilihbarang', 'BarangController::pilihbarang');
    $routes->get('pilihsatuan', 'BarangController::pilihsatuan');
    $routes->get('pilihlokasi', 'BarangController::pilihlokasi');
});

$routes->group('admin/permintaan-barang-persediaan', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PermintaanController::index');
    $routes->get('listdatapermintaan', 'PermintaanController::listdatapermintaan');
    $routes->post('simpan', 'PermintaanController::simpandata');
    $routes->post('update/(:any)', 'PermintaanController::updatedata/$1');
    $routes->post('hapus/(:any)', 'PermintaanController::hapusdata/$1');
    $routes->post('multipledelete', 'PermintaanController::multipledeletetemporary');
    $routes->post('restore/(:any)', 'PermintaanController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'PermintaanController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'PermintaanController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'PermintaanController::hapuspermanen');

    $routes->post('tampilmodalcetak', 'PermintaanController::tampilmodalcetak');
    $routes->get('tampilsingleform', 'PermintaanController::tampilsingleform');
    $routes->get('pilihanggota', 'PermintaanController::carianggota');
    $routes->get('getpermintaanbyid', 'PermintaanController::getpermintaanbyid');
    $routes->get('pilihunit', 'PermintaanController::pilihunit');
    $routes->get('pilihbarang', 'BarangController::pilihbarang');
    $routes->get('pilihsatuan', 'BarangController::pilihsatuan');
    $routes->post('cekbrgdanruang', 'BarangController::cekbrgdanruang');

    $routes->post('cetak', 'LaporanController::cetaklaporanpdf');
});

$routes->group('admin/peminjaman-barang-tetap', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PeminjamanController::index');
    $routes->get('listdatapeminjaman', 'PeminjamanController::listdatapeminjaman');
    $routes->post('simpan', 'PeminjamanController::simpandata');
    $routes->post('pengembalian', 'PeminjamanController::simpandatapengembalian');
    $routes->post('update/(:any)', 'PeminjamanController::updatedata/$1');
    $routes->post('hapus/(:any)', 'PeminjamanController::hapusdata/$1');
    $routes->post('multipledelete', 'PeminjamanController::multipledeletetemporary');
    $routes->post('restore/(:any)', 'PeminjamanController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'PeminjamanController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'PeminjamanController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'PeminjamanController::hapuspermanen');
    $routes->post('cetak', 'LaporanController::cetaklaporanpdf');

    $routes->get('tampilformkembali', 'PeminjamanController::tampilformkembali');
    $routes->post('tampilmodalcetak', 'PeminjamanController::tampilmodalcetak');
    $routes->get('tampilsingleform', 'PeminjamanController::tampilsingleform');
    $routes->get('pilihanggota', 'PermintaanController::carianggota');
    $routes->get('getpeminjamanbyid', 'PeminjamanController::getpeminjamanbyid');
    $routes->get('pilihunit', 'PermintaanController::pilihunit');
    $routes->get('pilihbarang', 'BarangController::pilihbarang');
    $routes->get('pilihsatuan', 'BarangController::pilihsatuan');
    $routes->post('cekbrgdanruang', 'BarangController::cekbrgdanruang');

    $routes->post('updatedatakembali', 'PeminjamanController::updatedatakembali');
    $routes->get('getdatapeminjaman', 'PeminjamanController::getdatapeminjaman');
    $routes->get('pilihpeminjam', 'PeminjamanController::pilihanggota');
    // $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');
});

$routes->group('admin/laporan', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'LaporanController::index');
    $routes->get('getdatalokasibrg', 'LaporanController::getdatalokasibrg');
    $routes->get('getdatatablepermintaan', 'LaporanController::getdatatablepermintaan');
    $routes->get('getdatachartpermintaan', 'LaporanController::getdatachartpermintaan');
    $routes->get('getcountbrgkeluar', 'LaporanController::getcountbrgkeluar');
    $routes->get('getcountbrg', 'LaporanController::getcountbrg');
    $routes->post('cetak', 'LaporanController::cetaklaporanpdf');
});

$routes->group('admin/anggota', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'AnggotaController::index');
    $routes->get('listdataanggota', 'AnggotaController::listdataanggota');
    $routes->get('listdataunit', 'AnggotaController::listdataunit');
    $routes->post('simpanunit', 'AnggotaController::simpandataunit');
    $routes->post('updateunit/(:any)', 'AnggotaController::updatedataunit/$1');
    $routes->post('hapusunit/(:any)', 'AnggotaController::hapusdataunit/$1');
    $routes->match(['get', 'post'], 'restoreunit', 'AnggotaController::restoredataunit');
    $routes->post('simpananggota', 'AnggotaController::simpandataanggota');
    $routes->post('updateanggota/(:any)', 'AnggotaController::updatedataanggota/$1');
    $routes->post('hapusanggota/(:any)', 'AnggotaController::hapusdataanggota/$1');
    $routes->match(['get', 'post'], 'restoreanggota', 'AnggotaController::restoredataanggota');
    $routes->post('multipledeleteunit', 'AnggotaController::multipledeleteunittemporary');
    $routes->post('multipledeleteanggota', 'AnggotaController::multipledeleteanggotatemporary');
    $routes->post('hapuspermanenunit/(:any)', 'AnggotaController::hapuspermanenunit/$1');
    $routes->match(['get', 'post'], 'hapuspermanenunit', 'AnggotaController::hapuspermanenunit');
    $routes->post('hapuspermanenanggota/(:any)', 'AnggotaController::hapuspermanenanggota/$1');
    $routes->match(['get', 'post'], 'hapuspermanenanggota', 'AnggotaController::hapuspermanenanggota');

    $routes->get('singleformunit', 'AnggotaController::singleformunit');
    $routes->get('singleformanggota', 'AnggotaController::singleformanggota');
    $routes->get('getkategoriunit', 'AnggotaController::getkategoriunit');
    $routes->post('getdataunitbyid', 'AnggotaController::getdataunitbyid');
    $routes->post('getdataanggotabyid', 'AnggotaController::getdataanggotabyid');
    $routes->get('pilihunit', 'PermintaanController::pilihunit');
});

$routes->group('admin/pengguna', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PenggunaController::index');
    $routes->get('listdatapengguna', 'PenggunaController::listdatapengguna');
    $routes->post('simpan', 'PenggunaController::simpandata');
    $routes->post('update/(:any)', 'PenggunaController::updatedata/$1');
    $routes->post('hapus/(:any)', 'PenggunaController::hapusdata/$1');
    $routes->post('getpenggunabyid', 'PenggunaController::getpenggunabyid');
});

$routes->group('admin/profile', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'ProfileController::index');
    $routes->post('ubahpassword', 'ProfileController::ubahpassword');
    $routes->post('gantifoto', 'ProfileController::gantifoto');
    $routes->post('getfotobyusername', 'ProfileController::getfotobyusername');
    $routes->post('tampilformeditprofil', 'ProfileController::tampilformeditprofil');
    $routes->get('getprofilebynip', 'ProfileController::getprofilebynip');
    $routes->post('updatedata/(:any)', 'ProfileController::updatedata/$1');
});

$routes->group('admin/notification', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PelaporanController::index');
    $routes->match(['get', 'post'], '/detail/(:any)', 'PelaporanController::tampildetailpelaporan/$1');
    $routes->post('multipledelete', 'PelaporanController::multipledeletetemporary');
    $routes->post('restoredata', 'PelaporanController::restoredata');
    $routes->post('multipledeletepermanen', 'PelaporanController::multipledeletepermanen');
    $routes->post('getnotifikasipelaporan', 'PelaporanController::getnotifikasipelaporan');
    $routes->post('notifikasipersediaan', 'BarangController::notifikasipersediaan');

    $routes->get('tampilcardpelaporan', 'PelaporanController::tampilcardpelaporan');
    $routes->get('tampildetailpelaporan/(:any)', 'PelaporanController::tampildetailpelaporan/$1');
    $routes->post('getLaporanByNoLaporan', 'PelaporanController::getLaporanByNoLaporan');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
