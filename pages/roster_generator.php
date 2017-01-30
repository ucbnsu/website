<?php
    ini_set('display_errors', '1');

    // Enum used so it's easier to compare dates
    abstract class TimeCombination 
    {
        const YearYear = 0;
        const YearSem = 1;
        const SemSem = 2;
    }

    $command = $_POST["command"];
    $page = $_POST["page"];

    // To differentiate data for yosakoi, NiCE, etc
    $data_key = $page . 'semester_data';
    // Use a session to reduce repeated calls to the spreadsheet
    session_set_cookie_params(60,"/");
    session_start();

    if (array_key_exists($data_key, $_SESSION)) {
        $semester_data = $_SESSION[$data_key];
    } else {
        // Read from the Yosakoi Roster Spreadsheet
        $spreadsheet_url=$_POST["url"];
        if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $roster_data[]=$data;
                }
            fclose($handle);
        } else {
            echo "Problem Reading Spreadsheet";
            die("Problem reading csv");
        }

        // Move each person into specific semesters
        $semester_data = array();
        foreach ($roster_data as $member) {
            $semester = $member[0];
            $name = $member[1];
            $position = $member[2];
            // TODO Notify people if something goes wrong

            // Only add if the name exists
            if (!empty($name)) {
                if (!array_key_exists($semester, $semester_data)) { // Add new semester if it doensn't exist
                    $semester_data[$semester] = array();
                }
                array_push($semester_data[$semester], array($name, $position)); // Add member into it
            }
        }

        // Sort semesters with most recent first, by placing year first, then Fall before Spring
        function sort_semesters($a, $b) {
            $a = preg_replace('/(\s)+/', ' ', $a); // Remove extra whitespace
            $b = preg_replace('/(\s)+/', ' ', $b);
            $a = strtolower($a); // Lowercase for conformity
            $b = strtolower($b);

            if ($a == $b) {
                return 0;
            }

            $a_split = explode(" ", $a);
            $b_split = explode(" ", $b);

            $a_type = 0;
            $b_type = 0;
            $time_type = TimeCombination::YearYear;

            // Figure what type of dates we are comparing, assume Semester I.E. 2015 Fall
            if (count($a_split) == 3) { // I.E. 2015 - 2016
                $a_type = 1;
            }
            if (count($b_split) == 3) { // I.E. 2015 - 2016
                $b_type = 1;
            }

            // Probably unnecessary at this time 
            if ($a_type == 1 && $b_type == 1)
            {
                $time_type = TimeCombination::YearYear;
            } else if ($a_type == 0 && $b_type == 0) {
                $time_type = TimeCombination::SemSem;
            } else {
                $time_type = TimeCombination::YearSem;
            }

            if ($time_type == TimeCombination::SemSem) // Comparing years and semesters
            {
                list($a_sem, $a_year) = $a_split;
                list($b_sem, $b_year) = $b_split;
                // Convert years to ints
                $a_year = (int) $a_year;    
                $b_year = (int) $b_year;

                if ($a_year == $b_year) { // If years are same compare semester
                    if ($a_sem == $b_sem) {
                        return 0;
                    } else {
                        if ($a_sem == "fall") { // ASSUMPTION: If they aren't the same semester, one must be fall 
                            return 1;
                        } else {
                            return -1;
                        }
                    }
                } else {
                    return ($a_year < $b_year) ? -1 : 1;
                }
            } else if ($time_type == TimeCombination::YearYear) { // Compare the end years to see which one is more recent
                list($a_syear, $_, $a_eyear) = $a_split;
                list($b_syear, $_, $b_eyear) = $b_split;

                // Convert end years to int and compare them
                $a_eyear = (int) $a_eyear;    
                $b_eyear = (int) $b_eyear;

                return ($a_eyear < $b_eyear) ? -1 : 1;
            } else { // Comparing year range to semester. Assuming a year goes from Fall -> Spring
                if ($a_type == 0) // A is semester
                {
                    list($a_sem, $a_syear) = $a_split;
                    list($b_syear, $_, $b_eyear) = $b_split;

                    if ($a_syear == $b_syear) {
                        return -1;
                    } else if ($a_syear < $b_syear) {
                        return -1;
                    } else if ($a_syear > $b_syear) {
                        return 1;
                    }

                } else { // B is semester
                    list($b_sem, $b_syear) = $b_split;
                    list($a_syear, $_, $a_eyear) = $a_split;

                    if ($a_syear == $b_syear) {
                        return 1;
                    } else if ($a_syear < $b_syear) {
                        return -1;
                    } else if ($a_syear > $b_syear) {
                        return 1;
                    }
                }
            }
        }

        // Sort the semesters
        $was_sort_success = uksort($semester_data, "sort_semesters");
        $_SESSION[$data_key] = $semester_data;
    }

    if ($command == "fill_select") {
        // Updates the select so that all available semesters can be chosen
        $semesters = array_reverse(array_keys($semester_data));
        foreach ($semesters as $s) {
            echo "<option value='$s'>$s</option>";
        }
    } else if ($command == "update_roster") {
        // Updates the roster by creating a table and filling it with the members
        $selected = $_POST["selected"];
        if ($page == "core")
        {
            echo "<h2> $selected Core </h2>";
        } else {
            echo "<h2> $selected Roster </h2>";
        }
    
        // On Selection, display the appropriate roster
        $cur_query = $selected;

        // Mark each member as either a director or member and display at the end                    
        $directors = array();
        $members = array();

        foreach ($semester_data[$cur_query] as $m) {
            list($position, $name) = $m;
            $t_position = strtolower($position);
            if ($t_position == "member") {
                array_push($members, $name);
            } else {
                array_push($directors, $m);
            }
        }

        sort($members); // Sort in alphabetical order

        echo "<table class='director_table'>"; // start a table tag in the HTML

        // Display directors
        foreach ($directors as $d) { // Display directors
            list($position, $name) = $d;
            echo '<tr class="director_row">';
            echo '<td class="director_title">',$position,'</td>';
            echo '<td class="director_name">',$name,'</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '<h3> </h3>';
        echo '<table class="director_table">';

        // Display members
        foreach ($members as $name) {
            echo '<tr class="director_row">';
            echo '<td class="director_title">Member</td>';
            echo '<td class="director_name">', $name, '</td>';
            echo '</tr>';
        }

        echo "</table>"; //Close the table in HTML
    } else {
        echo "Unknown command";
        die("Unknown Command");
    }

?>