<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home_c::index');
$routes->add('404_override', 'Home_c::page404');
$routes->add('errorpage', 'Home_c::page404');
//************************************Admin side route****************************//

$routes->add('home', 'Home_c::index');
$routes->add('about', 'Home_c::about');
$routes->add('explore', 'Home_c::explore');
$routes->add('contact', 'Home_c::contact');
$routes->add('festival', 'Home_c::festival');
$routes->add('news', 'Home_c::news');

$routes->add('listing/(:num)', 'Home_c::listing/$1');


// START ADMIN ROUTES
$routes->add('admin/login', 'Admin_login_c::index');
$routes->add('admin/logout', 'Admin_login_c::logout');
$routes->add('admin/dashboard', 'Admin_c::admin_dashboard');
$routes->add('admin/update-profile', 'Admin_c::update_profile');



// START CLIENT ROUTES
$routes->add('client/login', 'Client_login_c::index');
$routes->add('client/logout', 'Client_login_c::logout');
$routes->add('client/dashboard', 'Client_c::client_dashboard');
$routes->add('client/update-profile', 'Client_c::client_profile');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
