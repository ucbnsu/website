<?php

require_once '../sdk/Facebook/autoload.php';

require_once 'settings.php';

$fbinfo = $ini_array['fb'];
$fb = new Facebook\Facebook([
    'app_id'     => $fbinfo['appid'],
    'app_secret' => $fbinfo['appsecret'],
    'default_graph_version' => $fbinfo['apiver'],
]);

$fb_gid = $fbinfo['groupid'];
$fb_token = $fbinfo['token'];

class FBHelper {
    var $sdk;
    var $fbinfo;
    var $eventsinfo;
    var $gid;
    var $token;

    function __construct() {
        $ini_array = parse_ini_file(dirname(__FILE__) . '/../config.ini', true);
        $this->fbinfo = $ini_array['fb'];
        $this->eventsinfo = $ini_array['events'];

        $this->sdk = new Facebook\Facebook([
            'app_id'        => $this->fbinfo['appid'],
            'app_secret'    => $this->fbinfo['appsecret'],
            'default_graph_version' => $this->fbinfo['apiver'],
        ]);

        $this->gid = $this->fbinfo['groupid'];
        $this->token = $this->fbinfo['token'];
    }

    function __destruct() {
    }

    function sendRequest($method, $endpoint, $params) {
        if ($response = $this->sdk->sendrequest($method, $endpoint, $params, $this->token)) {
            if ($decodedBody = $response->getDecodedBody()) {
                return $decodedBody;
            }
        }
        return null;
    }

    function getEvents() {
        $method = 'GET';
        $endpoint = '/' . $this->gid . '/events';
        $params = [
            'since' => $this->eventsinfo['start'],
            'until' => $this->eventsinfo['end'],
        ];

        $event_arr_tmp = $this->sendRequest($method, $endpoint, $params);
        if ($event_arr_tmp && array_key_exists('data', $event_arr_tmp)) {
            $event_arr_tmp = $event_arr_tmp['data'];
        } else {
            $event_arr_tmp = array();
        }
        if (isset($eventsinfo['additionalEvents'])) {
            $additionalEvents = $eventsinfo['additionalEvents'];
        } else {
            $additionalEvents = array();
        }
        // add additional events from config
        foreach ($additionalEvents as $eventId) {
            $eventDetails = $this->getEventDetail($eventId);
            if ($eventDetails) {
                array_push($event_arr_tmp['data'], $eventDetails);
            }
        }

        return $event_arr_tmp;
    }

    function getEventDetail($eventId) {
        $method = 'GET';
        $endpoint = '/' . $eventId;
        $params = [];

        return $this->sendRequest($method, $endpoint, $params);
    }

    function getCoverPhotoId($albumId) {
        $method = 'GET';
        $endpoint = '/' . $albumId;
        $params = [
            'fields' => 'cover_photo',
        ];

        // Get ID of cover photo
        $response = $this->sendRequest($method, $endpoint, $params);
        if ($response) {
            return $response['cover_photo']['id'];
        }
        return null;
    }

    function getCoverPhotoImageSrc($coverId) {
        $endpoint = '/' . $coverId;
        $params = [
            'fields' => 'images',
        ];

        // Get images for cover photo, returned as a list.
        $response = $this->sendRequest($method, $endpoint, $params);
        if (! $response) {
            return "";
        }

        $images = $response['images'];
        if (count($images) < 1) {
            return ""; // TODO come up with default cover
        }

        // Select a reasonably sized image out of the list, otherwise return first image.
        foreach ($images as $image) {
            if ($image['width'] < 500) {
                return $image['source'];
            }
        }
        return $images[0]['source'];
    }

    function getAlbums() {
        $method = 'GET';
        $endpoint = '/' . $fb_gid . '/albums';
        $params = [];

        // get list of albums
        $albums = $this->sendRequest($method, $endpoint, $params);
        if (! $albums) {
            $albums = array();
        }

        return $albums;
    }
}
?>
