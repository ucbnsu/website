<?php
require_once 'settings.php';

class DBHelper {
    var $mysqli;
    var $dbinfo;

    function __construct() {
        $ini_array = parse_ini_file(dirname(__FILE__) . '/../config.ini', true);
        $this->mysqli = null;
        $this->dbinfo = $ini_array['db'];
    }

    function __destruct() {
        if ($this->mysqli) {
            $this->mysqli->close();
            $this->mysqli = null;
        }
    }

    function connect() {
        $host = $this->dbinfo['hostname'];
        $user = $this->dbinfo['username'];
        $pass = $this->dbinfo['password'];
        $dtbs = $this->dbinfo['database'];
        $this->mysqli = new mysqli($host, $user, $pass, $dtbs);
        if ($this->mysqli->connect_error) {
            throw new Exception('mysqli connect error ' . $this->mysqli->connect_errno . ': ' . $this->mysqli->connect_error, $this->mysqli->connect_errno);
        }
    }

    function createTable($tbName, $createQuery) {
        if (! isset($this->mysqli)) {
            return;
        }

        $TABLE_LOOKUP_QUERY = "SELECT 1 FROM {$tbName} LIMIT 1";

        if (! $this->mysqli->query($TABLE_LOOKUP_QUERY)) {
            if (! $this->mysqli->query($createQuery)) {
                throw new Exception('mysqli createTable() error ' . $this->mysqli->connect_errno . ': ' . $this->mysqli->connect_error, $this->mysqli->connect_errno);
            }
        }
    }

    function insertIntoGallery($id, $title, $cover_url) {
        if (! isset($this->mysqli)) {
            return;
        }

        $insertQuery = 'INSERT INTO gallery (id, title, cover_url) VALUES (?, ?, ?) '
            . 'ON DUPLICATE KEY UPDATE '
            . 'title = ?, '
            . 'cover_url = ?';

        if ($insertStmt = $this->mysqli->prepare($insertQuery)) {
            $insertStmt->bind_param('sssss', $id, $title, $cover_url, $title, $cover_url);
            if (! $insertStmt->execute()) {
                // TODO handle error
            }
        }
    }

    function loadGallery() {
        $gallery = array();

        // TODO figure out max number of albums to return
        $selectQuery = 'SELECT id, title, cover_url FROM gallery LIMIT 100';
        if ($result = $this->mysqli->query($selectQuery)) {
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
}
?>
