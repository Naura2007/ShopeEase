<?php

use App\Controllers\Admin\CategoryController;
use App\Controllers\Admin\ProductController;
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

// Dashboard admin (hanya admin)
$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
});

// Product & Category Management (admin dan operator)
$routes->group('admin', ['filter' => 'auth:admin,operator'], static function ($routes) {
    // Produk
    $routes->get('products', [ProductController::class, 'index']);
    $routes->get('products/create', [ProductController::class, 'create']);
    $routes->post('products/store', [ProductController::class, 'store']);
    $routes->get('products/edit/(:num)', [ProductController::class, 'edit']);
    $routes->post('products/update/(:num)', [ProductController::class, 'update']);
    $routes->post('products/delete/(:num)', [ProductController::class, 'delete']);
    $routes->post('products/image/delete/(:num)', [ProductController::class, 'deleteImage']);
    $routes->post('products/image/primary/(:num)', [ProductController::class, 'setPrimary']);

    // Kategori
    $routes->get('categories', [CategoryController::class, 'index']);
    $routes->get('categories/create', [CategoryController::class, 'create']);
    $routes->post('categories/store', [CategoryController::class, 'store']);
    $routes->get('categories/edit/(:num)', [CategoryController::class, 'edit']);
    $routes->post('categories/update/(:num)', [CategoryController::class, 'update']);
    $routes->post('categories/delete/(:num)', [CategoryController::class, 'delete']);
});

// Dashboard operator (hanya operator)
$routes->group('operator', ['filter' => 'auth:operator'], static function ($routes) {
    $routes->get('/', 'Operator\DashboardController::index');
});
