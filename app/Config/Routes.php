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
// $routes->get('public/detail-barang/(:segment)', 'BarangController::detailbarang/$1');
$routes->get('detail-barang/(:segment)', 'BarangController::detailbarang/$1');
$routes->get('laporan-kerusakan-aset/(:segment)', 'PelaporanController::index/$1');
$routes->post('laporan-kerusakan-aset/simpan-laporan', 'PelaporanController::simpanlaporan');
$routes->get('laporan-kerusakan-aset/edit-laporan/(:segment)', 'PelaporanController::tampileditlaporan/$1');
$routes->post('laporan-kerusakan-aset/update-laporan/(:segment)', 'PelaporanController::updatelaporan/$1');

$routes->group('admin/dashboard', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'DashboardController::index');
});

$routes->group('admin/ruang', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'RuangController::index');
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
    $routes->post('simpan', 'GedungController::simpandata');
    $routes->match(['get', 'post'], 'pilihkategori', 'GedungController::pilihkategori');
    $routes->post('update/(:any)', 'GedungController::updatedata/$1');
    $routes->post('hapus/(:any)', 'GedungController::hapusdata/$1');
});

$routes->group('admin/kategori-tetap', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'KategoriController::indexkategoritetap');
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
});

$routes->group('admin/permintaan-barang-persediaan', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PermintaanController::index');
    $routes->get('listdatapermintaan', 'PermintaanController::listdatapermintaan');
    $routes->get('listdatapermintaan', 'PermintaananController::listdatapermintaan');
    $routes->post('simpan', 'PermintaanController::simpandata');
    $routes->post('update/(:any)', 'PermintaanController::updatedata/$1');
    $routes->post('hapus/(:any)', 'PermintaanController::hapusdata/$1');
    $routes->post('multipledelete', 'PermintaanController::multipledeletetemporary');
    $routes->post('restore/(:any)', 'PermintaanController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'PermintaanController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'PermintaanController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'PermintaanController::hapuspermanen');
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
    // $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');
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
    $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');
});

$routes->group('admin/laporan', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'LaporanController::index');
    $routes->post('cetak', 'LaporanController::cetaklaporanpdf');
    // $routes->post('simpan', 'LaporanController::simpandata');
    // $routes->post('update/(:any)', 'LaporanController::updatedata/$1');
    // $routes->post('hapus/(:any)', 'laporanController::hapusdata/$1');
});

$routes->group('admin/anggota', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'AnggotaController::index');
    $routes->post('simpanunit', 'AnggotaController::simpandataunit');
    $routes->post('updateunit/(:any)', 'AnggotaController::updatedataunit/$1');
    $routes->post('hapusunit/(:any)', 'AnggotaController::hapusdataunit/$1');
    $routes->match(['get', 'post'], 'restoreunit', 'AnggotaController::restoredataunit');
    $routes->post('simpananggota', 'AnggotaController::simpandataanggota');
    $routes->post('updateanggota/(:any)', 'AnggotaController::updatedataanggota/$1');
    $routes->post('hapusanggota/(:any)', 'AnggotaController::hapusdataanggota/$1');
    $routes->match(['get', 'post'], 'restoreanggota', 'AnggotaController::restoredataanggota');
});

$routes->group('admin/pengguna', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PenggunaController::index');
    $routes->get('listdatapengguna', 'PenggunaController::listdatapengguna');
    $routes->post('simpan', 'PenggunaController::simpandata');
    $routes->post('update/(:any)', 'PenggunaController::updatedata/$1');
    $routes->post('hapus/(:any)', 'PenggunaController::hapusdata/$1');
});

$routes->group('admin/profile', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'ProfileController::index');
    $routes->post('ubahpassword', 'ProfileController::ubahpassword');
    $routes->post('gantifoto', 'ProfileController::gantifoto');
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
