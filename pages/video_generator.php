<?php
    # Read from the Spreadsheet
    $spreadsheet_url=$_POST["url"];
    if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
        while (($s_data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $data[]=$s_data;
            }
        fclose($handle);
    } else {
        echo "Problem Reading Spreadsheet";
        die("Problem reading csv");
    }

    if (!empty($data)) {
        echo "<h2> Videos </h2>";

        foreach ($data as $video) {
            $title = $video[0];
            $link = $video[1];

            # Output title
            echo "<h2> $title </h2>";

            # Determine if it's a playlist or video
            $query = parse_url($link, PHP_URL_QUERY);
            parse_str($query, $params);

            if (array_key_exists("list", $params)) { # Playlist link
                $code = $params['list'];
                echo "<iframe class='video_group' src='https://www.youtube.com/embed/videoseries?list=$code' frameborder='0' allowfullscreen></iframe>";
            } else if (array_key_exists("v", $params)) { # Video link
                $code = $params['v'];
                echo "<iframe class='video_group' src='https://www.youtube.com/embed/$code' frameborder='0' allowfullscreen></iframe>";
            } else {
                echo "Video Link Invalid";
            }
        }
    }


?>