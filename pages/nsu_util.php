<?php
require_once 'database.php';
require_once 'facebook_api.php';

function createGalleryTable() {
    $createGalleryQuery = 'CREATE TABLE gallery ( '
        . 'id BIGINT NOT NULL PRIMARY KEY, '
        . 'title VARCHAR(255) NOT NULL, '
        . 'cover_url VARCHAR(512) NOT NULL)';
    
    $db = new DBHelper();
    $db->connect();
    $db->createTable('gallery', $createGalleryQuery);
}

function getAlbumCoverSrc($albumId) {
    global $fb, $fb_token;
    $method = 'GET';
    $endpoint = '/' . $albumId;
    $options = [
        'fields' => 'cover_photo',
    ];

    // Get ID of cover photo
    $response = $fb->sendRequest($method, $endpoint, $options, $fb_token)->getDecodedBody();
    $coverId = $response['cover_photo']['id'];

    $endpoint = '/' . $coverId;
    $options = [
        'fields' => 'images',
    ];

    // Get images for cover photo, returned as a list.
    $response = $fb->sendRequest($method, $endpoint, $options, $fb_token)->getDecodedBody();
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

function fetchGalleryAlbums() {
    global $fb, $fb_gid, $fb_token;
    $method = 'GET';
    $endpoint = '/' . $fb_gid . '/albums';

    $ev_options = [
    ];

    // get list of albums
    $response = $fb->sendRequest($method, $endpoint, $ev_options, $fb_token)->getDecodedBody();
    $albums = array();
    if (isset($response['data'])) {
        $albums = $response['data'];
    }

    $db = new DBHelper();
    $db->connect();

    foreach ($albums as $album) {
        $coverSrc = getAlbumCoverSrc($album['id']);

        if (strlen($coverSrc) > 0) {
            // insert into DB
            $db->insertIntoGallery($album['id'], $album['name'], $coverSrc);
        }
    }
}


?>
