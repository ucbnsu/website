#!/usr/bin/php
<?php
/* Script to update what we store in database:
 * gallery
 * events
 */

include '../pages/nsu_util.php';

createGalleryTable();
fetchGalleryAlbums();
?>
