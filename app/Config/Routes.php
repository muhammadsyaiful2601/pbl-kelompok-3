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
// Rute Profil Pengguna
$routes->get('profile', 'Profile::index');
$routes->post('profile/update', 'Profile::update');

// Rute Admin Dashboard dan Fitur Terkait
$routes->get('admin/dashboard', 'Admin\Dashboard::index');
$routes->get('admin/profile', 'Profile::index');
$routes->post('admin/profile/update', 'Profile::update');
$routes->get('admin/sekolah', 'Admin\Sekolah::index');
$routes->get('admin/sekolah/tambah', 'Admin\Sekolah::tambah');
$routes->get('admin/input-data', 'Admin\Sekolah::inputData');
$routes->get('admin/sekolah/edit/(:num)', 'Admin\Sekolah::edit/$1');
$routes->post('admin/sekolah/simpan', 'Admin\Sekolah::simpan');
$routes->post('admin/input-data/store', 'Admin\Sekolah::simpan');
$routes->get('admin/sekolah/hapus/(:num)', 'Admin\Sekolah::hapus/$1');

// Rute Superadmin
$routes->group('superadmin', function ($routes) {
    $routes->get('dashboard', 'Superadmin\Dashboard::index');
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('admin', 'Superadmin\Admin::index');
    $routes->get('admin/tambah', 'Superadmin\Admin::tambah');
    $routes->post('admin/simpan', 'Superadmin\Admin::simpan');
    $routes->get('admin/hapus/(:num)', 'Superadmin\Admin::hapus/$1');

    $routes->get('geojson', 'Superadmin\Geojson::index');
    $routes->get('geojson/scan', 'Superadmin\Geojson::scan');
    $routes->get('geojson/clean', 'Superadmin\Geojson::clean');
    $routes->get('geojson/edit/(:num)', 'Superadmin\Geojson::edit/$1');
    $routes->post('geojson/update/(:num)', 'Superadmin\Geojson::update/$1');
    $routes->get('geojson/toggle/(:num)', 'Superadmin\Geojson::toggle/$1');
    $routes->get('geojson/hapus/(:num)', 'Superadmin\Geojson::hapus/$1');
});
