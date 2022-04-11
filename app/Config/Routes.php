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
//************************************FRONT-END side route****************************//

$routes->add('home', 'Home_c::index');
$routes->add('listing/(:num)', 'Home_c::listing/$1');
$routes->add('details/(:num)', 'Home_c::details/$1');


// START ADMIN ROUTES
$routes->add('admin/login', 'Admin_login_c::index');
$routes->add('admin/logout', 'Admin_login_c::logout');
$routes->add('admin/dashboard', 'Admin_c::admin_dashboard');
$routes->add('admin/update-profile', 'Admin_c::update_profile');
$routes->add('admin/add-categories', 'Categories_c::add');
$routes->add('admin/view-categories', 'Categories_c::view');
$routes->add('admin/update-status', 'Categories_c::update_status');
$routes->add('edit-category/(:any)', 'Categories_c::edit_category/$1');

$routes->add('admin/add-packages', 'Packages_c::add');
$routes->add('admin/view-packages', 'Packages_c::view');
$routes->add('admin/update-packages-status', 'Packages_c::update_status');
$routes->add('edit-package/(:any)', 'Packages_c::edit_package/$1');

$routes->add('admin/add-ads-packages', 'AdsPackages_c::add');
$routes->add('admin/view-ads-packages', 'AdsPackages_c::view');
$routes->add('admin/update-ads-packages-status', 'AdsPackages_c::update_status');
$routes->add('edit-ads-package/(:any)', 'AdsPackages_c::edit_ads_package/$1');

$routes->add('admin/add-slider', 'Slider_c::add');
$routes->add('admin/view-slider', 'Slider_c::view');
$routes->add('admin/update-slider-status', 'Slider_c::update_status');
$routes->add('edit-slider/(:any)', 'Slider_c::edit_slider/$1');

$routes->add('admin/add-hotel-facility', 'HotelFacility_c::add');
$routes->add('admin/view-hotel-facility', 'HotelFacility_c::view');
$routes->add('admin/update-hotel-facility-status', 'HotelFacility_c::update_status');
$routes->add('edit-hotel-facility/(:any)', 'HotelFacility_c::edit_facility/$1');

$routes->add('admin/add-hotel', 'Hotel_c::add');
$routes->add('admin/view-hotel', 'Hotel_c::view');
$routes->add('admin/update-hotel-status', 'Hotel_c::update_status');
$routes->add('admin/load-hotel-package', 'Hotel_c::load_package');
$routes->add('edit-hotel/(:any)', 'Hotel_c::edit_hotel/$1');
$routes->add('delete-hotel-image', 'Hotel_c::delete_hotel_image');

$routes->add('admin/add-hotel-room', 'HotelRoom_c::add');
$routes->add('admin/view-hotel-room', 'HotelRoom_c::view');
$routes->add('admin/update-hotel-room-status', 'HotelRoom_c::update_status');
$routes->add('edit-hotel-room/(:any)', 'HotelRoom_c::edit_hotel_room/$1');
$routes->add('delete-hotel-room-image', 'HotelRoom_c::delete_hotel_room_image');

$routes->add('admin/view-top-package-payments', 'TopPackagePayment_c::view');
$routes->add('admin/make-top-package-hotel-payments', 'Hotel_c::make_hotel_top_package_payments');




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
