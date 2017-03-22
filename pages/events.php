<?php
require_once 'settings.php';
require_once 'database.php';
require_once 'facebook_api.php';

$db = new DBHelper();
$db->connect();
$events = $db->loadEvents();

// sort events by timestamp
$curtimestamp = (new DateTime())->getTimestamp();
$events_past = array();
$events_future = array();
foreach ($events as $event) {
    $timestamp = $event['time'];
    if ($timestamp < $curtimestamp) {
        $events_past[$timestamp] = $event;
    } else {
        $events_future[$timestamp] = $event;
    }
}
ksort($events_past, SORT_NUMERIC);
ksort($events_future, SORT_NUMERIC);
?>

<?php
function eventHtml($event) {
    $d = new DateTime();
    $d->setTimestamp($event['time']);
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
    echo "<p>{$event['place']}</p>";
    echo "<p class=\"text-right\"><a style=\"color:black\" href=\"{$event_link}\">Details</a></p>";
    echo "</div>";
}

function displayRow($events) {
    echo '<div class="row">';
    foreach ($events as $event) {
        eventHtml($event);
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
