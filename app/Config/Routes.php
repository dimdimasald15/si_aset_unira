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
$routes->group('admin', ['filter' => 'ceklogin'], function ($routes) {
    // $routes->post('tampildataruang', 'RuangController::tampildataruang');
    $routes->get('dashboard', 'DashboardController::index');
    //data ruang
});

$routes->group('admin/ruang', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'RuangController::index');
    $routes->get('tampildataruang', 'RuangController::listdataruang');
    $routes->post('simpan', 'RuangController::simpandata');
    $routes->post('update/(:any)', 'RuangController::updatedata/$1');
    $routes->post('hapus/(:any)', 'RuangController::hapusdata/$1');
    // $routes->post('ceknamaruang', 'RuangController::ceknamaruang');
});
$routes->group('admin/gedung', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'GedungController::index');
    $routes->get('listdatagedung', 'GedungController::listdatagedung');
    $routes->post('simpan', 'GedungController::simpandata');
    $routes->match(['get', 'post'], 'pilihkategori', 'GedungController::pilihkategori');
    $routes->post('update/(:any)', 'GedungController::updatedata/$1');
    $routes->post('hapus/(:any)', 'GedungController::hapusdata/$1');
    // $routes->post('ceknamaGedung', 'GedungController::ceknamaruang');
});
$routes->group('admin/kategori', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'KategoriController::index');
    $routes->get('listdatakategori', 'KategoriController::listdataKategori');
    $routes->post('getnamakategori', 'KategoriController::getnamakategori');
    $routes->post('simpan', 'KategoriController::simpandata');
    // $routes->match(['get', 'post'], 'pilihkategori', 'KategoriController::pilihkategori');
    $routes->post('update/(:any)', 'KategoriController::updatedata/$1');
    $routes->post('hapus/(:any)', 'KategoriController::hapusdata/$1');
    // $routes->post('ceknamaGedung', 'GedungController::ceknamaruang');
});

$routes->group('admin/pengguna', ['filter' => 'ceklogin'], function ($routes) {
    $routes->get('/', 'PenggunaController::index');
    $routes->get('listdatapengguna', 'PenggunaController::listdatapengguna');
    $routes->post('simpan', 'PenggunaController::simpandata');
    $routes->post('update/(:any)', 'PenggunaController::updatedata/$1');
    $routes->post('hapus/(:any)', 'PenggunaController::hapusdata/$1');
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
