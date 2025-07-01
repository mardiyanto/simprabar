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
$routes->get('barang/edit/(:num)', 'Barang::edit/$1');
$routes->post('barang/update/(:num)', 'Barang::update/$1');
$routes->get('barang/delete/(:num)', 'Barang::delete/$1');
