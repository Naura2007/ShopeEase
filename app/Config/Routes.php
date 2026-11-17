<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');

// Landing page ShopEase
$routes->get('/', 'Home::index');
$routes->get('produk', 'Home::produk');
$routes->get('tentang', 'Home::tentang');
$routes->post('berlangganan', 'Home::berlangganan');

// Authentication
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::store');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->post('logout', 'AuthController::logout');

// Halaman terlindungi berdasarkan role
$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
});

$routes->group('operator', ['filter' => 'auth:operator'], static function ($routes) {
    $routes->get('/', 'Operator\DashboardController::index');
});
