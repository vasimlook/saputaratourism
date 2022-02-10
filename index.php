<?php
ini_set('max_execution_time', '400');
ini_set('memory_limit', '4096M');

$lifetime=900;
session_set_cookie_params($lifetime);
$protocol_http = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

//if($protocol_http=='https://'){
//    ini_set( 'session.cookie_httponly',TRUE);
//    ini_set('session.cookie_secure', TRUE);
//}else{
//    ini_set('session.cookie_samesite', 'None');
//}

//session_start();

include 'common_url.php';
// Valid PHP Version?
$minPHPVersion = '7.4';
if (phpversion() < $minPHPVersion)
{
	die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}
unset($minPHPVersion);

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Location of the Paths config file.
// This is the line that might need to be changed, depending on your folder structure.
$pathsPath = realpath(FCPATH . 'app/Config/Paths.php');
// ^^^ Change this if you move your application folder

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */
// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
require $pathsPath;
$paths = new Config\Paths();
// Location of the framework bootstrap file.
$app = require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

if($protocol_http=='https://'){
    setcookie(session_name(),session_id(),time()+$lifetime,$paths->writableDirectory.'session',1,1,TRUE);
}else{
    setcookie(session_name(),session_id(),time()+$lifetime,$paths->writableDirectory.'session',null,null,TRUE);
}

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();
