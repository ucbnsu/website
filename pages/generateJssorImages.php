<?php
function test_image_path($file_name) {
	return preg_match("/.+(\.png|\.jpg|\.gif)/", $file_name);
}


function generate_jssor_images($dir) {
	// Retrieve files in given directory
	$files = scandir($dir);
	// Filter out all files that don't end in .png, .jpg or .gif
	$pictures = array_filter($files, "test_image_path");
	foreach ($pictures as $pic_name) {
		echo '<div><img u="image" src="' . $dir . $pic_name . '" /></div>';
	}
}

