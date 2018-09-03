<?php
/**
 * Plugin Name: Linimex Address Lookup
 * Plugin URI: https://www.chapteragency.com
 * Description: Plugin to integrate with Colt API and perform lookups
 * Version: 1.2.5
 * Author: Kevin Price-Ward
 * Author URI: https://www.chapteragency.com
 */

// Composer autoloading.

use LinimexAddressLookup\Utils;

require_once __DIR__ . '/vendor/autoload.php';

$init = new Utils\init();
$init->init(__FILE__);