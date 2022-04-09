<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


//**************************************FRONT-END LINK****************************//
define('HOME_LINK', BASE_URL.'/home');
define('LISTING_LINK', BASE_URL.'/listing/');
define('DETAILS_LINK', BASE_URL.'/details/');


//**************************************FRONT-END ADMIN TITLE****************************//
define('HOME_TITLE', 'HOME');
define('LISTING', 'LISTING');
define('DETAILS', 'DETAILS');

// START ADMIN TITLES
define('ADMIN_LOGIN_TITLE', 'SAPUTARA-TOURISM-ADMIN-LOGIN');
define('ADMIN_DASHBOARD', 'Admin dashboard');
define('ADMIN_UPDATE_PROFILE_TITLE', 'Admin update profile');
define('ADD_CATEGOIRES', 'Add Categories');
define('VIEW_CATEGOIRES', 'View Categories');
define('ADMIN_EDIT_CATEGORY_TITLE', 'Edit Categories');

define('ADD_PACKAGES', 'Add Packages');
define('VIEW_PACKAGES', 'View Packages');
define('ADMIN_EDIT_PACKAGES_TITLE', 'Edit Packages');

define('ADD_ADS_PACKAGES', 'Add Ads Packages');
define('VIEW_ADS_PACKAGES', 'View Ads Packages');
define('ADMIN_EDIT_ADS_PACKAGES_TITLE', 'Edit Ads Packages');

define('ADD_SLIDER', 'Add slider');
define('VIEW_SLIDER', 'View slider');
define('ADMIN_EDIT_SLIDER_TITLE', 'Edit slider');

define('ADD_HOTEL_FACILITY', 'Add hotel facility');
define('VIEW_HOTEL_FACILITY', 'View hotel facility');
define('ADMIN_EDIT_HOTEL_FACILITY_TITLE', 'Edit hotel facility');

define('ADD_HOTEL', 'Add Hotel');
define('VIEW_HOTEL', 'View Hotel');
define('ADMIN_EDIT_HOTEL_TITLE', 'Edit Hotel');

define('ADD_HOTEL_ROOM', 'Add Hotel Room');
define('VIEW_HOTEL_ROOM', 'View Hotel Room');
define('ADMIN_EDIT_HOTEL_ROOM_TITLE', 'Edit Hotel Room');

define('VIEW_TOP_PACKAGE_PAYMENT', 'View Top Package Payment');



// START ADMIN LINK
define('ADMIN_LOGIN_LINK', BASE_URL_CI.'/admin/login');
define('ADMIN_LOGOUT_LINK', BASE_URL_CI.'/admin/logout');
define('ADMIN_DASHBOARD_LINK', BASE_URL_CI.'/admin/dashboard');
define('ADMIN_UPDATE_PROFILE_LINK', BASE_URL_CI.'/admin/update-profile');
define('ADMIN_ADD_CATEGORIES_LINK', BASE_URL_CI.'/admin/add-categories');
define('ADMIN_VIEW_CATEGORIES_LINK', BASE_URL_CI.'/admin/view-categories');
define('ADMIN_UPDATE_CATEGORY_STATUS', BASE_URL_CI.'/admin/update-status');
define('ADMIN_EDIT_CATEGORY_LINK', BASE_URL_CI.'/edit-category');
define('ADMIN_LOAD_HOTEL_PACKAGE_LINK', BASE_URL_CI.'/admin/load-hotel-package');
define('ADMIN_DELETE_HOTEL_IMAGE', BASE_URL_CI.'/admin/delete-hotel-image');

define('ADMIN_ADD_PACKAGES_LINK', BASE_URL_CI.'/admin/add-packages');
define('ADMIN_VIEW_PACKAGES_LINK', BASE_URL_CI.'/admin/view-packages');
define('ADMIN_UPDATE_PACKAGES_STATUS', BASE_URL_CI.'/admin/update-packages-status');
define('ADMIN_EDIT_PACKAGES_LINK', BASE_URL_CI.'/edit-package');

define('ADMIN_ADD_ADS_PACKAGES_LINK', BASE_URL_CI.'/admin/add-ads-packages');
define('ADMIN_VIEW_ADS_PACKAGES_LINK', BASE_URL_CI.'/admin/view-ads-packages');
define('ADMIN_UPDATE_ADS_PACKAGES_STATUS', BASE_URL_CI.'/admin/update-ads-packages-status');
define('ADMIN_EDIT_ADS_PACKAGES_LINK', BASE_URL_CI.'/edit-ads-package');

define('ADMIN_ADD_SLIDER_LINK', BASE_URL_CI.'/admin/add-slider');
define('ADMIN_VIEW_SLIDER_LINK', BASE_URL_CI.'/admin/view-slider');
define('ADMIN_UPDATE_SLIDER_STATUS', BASE_URL_CI.'/admin/update-slider-status');
define('ADMIN_EDIT_SLIDER_LINK', BASE_URL_CI.'/edit-slider');

define('ADMIN_ADD_HOTEL_FACILITY_LINK', BASE_URL_CI.'/admin/add-hotel-facility');
define('ADMIN_VIEW_HOTEL_FACILITY_LINK', BASE_URL_CI.'/admin/view-hotel-facility');
define('ADMIN_UPDATE_HOTEL_FACILITY_STATUS', BASE_URL_CI.'/admin/update-hotel-facility-status');
define('ADMIN_EDIT_HOTEL_FACILITY_LINK', BASE_URL_CI.'/edit-hotel-facility');

define('ADMIN_ADD_HOTEL_LINK', BASE_URL_CI.'/admin/add-hotel');
define('ADMIN_VIEW_HOTEL_LINK', BASE_URL_CI.'/admin/view-hotel');
define('ADMIN_UPDATE_HOTEL_STATUS', BASE_URL_CI.'/admin/update-hotel-status');
define('ADMIN_EDIT_HOTEL_LINK', BASE_URL_CI.'/edit-hotel');

define('ADMIN_ADD_HOTEL_ROOM_LINK', BASE_URL_CI.'/admin/add-hotel-room');
define('ADMIN_VIEW_HOTEL_ROOM_LINK', BASE_URL_CI.'/admin/view-hotel-room');
define('ADMIN_UPDATE_HOTEL_ROOM_STATUS', BASE_URL_CI.'/admin/update-hotel-room-status');
define('ADMIN_EDIT_HOTEL_ROOM_LINK', BASE_URL_CI.'/edit-hotel-room');
define('ADMIN_DELETE_HOTEL_ROOM_IMAGE', BASE_URL_CI.'/admin/delete-hotel-room-image');

define('ADMIN_VIEW_TOP_PACKAGE_PAYMENT_LINK', BASE_URL_CI.'/admin/view-top-package-payments');


// START CLIENT TITLE
define('CLIENT_LOGIN_TITLE', 'SAPUTARA-TOURISM-CLIENT-LOGIN');
define('CLIENT_DASHBOARD', 'Client dashboard');
define('CLIENT_UPDATE_PROFILE_TITLE', 'Client update profile');


// START CLIENT LINK
define('CLIENT_LOGIN_LINK', BASE_URL_CI.'/client/login');
define('CLIENT_LOGOUT_LINK', BASE_URL_CI.'/client/logout');
define('CLIENT_DASHBOARD_LINK', BASE_URL_CI.'/client/dashboard');
define('CLIENT_UPDATE_PROFILE_LINK', BASE_URL_CI.'/client/update-profile');

