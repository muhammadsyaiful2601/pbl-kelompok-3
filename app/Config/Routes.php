<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('maps', 'Home::maps');
$routes->get('fullmaps', 'Home::fullmaps');
$routes->get('sekolah/(:num)', 'Home::detail/$1');

// Rute Autentikasi Admin
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
// Rute Admin Dashboard dan Fitur Terkait
$routes->get('admin/dashboard', 'Admin\Dashboard::index');
$routes->get('admin/sekolah', 'Admin\Sekolah::index');
$routes->get('admin/sekolah/tambah', 'Admin\Sekolah::tambah');
$routes->get('admin/sekolah/edit/(:num)', 'Admin\Sekolah::edit/$1');
$routes->post('admin/sekolah/simpan', 'Admin\Sekolah::simpan');
$routes->get('admin/sekolah/hapus/(:num)', 'Admin\Sekolah::hapus/$1');
