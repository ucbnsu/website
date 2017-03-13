<?php
require_once 'settings.php';
require_once 'facebook_api.php';
require_once 'database.php';

$fb_gid = $fbinfo['groupid'];
$fb_token = $fbinfo['token'];

$ev_options = [
];

$req_method = 'GET';
$req_endpoint = '/' . $fb_gid . '/albums';

?>

<?php
function getAlbumLink($albumId) {
    $link = 'https://www.facebook.com/media/set/?set=oa.';
    return $link . $albumId . '&type=3';
}

function albumHtml($album) {
    $albumUrl = getAlbumLink($album['id']);
    $coverUrl = $album['cover_url'];

    echo '<div class="col-md-4">';
    echo "<h3>{$album['title']}</h3>";
    echo "<a href=\"{$albumUrl}\"><img style=\"width:100%;\" src=\"{$coverUrl}\" ></a><br />";
    echo "<p class=\"text-right\"><a style=\"color:black\" href=\"{$albumUrl}\">Go to Album</a></p>";
    echo "</div>";
}

function displayRow($row) {
    echo '<div class="row">';
    foreach ($row as $album) {
        albumHtml($album);
    }
    echo '</div>';
}

function displayAlbums() {
    global $mysqli;
    $albums = loadGalleryFromDb($mysqli);
    $i = 0;
    while ($i < count($albums)) {
        $row = array_slice($albums, $i, min(3, count($albums) - $i));
        displayRow($row);
        $i += 3;
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'head.php' ?>
</head>
<body>
    <?php include 'header.php' ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Past Events</h1>
            </div>
        </div>

        <?php displayAlbums(); ?>

    </div>
    <?php include 'footer.php' ?>
</body>
</html>
