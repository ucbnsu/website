<?php

require_once '../sdk/Facebook/autoload.php';

require_once 'settings.php';

$fbinfo = $ini_array['fb'];
$fb = new Facebook\Facebook([
    'app_id'     => $fbinfo['appid'],
    'app_secret' => $fbinfo['appsecret'],
    'default_graph_version' => $fbinfo['apiver'],
]);

?>
