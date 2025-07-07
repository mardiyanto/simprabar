<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth::login'); 
$routes->get('login', 'Auth::login');
$routes->get('login/logout', 'Auth::logout');
$routes->post('login/doLogin', 'Auth::doLogin');

//admin
$routes->get('dashboard/admin', 'Dashboard::admin');
$routes->get('dashboard/ruangan', 'Dashboard::ruangan');
$routes->get('dashboard/it', 'Dashboard::it'); 
//user

$routes->get('user', 'User::index');
// $routes->get('user/index', 'User::index');

$routes->post('dashboard/user/store', 'User::store');
$routes->get('dashboard/user/edit/(:num)', 'User::edit/$1');
$routes->post('dashboard/user/update/(:num)', 'User::update/$1');
$routes->get('dashboard/user/delete/(:num)', 'User::delete/$1');

$routes->get('ruangan', 'Ruangan::index');
$routes->post('ruangan/store', 'Ruangan::store');
$routes->get('ruangan/edit/(:num)', 'Ruangan::edit/$1');
$routes->post('ruangan/update/(:num)', 'Ruangan::update/$1');
$routes->get('ruangan/delete/(:num)', 'Ruangan::delete/$1');

$routes->get('barang', 'Barang::index');
$routes->post('barang/store', 'Barang::store');
$routes->post('barang/storeBulk', 'Barang::storeBulk');
$routes->get('barang/edit/(:num)', 'Barang::edit/$1');
$routes->post('barang/update/(:num)', 'Barang::update/$1');
$routes->get('barang/delete/(:num)', 'Barang::delete/$1');

$routes->get('tiket', 'Tiket::index');
$routes->post('tiket/store', 'Tiket::store');
$routes->get('tiket/edit/(:num)', 'Tiket::edit/$1');
$routes->post('tiket/update/(:num)', 'Tiket::update/$1');
$routes->get('tiket/detail/(:num)', 'Tiket::detail/$1');
$routes->get('tiket/exportExcel', 'Tiket::exportExcel');
$routes->get('tiket/exportPdf', 'Tiket::exportPdf');
$routes->get('tiket/delete/(:num)', 'Tiket::delete/$1');
$routes->get('tiket/editData/(:num)', 'Tiket::editData/$1');
$routes->post('tiket/updateData/(:num)', 'Tiket::updateData/$1');
$routes->get('tiket/getBarangByRuangan/(:num)', 'Tiket::getBarangByRuangan/$1');

$routes->get('laporan', 'Laporan::index');
$routes->get('laporan/exportExcel', 'Laporan::exportExcel');
$routes->get('laporan/exportPdf', 'Laporan::exportPdf');

$routes->get('profile', 'Profile::index');
$routes->post('profile/update', 'Profile::update');
