<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('maps', 'Home::maps');
$routes->get('fullmaps', 'Home::fullmaps');

// Rute Autentikasi Admin
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
// Rute Admin Dashboard dan Fitur Terkait
$routes->get('admin/dashboard', 'Admin\Dashboard::index');
$routes->get('admin/input-data', 'Admin\InputData::index');
$routes->get('admin/marker-polygon', 'Admin\MarkerPolygon::index');
