<?php
    ini_set('display_errors', '1');
    $command = $_POST["command"];
    session_set_cookie_params(60,"/");
    session_start();
    if (array_key_exists('semester_data', $_SESSION)) {
        $semester_data = $_SESSION['semester_data'];
    } else {
        # Read from the Yosakoi Roster Spreadsheet
        $spreadsheet_url="https://docs.google.com/spreadsheets/d/1UZfuQfWEczNBH_V7uEP33vmZ3tUpKfvBqh4k2sPmNTU/pub?output=csv";
        if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $roster_data[]=$data;
                }
            fclose($handle);
        } else {
            echo "Problem Reading Spreadsheet";
            die("Problem reading csv");
        }

        # Move each person into specific semesters
        $semester_data = array();
        foreach ($roster_data as $member) {
            $semester = $member[0];
            $name = $member[1];
            $position = $member[2];
            # TODO Notify people if something goes wrong

            # Only add if the name exists
            if (!empty($name)) {
                if (!array_key_exists($semester, $semester_data)) { # Add new semester if it doensn't exist
                    $semester_data[$semester] = array();
                }
                array_push($semester_data[$semester], array($name, $position)); # Add member into it
            }
        }

        # Sort semesters with most recent first, by placing year first, then Fall before Spring
        function sort_semesters($a, $b) {
            $a = preg_replace('/(\s)+/', ' ', $a); # Remove extra whitespace
            $b = preg_replace('/(\s)+/', ' ', $b);
            $a = strtolower($a); # Lowercase for conformity
            $b = strtolower($b);

            if ($a == $b) {
                return 0;
            }
            
            $a_split = explode(" ", $a);
            $b_split = explode(" ", $b);
            list($a_sem, $a_year) = $a_split;
            list($b_sem, $b_year) = $b_split;
            # Convert years to ints
            $a_year = (int) $a_year;    
            $b_year = (int) $b_year;

            if ($a_year == $b_year) { # If years are same compare semester
                if ($a_sem == $b_sem) {
                    return 0;
                } else {
                    if ($a_sem == "fall") { # If they aren't the same semester, one must be fall
                        return 1;
                    } else {
                        return -1;
                    }
                }
            } else {
                return ($a_year < $b_year) ? -1 : 1;
            }
        }

        # Sort the semesters
        $was_sort_success = uksort($semester_data, "sort_semesters");
        $_SESSION['semester_data'] = $semester_data;
    }

    if ($command == "fill_select") {
        # Updates the select so that all available semesters can be chosen
        $semesters = array_reverse(array_keys($semester_data));
        foreach ($semesters as $s) {
            list($semester, $year) = explode(" ", $s);
            echo "<option value='$semester:$year'>$semester $year</option>";
        }
    } else if ($command == "update_roster") {
        # Updates the roster by creating a table and filling it with the members
        $requested_year = $_POST["year"];
        $requested_semester = $_POST["semester"];
        echo "<h2> $requested_semester $requested_year Roster </h2>";
    
        # On Selection, display the appropriate roster
        $cur_query = $requested_semester . " " . $requested_year;

        # Mark each member as either a director or member and display at the end                    
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

        sort($members); # Sort in alphabetical order

        echo "<table class='director_table'>"; // start a table tag in the HTML

        # Display directors
        foreach ($directors as $d) { # Display directors
            list($position, $name) = $d;
            echo '<tr class="director_row">';
            echo '<td class="director_title">',$position,'</td>';
            echo '<td class="director_name">',$name,'</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '<h3> </h3>';
        echo '<table class="director_table">';

        # Display members
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