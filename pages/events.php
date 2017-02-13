<?php
include 'settings.php';
$fbinfo = $ini_array['fb'];
$eventsinfo = $ini_array['events'];

$fb_gid = $fbinfo['groupid'];
$fb_token = $fbinfo['token'];

require_once '../sdk/Facebook/autoload.php';
$fb = new Facebook\Facebook([
    'app_id'     => $fbinfo['appid'],
    'app_secret' => $fbinfo['appsecret'],
    'default_graph_version' => $fbinfo['apiver'],
]);

$eventsinfo = $ini_array['events'];
$ev_options = [
    'since' => $eventsinfo['start'],
    'until' => $eventsinfo['end'],
];

$req_method = 'GET';
$req_endpoint = '/' . $fb_gid . '/events';

$response = $fb->sendRequest($req_method, $req_endpoint, $ev_options, $fb_token);
$event_arr_tmp = $response->getDecodedBody();

// sort events by timestamp
$event_arr = array();
foreach ($event_arr_tmp['data'] as $event) {
    $d = DateTime::createFromFormat(DateTime::ISO8601, $event['start_time']);
    $event_arr[$d->getTimeStamp()] = $event;
}
ksort($event_arr, SORT_NUMERIC);
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
                <h1>Events this semester</h1>
            </div>
        </div>
        <div class="row">
<?php
// TODO breaks when more than 3 events in array, break into multiple rows
foreach ($event_arr as $timestamp => $event) {
    $d = new DateTime();
    $d->setTimestamp($timestamp);
    $d->setTimezone(new DateTimeZone('America/Los_Angeles'));
    $event_date = $d->format("l, F j h:iA ");
    $event_link = 'https://facebook.com/events/' . $event['id'];
    $event_image = 'event_' . $event['id'] . '.jpg'; // JPEG required at this time
?>
            <div class="col-md-4">
<?php
    if (file_exists('../pictures/' . $event_image)) {
        echo '<img src="/pictures/' . $event_image . '" class="img-responsive">';
    } else {
        echo '<img src="/pictures/event_default.jpg" class="img-responsive">';
    }
?>
                <h3><?php echo $event['name'] ?></h3>
                <p><?php echo $event_date ?></p>
<?php
            if (isset($event['place'])) {
                echo '<p>' . $event['place']['name'] . '</p>';
            }
?>
                <p class="text-right"><a style="color:black" href="<?php echo $event_link ?>">Details</a></p>
            </div>
<?php
}
?>
        </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>
