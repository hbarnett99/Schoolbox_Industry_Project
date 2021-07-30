<?php
/**
 * @copyright Copyright 2020, Schoolbox Pty Ltd
 * @link      https://schoolbox.com.au/
 */

/* Includes all global dependencies and functions
 * Sets up error reporting
 */
require 'conf.php';
require 'puppetdb.php';

// Turn on all error reporting in dev
if(env('environment') === 'development'){
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}
