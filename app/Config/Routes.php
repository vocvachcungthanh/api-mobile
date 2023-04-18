<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('index');
// $routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Index::index');

$routes->get('admin', 'Admin\AdminController::index');

$routes->get('error/404', function(){
    return view('errors/html/error_404');
});

$routes->group('admin', function($routes){
    $routes->get('user', 'Admin\Users\UserController::index');

    $routes->group('user', function($routes){
        $routes->get('add', 'Admin\Users\UserController::addUser');
        $routes->post('create', 'Admin\Users\UserController::createUser');
        $routes->get('edit/(:num)', 'Admin\Users\UserController::editUser/$1');
        $routes->post('update', 'Admin\Users\UserController::updateUser');
        $routes->get('delete/(:num)', 'Admin\Users\UserController::deleteUser/$1');
    });
});


$routes->group('api', function($routes){
    $routes->get('user', 'Api\Users\UserController::index');
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}