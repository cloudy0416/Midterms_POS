<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::login');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

$routes->get('/login', 'AuthController::login');
$routes->post('/login/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/

$routes->get('/products', 'ProductController::index', ['filter' => 'auth']);
$routes->get('/products/create', 'ProductController::create', ['filter' => 'auth']);
$routes->post('/products/store', 'ProductController::store', ['filter' => 'auth']);
$routes->get('/products/edit/(:num)', 'ProductController::edit/$1', ['filter' => 'auth']);
$routes->post('/products/update/(:num)', 'ProductController::update/$1', ['filter' => 'auth']);
$routes->get('/products/delete/(:num)', 'ProductController::delete/$1', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

$routes->get('/customers', 'CustomerController::index', ['filter' => 'auth']);
$routes->get('/customers/create', 'CustomerController::create', ['filter' => 'auth']);
$routes->post('/customers/store', 'CustomerController::store', ['filter' => 'auth']);
$routes->get('/customers/edit/(:num)', 'CustomerController::edit/$1', ['filter' => 'auth']);
$routes->post('/customers/update/(:num)', 'CustomerController::update/$1', ['filter' => 'auth']);
$routes->get('/customers/delete/(:num)', 'CustomerController::delete/$1', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

$routes->get('/users', 'UserController::index', ['filter' => 'auth']);
$routes->get('/users/create', 'UserController::create', ['filter' => 'auth']);
$routes->post('/users/store', 'UserController::store', ['filter' => 'auth']);
$routes->get('/users/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth']);
$routes->post('/users/update/(:num)', 'UserController::update/$1', ['filter' => 'auth']);
$routes->get('/users/delete/(:num)', 'UserController::delete/$1', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| Sales / POS Routes
|--------------------------------------------------------------------------
*/

$routes->get('/sales', 'SaleController::index', ['filter' => 'auth']);
$routes->get('/sales/create', 'SaleController::index', ['filter' => 'auth']);

$routes->post(
    '/sales/checkout',
    'SaleController::checkout',
    ['filter' => 'auth']
);

$routes->get(
    '/sales/history',
    'SaleController::history',
    ['filter' => 'auth']
);

$routes->get(
    '/sales/receipt/(:num)',
    'SaleController::receipt/$1',
    ['filter' => 'auth']
);
