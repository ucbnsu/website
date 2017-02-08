<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'pages/head.php' ?>
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php include 'pages/header.php' ?>
        <?php include_once("pages/analyticstracking.php") ?>

        <div class="row">
            <div class="container">
                <img id="homepage_image" src="pictures/homepage_image.png" alt="">
            </div>
        </div>
        <div class="row">
            <div class="container">
                
                <div class="blurb col-sm-6">
                    <h3> Welcome to NSU!! </h3>
                    <hr>
                    <p>
                        NSU is a club that seeks to promote and celebrate Japanese American Culture. We have community service events and a Fall Semester Culture Show 
                        that seek to highlight Japanese American issues and perspectives. We also have fun events such as our annual Ski Trip to Lake Tahoe in the Spring. 
                    </p>
                    <p>
                        There is no need to be Japanese or Japanese American to join! We welcome anyone who has an interest in Japanese American culture or is looking to learn more about it! 
                    </p>
                </div>
                
                <div class="col-sm-6 text-center">
                    <h3> Site Under Construction! </h3>
                    <h3> Join our Mailing List! </h3>
                    <?php include 'pages/signup_form.php' ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="blurb col-sm-6">
                    <h3> Upcoming Events </h3>
                    <a class="blue" href="https://www.facebook.com/groups/NikkeiStudentUnion/events/">https://www.facebook.com/groups/NikkeiStudentUnion/events/</a>
                    <hr>
                    <iframe src="https://calendar.google.com/calendar/embed?src=berkeleynsu%40gmail.com&ctz=America/Los_Angeles&title=NSU%20Weekly%20Calendar&amp;showPrint=0&amp;mode=WEEK&amp;height=600&amp;wkst=1&amp;bgcolor=%23ffffff&amp;ctz=America%2FLos_Angeles" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
                    <?php

                        function findEvents($cur_date) {
                            include 'pages/Calendar_data.php';
                            $events = array();
                            foreach ($calendar_data as $event) {
                                if ($event["Date"] == $cur_date) {
                                    $events[] = $event;
                                }
                            }
                            return $events;
                        }
                        date_default_timezone_set("America/Los_Angeles");
                        $cur_date = new DateTime();
                        $thirty_days_from_now = (new DateTime())->modify('+30 day');
                        $events_displayed = 0;
                        $max_events_displayed = 3;

                        while ($events_displayed < $max_events_displayed && $cur_date < $thirty_days_from_now) {
                            $events = findEvents($cur_date->format("n/j/Y"));
                            foreach ($events as $event) {
                                $event_date = $event["Date"];
                                $event_name = $event["Name"];
                                $parts = explode(" ", $event_name);
                                $first_word = $parts[0];

                                echo '<a class="upcoming_events" href="pages/Event_page.php?query=' . $event_date . $first_word . '">' . $event["Date"] . " " . $event["Name"] .'</a>';
                                echo '</br>';
                                echo '</br>';
                                $events_displayed++;
                            }
                            $cur_date->modify('+1 day');
                        }
                    ?>
                </div>
                <div class="col-sm-6 text-center">
                </div>
            </div>
        </div>

        <?php include 'pages/footer.php' ?>
    </body>
</html>
