<?php
require_once 'settings.php';
require_once 'facebook_api.php';

$eventsinfo = $ini_array['events'];
if (isset($eventsinfo['additionalEvents'])) {
    $additionalEvents = $eventsinfo['additionalEvents'];
} else {
    $additionalEvents = array();
}

$fb_gid = $fbinfo['groupid'];
$fb_token = $fbinfo['token'];

$eventsinfo = $ini_array['events'];
$ev_options = [
];

$req_method = 'GET';
$req_endpoint = '/' . $fb_gid . '/albums';

//$response = $fb->sendRequest($req_method, $req_endpoint, $ev_options, $fb_token);
//$event_arr_tmp = $response->getDecodedBody();
$response = $fb->sendRequest($req_method, $req_endpoint, $ev_options, $fb_token)->getDecodedBody();
$albums = array();
if (isset($response['data'])) {
    $albums = $response['data'];
}
//var_dump($albums);
?>

<?php
// TODO move functions into api file
// TODO investigate if pagination required if more albums exist
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

function getAlbumLink($albumId) {
    $link = 'https://www.facebook.com/media/set/?set=oa.';
    return $link . $albumId . '&type=3';
}

function albumHtml($album) {
    $albumUrl = getAlbumLink($album['id']);
    $coverUrl = getAlbumCoverSrc($album['id']);

    echo '<div class="col-md-4">';
    echo "<h3>{$album['name']}</h3>";
    echo "<img style=\"width:100%;\" src=\"{$coverUrl}\" ><br />";
    echo "<p class=\"text-right\"><a style=\"color:black\" href=\"{$albumUrl}\">Go to Album</a></p>";
    echo "</div>";
}

function displayRow($row) {
    echo '<div class="row">';
    foreach ($row as $item) {
        albumHtml($item);
    }
    echo '</div>';
}

function displayAlbums($arr) {
    $i = 0;
    while ($i < count($arr)) {
        $row = array_slice($arr, $i, min(3, count($arr) - $i));
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

        <?php displayAlbums($albums); ?>

    </div>
    <?php include 'footer.php' ?>
</body>
</html>
