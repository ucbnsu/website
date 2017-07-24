#!/usr/bin/php
<?php
/* Script to update what we store in database:
 * gallery
 * events
 */
$WEBPATH = '/Users/rayne/NSU/website';
chdir( $WEBPATH . '/pages');

include 'nsu_util.php';

createEventsTable();
fetchEvents();

createGalleryTable();
fetchGalleryAlbums();
?>
