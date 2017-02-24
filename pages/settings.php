<?php
// Set timezone to PST
date_default_timezone_set('America/Los_Angeles');

// Load site-wide settings stored in INI file
define("CONFIG", dirname(__FILE__) . "/../config.ini");
$ini_array = parse_ini_file(CONFIG, true);
?>
