<head>
	<?php include 'head.php'; ?>
</head>
<body>
	<?php include 'header.php'; ?>
	<div class="container">
	<?php
		include 'Calendar_data.php';

		$pageEvent = null;
		$param = $_GET['query'];
		for ($event = 0; $event < count($calendar_data); $event++)
    	{
    		$curEvent = $calendar_data[$event];

			$eName = $curEvent["Name"];
    		$parts = explode(" ", $eName);
    		$first_word = $parts[0];
            $date = $curEvent["Date"];
            $dataQuery = $date . $first_word;

    		if ($dataQuery == $param)
    		{
    			$pageEvent = $curEvent;
    		}
    	}
    	echo '<h2>';
    		echo $pageEvent['Name'];
    	echo '</h2>';
    	echo '<h3>';
    		echo "Time: ". $pageEvent['Time'];
    	echo '</h3>';
    	echo '<h3>';
    		echo "Location: ". $pageEvent['Location'];
    	echo '</h3>';
    	echo '<hr>';
    	if (array_key_exists('Headline', $pageEvent))
    	{	
    		echo '<h3>';
    			echo $pageEvent['Headline'];
    		echo '</h3>';
    	}
        if (array_key_exists('facebook_link', $pageEvent) && !empty($pageEvent['facebook_link']))
        {
            echo '<a style="color: blue;" href="';
            echo $pageEvent['facebook_link'];
            echo '"> Facebook Link Here! </a>';
        }
    	echo '<p>';
    		echo $pageEvent['Description'];
    	echo '</p>';
    	if (array_key_exists("Description2", $pageEvent))
    	{
    		echo '<p>';
    			echo $pageEvent['Description2'];
    		echo '</p>';
    	}
	?>
	</div>
	<?php include 'footer.php'; ?>
</body>
