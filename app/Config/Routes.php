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
$routes->get('logout', 'Auth::logout');
// $routes->get('public/detail-barang/(:segment)', 'BarangController::detailbarang/$1');
$routes->get('public/detail-barang/(:segment)', 'StokbarangController::detailbarang/$1');

$routes->group('admin', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
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
    // $routes->post('ceknamaruang', 'RuangController::ceknamaruang');
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

$routes->group('admin/barang-tetap', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'BarangController::indexbarangtetap');
    $routes->get('listdatabarang', 'BarangController::listdatabarang');
    $routes->match(['get', 'post'], 'pilihkategori', 'BarangController::pilihkategori');
    $routes->post('simpan', 'BarangController::simpandata');
    $routes->post('update/(:any)', 'BarangController::updatedata/$1');
    $routes->post('hapus/(:any)', 'BarangController::hapusdata/$1');
    $routes->get('tampildatarestore', 'BarangController::listdatabarang');
    $routes->post('restore/(:any)', 'BarangController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'BarangController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'BarangController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'BarangController::hapuspermanen');
    // $routes->get('detail-barang/(:any)', 'BarangController::detailbarang/$1');
});

$routes->group('admin/barang-persediaan', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'BarangController::indexbarangpersediaan');
    $routes->get('listdatabarang', 'BarangController::listdatabarang');
    $routes->match(['get', 'post'], 'pilihkategori', 'BarangController::pilihkategori');
    $routes->post('simpan', 'BarangController::simpandata');
    $routes->post('update/(:any)', 'BarangController::updatedata/$1');
    $routes->post('hapus/(:any)', 'BarangController::hapusdata/$1');
    $routes->get('tampildatarestore', 'BarangController::listdatabarang');
    $routes->post('restore/(:any)', 'BarangController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'BarangController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'BarangController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'BarangController::hapuspermanen');
});

$routes->group('admin/barang-tetap-masuk', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'StokbarangController::indexbarangtetapmasuk');
    $routes->get('listdatastokbarang', 'StokbarangController::listdatastokbarang');
    $routes->match(['get', 'post'], 'pilihkategori', 'StokbarangController::pilihkategori');
    $routes->match(['get', 'post'], 'pilihbarang', 'StokbarangController::pilihbarang');
    $routes->post('simpan', 'StokbarangController::simpandata');
    $routes->post('update/(:any)', 'StokbarangController::updatedata/$1');
    $routes->post('hapus/(:any)', 'StokbarangController::hapusdata/$1');
    $routes->get('tampildatarestore', 'StokbarangController::listdatabarang');
    $routes->post('restore/(:any)', 'StokbarangController::restoredata/$1');
    $routes->match(['get', 'post'], 'restore', 'StokbarangController::restoredata');
    $routes->post('hapuspermanen/(:any)', 'StokbarangController::hapuspermanen/$1');
    $routes->match(['get', 'post'], 'hapuspermanen', 'StokbarangController::hapuspermanen');
    $routes->get('detail-barang/(:any)', 'StokbarangController::detailbarang/$1');
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
