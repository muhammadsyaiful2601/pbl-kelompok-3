<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('maps', 'Home::maps');
$routes->get('fullmaps', 'Home::fullmaps');
