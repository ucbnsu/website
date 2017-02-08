<?php
// Loads site-wide settings stored in INI file

define("CONFIG", dirname(__FILE__) . "/../config.ini");
$ini_array = parse_ini_file(CONFIG, true);
?>
