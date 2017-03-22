<?php
require_once 'database.php';
require_once 'facebook_api.php';

function createEventsTable() {
    $tblName = 'events';
    $createEventQuery = 'CREATE TABLE ' . $tblName . ' ( '
        . 'id BIGINT NOT NULL PRIMARY KEY, '
        . 'name VARCHAR(255) NOT NULL, '
        . 'time BIGINT NOT NULL, '
        . 'place VARCHAR(255))';

    $db = new DBHelper();
    $db->connect();
    $db->createTable($tblName, $createEventQuery);
}

function createGalleryTable() {
    $tblName = 'gallery';
    $createGalleryQuery = 'CREATE TABLE ' . $tblName . ' ( '
        . 'id BIGINT NOT NULL PRIMARY KEY, '
        . 'title VARCHAR(255) NOT NULL, '
        . 'cover_url VARCHAR(512) NOT NULL)';

    $db = new DBHelper();
    $db->connect();
    $db->createTable($tblName, $createGalleryQuery);
}

function getAlbumCoverSrc($albumId) {
    $fb = new FBHelper();
    $coverId = $fb->getCoverPhotoId($albumId);
    return $fb->getCoverPhotoImageSrc($coverId);
}

function fetchGalleryAlbums() {
    $fb = new FBHelper();
    $albums = $fb->getAlbums();

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

function fetchEvents() {
    $db = new DBHelper();
    $db->connect();

    $fb = new FBHelper();
    $events = $fb->getEvents();

    foreach ($events as $event) {
        $d = DateTime::createFromFormat(DateTime::ISO8601, $event['start_time']);

        if ($d) {
            $id = $event['id'];
            $name = $event['name'];
            $time = $d->getTimestamp();
            if (array_key_exists('place', $event)) {
                $place = $event['place']['name'];
            } else {
                $place = "";
            }

            $db->insertIntoEvents($id, $name, $time, $place);
        }
    }
}

?>
