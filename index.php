<?php namespace Halo;

// Init composer auto-loading
if (!@include_once("vendor/autoload.php")) {

    exit('Run composer install');

}

include __DIR__ . '/system/functions.php';

// Load config
if (file_exists('config.php')) {
    include 'config.php';
} else {
    error_out('No config.php. Please make a copy of config.sample.php and name it config.php and configure it.', 500);
}


// Project constants
define('PROJECT_NAME', 'ScrumBoard');
define('PROJECT_NATIVE_LANGUAGE', 'en');
define('DEFAULT_CONTROLLER', 'boards');

// Load app
require 'system/classes/Application.php';
$app = new Application;
