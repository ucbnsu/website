<?php
require_once 'settings.php';
require_once 'facebook_api.php';

$eventsinfo = $ini_array['events'];
if (isset($eventsinfo['additionalEvents'])) {
    $additionalEvents = $eventsinfo['additionalEvents'];
} else {
    $additionalEvents = array();
}

$ev_options = [
    'since' => $eventsinfo['start'],
    'until' => $eventsinfo['end'],
];

$req_method = 'GET';
$req_endpoint = '/' . $fb_gid . '/events';

$response = $fb->sendRequest($req_method, $req_endpoint, $ev_options, $fb_token);
$event_arr_tmp = $response->getDecodedBody();

// add additional events from config
foreach ($additionalEvents as $eventId) {
    $ev = $fb->sendRequest($req_method, '/' . $eventId, $ev_options, $fb_token)->getDecodedBody();
    array_push($event_arr_tmp['data'], $ev);
}

// sort events by timestamp
$curtimestamp = (new DateTime())->getTimestamp();
$events_past = array();
$events_future = array();
foreach ($event_arr_tmp['data'] as $event) {
    $d = DateTime::createFromFormat(DateTime::ISO8601, $event['start_time']);
    if ($d->getTimeStamp() < $curtimestamp) {
        $events_past[$d->getTimeStamp()] = $event;
    } else {
        $events_future[$d->getTimeStamp()] = $event;
    }
}
ksort($events_past, SORT_NUMERIC);
ksort($events_future, SORT_NUMERIC);
?>

<?php
function eventHtml($timestamp, $event) {
    $d = new DateTime();
    $d->setTimestamp($timestamp);
    $d->setTimezone(new DateTimeZone('America/Los_Angeles'));
    $event_date = $d->format("l, F j h:iA ");
    $event_link = 'https://facebook.com/events/' . $event['id'];
    $event_image = 'event_' . $event['id'] . '.jpg'; // JPEG required at this time

    echo '<div class="col-md-4">';

    echo "<a href=\"${event_link}\">";
    if (file_exists('../pictures/' . $event_image)) {
        echo '<img src="/pictures/' . $event_image . '" class="img-responsive">';
    } else {
        echo '<img src="/pictures/event_default.jpg" class="img-responsive">';
    }
    echo '</a>';

    echo "<h3>{$event['name']}</h3>";
    echo "<p>{$event_date}</p>";
    if (isset($event['place'])) {
        echo "<p>{$event['place']['name']}</p>";
    }
    echo "<p class=\"text-right\"><a style=\"color:black\" href=\"{$event_link}\">Details</a></p>";
    echo "</div>";
}

function displayRow($events) {
    echo '<div class="row">';
    foreach ($events as $event) {
        $d = DateTime::createFromFormat(DateTime::ISO8601, $event['start_time']);
        $timestamp = $d->getTimeStamp();
        eventHtml($timestamp, $event);
    }
    echo '</div>';
}

function displayEvents($events_arr) {
    $i = 0;
    while ($i < count($events_arr)) {
        $event_row = array_slice($events_arr, $i, min(3, count($events_arr) - $i));
        displayRow($event_row);
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
                <h1>Upcoming events</h1>
            </div>
        </div>

        <?php displayEvents($events_future); ?>

        <div class="row">
            <div class="col-md-8">
                <h1>Past events</h1>
            </div>
        </div>

        <?php displayEvents($events_past); ?>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>
