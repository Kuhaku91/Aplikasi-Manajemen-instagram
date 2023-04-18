<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

    $routes->get('/', 'HomeController::index', ['filter' => 'auth']);

    // Routes Akun
    $routes->group('akun', ['filter' => 'auth'], function($routes){
        $routes->get('/', 'AkunController::index');
        $routes->post('create', 'AkunController::create');
        $routes->put('edit/(:any)', 'AkunController::edit/$1');
        $routes->delete('delete/(:any)', 'AkunController::delete/$1');
    });

    // Routes Pengguna
    $routes->group('pengguna', ['filter' => 'auth'], function($routes) {
        $routes->get('/', 'PenggunaController::index');
        $routes->post('create', 'PenggunaController::create');
        $routes->put('edit/(:any)', 'PenggunaController::edit/$1');
        $routes->delete('delete/(:any)', 'PenggunaController::delete/$1');
    });

    // Routes Produk
    $routes->group('produk', ['filter' => 'auth'],function($routes) {
        $routes->get('/', 'ProdukController::index');
        $routes->post('create', 'ProdukController::create');
        $routes->put('edit/(:any)', 'ProdukController::edit/$1');
        $routes->delete('delete/(:any)', 'ProdukController::delete/$1');
    });
    // Routes Pelanggan
    $routes->group('pelanggan', ['filter' => 'auth'],function($routes) {
        $routes->get('/', 'PelangganController::index');
        $routes->post('create', 'PelangganController::create');
        $routes->put('edit/(:any)', 'PelangganController::edit/$1');
        $routes->delete('delete/(:any)', 'PelangganController::delete/$1');
    });
    // Routes Transaksi Tunai
    $routes->group('transaksi-tunai', ['filter' => 'auth'],function($routes) {
        $routes->get('/', 'TransaksiTunaiController::index');
        $routes->post('create', 'TransaksiTunaiController::create');
        $routes->post('tambah-keranjang', 'TransaksiTunaiController::tambahKeranjang');
        $routes->get('lihat-keranjang', 'TransaksiTunaiController::lihatKeranjang');
        $routes->get('hapus-keranjang/(:any)', 'TransaksiTunaiController::hapusKeranjang/$1');
        $routes->post('cek-subtotal', 'TransaksiTunaiController::cekSubtotal');
    });

    // Routes Laporan Penjualan
    $routes->group('laporan-penjualan', ['filter' => 'auth'],function($routes) {
        $routes->get('/', 'LaporanPenjualanController::index');
        $routes->post('/', 'LaporanPenjualanController::detail');
        $routes->post('cetak', 'LaporanPenjualanController::cetak');
    });
    
    $routes->group('edit-password', ['filter' => 'auth'], function($routes) {
        $routes->get('(:any)', 'AuthController::edit/$1');
        $routes->post('(:any)', 'AuthController::update/$1');
    });

    $routes->group('login', function($routes) {
        $routes->get('/', 'AuthController::index');
        $routes->post('/', 'AuthController::login');
    });

    $routes->get('logout', 'AuthController::logout');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
