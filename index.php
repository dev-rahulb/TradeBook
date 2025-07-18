<?php

use CodeIgniter\Boot;
use Config\Paths;

//---------------------------------------------------------------
// CHECK PHP VERSION
//---------------------------------------------------------------
$minPhpVersion = '8.1';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;
    exit(1);
}

//---------------------------------------------------------------
// SET THE CURRENT DIRECTORY
//---------------------------------------------------------------
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

//---------------------------------------------------------------
// LOAD PATHS CONFIGURATION
//---------------------------------------------------------------
// Location of the Paths config file.
require_once realpath(FCPATH . '/app/Config/Paths.php');

// Create the Paths config class
$paths = new Paths();

//---------------------------------------------------------------
// BOOTSTRAP THE APPLICATION
//---------------------------------------------------------------
require_once rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot.php';

exit(Boot::bootWeb($paths));
