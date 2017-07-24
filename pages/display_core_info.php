<?php

// Read from the Spreadsheet
$spreadsheet_url="https://docs.google.com/spreadsheets/d/1wf_5_BI2KMDn6BAJKgX6k5Tu5tRahZElR_-gJtRgI60/pub?gid=0&single=true&output=csv";

if(!ini_set('default_socket_timeout',    15)) echo "<!-- unable to change socket timeout -->";

if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ","))) {
            $spreadsheet_data[]=$data;
    }
    fclose($handle);
} else {
    die("Problem reading csv");
}

// Get the column titles from the first row of the sheet
$member_start_index = 0;
while ($spreadsheet_data[$member_start_index][0] == FALSE) {
    $member_start_index++;
}

$fact_titles = $spreadsheet_data[$member_start_index];

// Get index of certain fields for later
for ($i = 0; $i < count($fact_titles); $i++) {
    if (strtolower($fact_titles[$i]) == "name") {
        $name_index = $i;
    } else if (strtolower($fact_titles[$i]) == "image") {
        $img_index = $i;
    } else if (strtolower($fact_titles[$i]) == "position") {
        $position_index = $i;
    }
}

// Making an assumption about the indices uh oh
$fact_start_index = max($name_index, $position_index, $img_index) + 1;
$member_start_index++;

// Display the current officers 
$output = '';
for ($i = $member_start_index; $i < count($spreadsheet_data); $i++) {
    $person = $spreadsheet_data[$i];
    
    // If we find the end of the current core
    if (strpos(strtolower($person[0]), "end current") === 0) {
        $old_core_start_index = $i;
        break;
    }

    $output .= '<div class="core_member">';
    $output .= '<table class="table-hover">';
    $output .= '<tbody><tr>';
    
    // If we have a link to the picture display it, otherwise use a filler
    $output .= '<td class="core_member_img_td">';

    // Parse image URL for the file ID which we then use to display the image
    $img_url = $person[$img_index];
    $img_components = parse_url($img_url);
    $img_found = FALSE;

    // If we can parse the URL, get the ID
    if ($img_url != FALSE && $img_components = parse_url($img_url)) 
    {
        $path = $img_components["path"];
        $file_compare = "/file/d/";
        $start_pos = strpos($path, $file_compare);
        
        if (array_key_exists("scheme", $img_components)) 
        {
            if ($path == "/open") // By using "Get Shareable Link", ID is in query
            {
                $query = $img_components["query"];
                $start_pos = strpos($query, "id=") + 3;
                $img_id = substr($query, $start_pos);

            } else if ($start_pos !== NULL) { // By using "Share+", ID is in the path
                $end_length = strpos($path, "/view") - strlen($file_compare);
                if ($end_length !== FALSE){
                    $img_id = substr($path, $start_pos + strlen($file_compare), $end_length);
                }
            }
        } else { // Only if it's the direct file ID
            $img_id = $path;
        }

        // TODO: Very little checking if the fileid is valid or not
        $img_found = $img_id;
        $output .= '<img src="http://drive.google.com/uc?export=view&id=' . $img_id . '" alt="">';

        // Reset image id in case future ones are missing
        $img_id = '';
    }

    // Display the filler image if something goes wrong or if there is no image
    if (!$img_found) {
        $output .= '<img src="/pictures/core_filler.png" alt="">';
    }
    $output .= '</td></tr><tr>';

    $output .= '<td class="core_member_data_td">';
    $output .= '<table class="core_data"><tbody>';

    // Display name
    $output .= '<tr class="core_title">';
    $output .= '<td colspan="2">' . $person[$name_index] . '</td>';
    $output .= '</tr>';

    // Display Position
    $output .= '<tr class="core_title">';
    $output .= '<td colspan="2">' . $person[$position_index] . '</td>';
    $output .= '</tr>';

    // Display facts like majors, minor, year, etc.
    for ($j = $fact_start_index; $j < count($person); $j++) {
        $fact = $person[$j];

        // Ignore the field if they're missing a value
        if ($fact != FALSE) {
            $output .= '<tr>';
            $output .= '<td class="core_data_name">' . $fact_titles[$j] . '</td>';

            // Give emails different formatting
            if (strpos($fact, '@'))
            {
                $output .= '<td class="core_data_information"><a class="email" href="mailto:' . $fact .'">' . $fact . '</a></td>';
            } else {
                $output .=  '<td class="core_data_information">' . $fact . '</td>';
            }
            $output .= '</tr>';
        }
    }

    // Close tags
    $output .= '</tbody></table>';
    $output .= '</td>';
    $output .= '</tr>';
    $output .= '</tbody></table>';
    $output .= '</div>';
}

// Output the html
echo $output;



