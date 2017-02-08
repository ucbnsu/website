<?php
include 'settings.php';
$dbinfo = $ini_array['db'];
$host = $dbinfo['hostname'];
$user = $dbinfo['username'];
$pass = $dbinfo['password'];
$dtbs = $dbinfo['database'];

$connection = mysql_connect($host, $user, $pass);
mysql_select_db($dtbs);
?>
