<?php
require_once 'settings.php';

$dbinfo = $ini_array['db'];
$host = $dbinfo['hostname'];
$user = $dbinfo['username'];
$pass = $dbinfo['password'];
$dtbs = $dbinfo['database'];

$mysqli = new mysqli($host, $user, $pass, $dtbs);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
}

?>
