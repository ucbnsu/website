<?php
require_once 'settings.php';
require_once 'database.php';

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

/**
 * Displays photo albums (aka gallery) from the database.
 */
function displayAlbums() {
    $db = new DBHelper();
    $db->connect();
    $albums = $db->loadGallery();

    // max. number of albums defined in config
    try {
        global $ini_array;
        $numDisplay = $ini_array['gallery']['numDisplay'];
    } catch (Exception $e) {
        $numDisplay = 24;
    }
    $albums = array_slice($albums, 0, $numDisplay);

    // display 1 row at a time for bootstrap
    $i = 0;
    while ($i < count($albums)) {
        $row = array_slice($albums, $i, min(3, count($albums) - $i));
        echo '<div class="row">';
        foreach ($row as $album) {
            albumHtml($album);
        }
        echo '</div>';
        $i += 3;
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'head.php' ?>
</head>
<div class="wrapper-x">
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
</div>
</html>
