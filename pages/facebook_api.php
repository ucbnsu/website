<?php

require_once '../sdk/Facebook/autoload.php';

require_once 'settings.php';

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
            $events = $event_arr_tmp['data'];
        } else {
            $events = array();
        }

        // add additional events from config
        if ($this->eventsinfo && array_key_exists('additionalEvents', $this->eventsinfo)) {
            $additionalEvents = $this->eventsinfo['additionalEvents'];
            foreach ($additionalEvents as $eventId) {
                $eventDetails = $this->getEventDetail($eventId);
                if ($eventDetails) {
                    array_push($events, $eventDetails);
                }
            }
        }

        return $events;
    }

    function getEventDetail($eventId) {
        $method = 'GET';
        $endpoint = '/' . $eventId;
        $params = [];

        return $this->sendRequest($method, $endpoint, $params);
    }

    /**
     * Get event cover photo and save to disk.
     * Returns relative path of saved image.
     * On error will return path to default cover.
     */
    function getEventCover($eventId) {
        $COVER_DIR = '/pictures/events';

        $method = 'GET';
        $endpoint = '/' . $eventId;
        $params = [
            'fields' => 'cover',
        ];

        try {
            // Get event cover photo
            $response = $this->sendRequest($method, $endpoint, $params);
            if ($response) {
                $coverSrc = $response['cover']['source'];
                $coverData = file_get_contents($coverSrc);

                $SAVE_DIR = dirname(__FILE__) . "/../pictures/events";
                if (file_put_contents($SAVE_DIR . "/{$eventId}.jpg", $coverData)) {
                    return $COVER_DIR . "/{$eventId}.jpg";
                } else {
                    throw new Exception("file_put_contents failed");
                }
            }
        } catch (Exception $e) {
            return $COVER_DIR . "/default.jpg";
        }
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
        $method = 'GET';
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
        $endpoint = '/' . $this->gid . '/albums';
        $params = [];

        // get list of albums
        $albums = $this->sendRequest($method, $endpoint, $params);
        if ($albums) {
            $albums = $albums['data'];
        } else {
            $albums = array();
        }

        return $albums;
    }
}
?>
