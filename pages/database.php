<?php
require_once 'db.inc.php';
require_once 'facebook_api.php';

function createGalleryTable($mysqli) {
    $TABLE_LOOKUP_QUERY = 'SELECT 1 FROM gallery LIMIT 1';

    $TABLE_CREATE_QUERY = 'CREATE TABLE gallery ( '
        . 'id BIGINT NOT NULL PRIMARY KEY, '
        . 'title VARCHAR(255) NOT NULL, '
        . 'cover_url VARCHAR(512) NOT NULL)';

    // check if table exists
    if (! $mysqli->query($TABLE_LOOKUP_QUERY)) {
        // create table
        if (!$mysqli->query($TABLE_CREATE_QUERY)) {
            echo "Error: " . $mysqli->error; // TODO fallback method for entire website
        }
    }
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

function fetchGalleryAlbums($mysqli) {
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

    foreach ($albums as $album) {
        $coverSrc = getAlbumCoverSrc($album['id']);

        if (strlen($coverSrc) > 0) {
            // insert into DB
            if ($insertStmt = $mysqli->prepare('INSERT INTO gallery (id, title, cover_url) VALUES (?, ?, ?)')) {
                $insertStmt->bind_param('sss', $album['id'], $album['name'], $coverSrc);
                if (! $insertStmt->execute()) {
                    // NOTE: may want to update records, although most likely the same
                }
            }
        }
    }
}

function loadGalleryFromDb($mysqli) {
    $gallery = array();

    $selectQuery = 'SELECT id, title, cover_url FROM gallery';
    if ($result = $mysqli->query($selectQuery)) {
        while ($row = $result->fetch_assoc()) {
            $album = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'cover_url' => $row['cover_url']
            );
            $gallery[$row['id']] = $album;
        }
    }

    // display new albums first
    krsort($gallery, SORT_NUMERIC);
    return $gallery;
}

?>
