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

// Form berlangganan info promo (pengunjung)
$routes->post('berlangganan', 'Home::berlangganan');
