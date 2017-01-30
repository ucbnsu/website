<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'head.php' ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div id="general_content" class="">
            <center>
            <iframe src="https://calendar.google.com/calendar/embed?src=berkeleynsu%40gmail.com&ctz=America/Los_Angeles" id="google_calendar"></iframe>
            </center>
            <!--
            <center>
                <?php include 'Calendar_data.php'; ?>
                <?php 
                    date_default_timezone_set("America/Los_Angeles");
                    // src: http://www.phpjabbers.com/how-to-make-a-php-calendar-php26.html
                    $monthNames = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
                    if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");


                    $cMonth = $_REQUEST["month"];
                    $cYear = $_REQUEST["year"];
 
                    $prev_year = $cYear;
                    $next_year = $cYear;
                    $prev_month = $cMonth-1;
                    $next_month = $cMonth+1;
                     
                    if ($prev_month == 0 ) {
                        $prev_month = 12;
                        $prev_year = $cYear - 1;
                    }
                    if ($next_month == 13 ) {
                        $next_month = 1;
                        $next_year = $cYear + 1;
                    }
                ?>
                <table id="calendar1">
                    <tr align="center">

                    </tr>
                    <tr align="center">
                        <td id="month_year" colspan="7" >
                                <h2>
                                    <?php 
                                        echo $monthNames[$cMonth-1].' '.$cYear; 
                                    ?>
                                </h2>
                            <hr>    
                        </td>
                    </tr>
                    <tr>
                        <td class="calendar_button">
                            <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>">
                                Previous
                            </a>
                        </td>
                        <td class="calendar_button">
                            <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>">
                                Next
                            </a>
                        </td>
                        <td class="calendar_button">
                            <a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". date("n") . "&year=" . date("Y"); ?>">
                                Today
                            </a>
                        </td>
                    </tr>
                    <tr id="days_of_week">
                            <td align="center" >Sunday</td>
                            <td align="center" >Monday</td>
                            <td align="center" >Tuesday</td>
                            <td align="center" >Wednesday</td>
                            <td align="center" >Tuesday</td>
                            <td align="center" >Friday</td>
                            <td align="center" >Saturday</td>
                    </tr>
                    <?php
                        $timestamp = mktime(0,0,0,$cMonth,1,$cYear);
                        

                        $maxday = date("t",$timestamp);
                        $thismonth = getdate ($timestamp);
                        $startday = $thismonth['wday'];
                        $today = date("d");

                        // Figure out if we have passed the current month/year
                        $is_old_month = date("n") > ($cMonth) ? true : false;
                        $is_current_month = date("n") == ($cMonth) ? true : false;
                        $is_old_year = date("Y") > $cYear ? true : false;
                        $is_current_year = date("Y") == $cYear ? true : false;

                        // The 1st, 22nd etc. shifted because of empty boxes
                        $shifted_day = ($maxday + $startday);

                        // To get correct number of rows
                        $total_indices  = ceil($shifted_day /7) * 7;

                        $is_today = false;

                        for ($i = 0; $i < $total_indices; $i++) 
                        {
                            $current_date = ($i - $startday + 1);
                            $current_full_date = $cMonth."/".$current_date."/".$cYear;
                            // Start new row
                            if(($i % 7) == 0 )
                            {
                                echo '<tr class="date_row">'."\r\n";
                            }   

                            // Check if day appears in current month
                            if($i < $startday || $i > ($maxday + $startday - 1)) 
                            {
                                echo '<td class="calendar_date_empty"></td>';
                            }
                            else 
                            {
                                // I'm sorry if you're trying to fix this ;-;


                                // This day is before the current day. Is Either:
                                // From an old year
                                // From the current year but a past month
                                // The current month and the day is less than today
                                if ($is_old_year || ($is_current_year && $is_old_month) || ($is_current_month && $current_date < $today))
                                {
                                    echo '<td class="calendar_date_passed">'."\r\n";
                                }
                                // It's the current day
                                else if ($is_current_year && $is_current_month && $current_date == $today)
                                {
                                    $is_today = true;
                                    echo '<td class="calendar_date_current">'."\r\n";
                                }
                                else
                                {
                                    echo '<td class="calendar_date_normal">'."\r\n";
                                }
                                echo "<div>"."\r\n";
                                    echo $current_date; 
                                    //echo "<center>";
                                        if ($is_today)
                                        {
                                            echo "<span id=\"today_div\"> Today </span>";
                                            $is_today = false;
                                        }
                                    //echo "</center>";
                                echo "</div>"."\r\n";
                                echo "<div>"."\r\n";
                                for ($event = 0; $event < count($calendar_data); $event++)
                                {
                                    $curEvent = $calendar_data[$event];
                                    $eDate = $curEvent["Date"];
                                    if ($eDate == $current_full_date)
                                    {
                                        $eName = $curEvent["Name"];
                                        $eTime = $curEvent["Time"];
                                        $eLocation = $curEvent["Location"];

                                        $parts = explode(" ", $eName);
                                        $first_word = $parts[0];

                                        echo "<h5>".$eName."</h5>"."\r\n";
                                        echo "<h6>When: ".$eTime."</h6>"."\r\n";
                                        echo "<h6>Where: ".$eLocation."</h6>"."\r\n";

                                        $id_name = '"$("lolz'.$first_word.'").bPopup())"'; 
                                        echo '<a href="Event_page.php?query='.$eDate.$first_word.'">More Info</a>';
                                    }
                                }

                                echo "</div>";

                                echo "</td>";
                            }
                            if(($i % 7) == 6 )
                            {
                                echo "</tr>";   
                            } 
                        }
                    ?>
                </table>
                 -->
        </div>
        <?php include 'footer.php' ?>
    </body>
</html>