<?php
// Include the Thumbnail class
require_once('Thumbnail.class.php');

// Instantiate the thumbnail
$tn = new Thumbnail(200,200);

// Load the image from a file
$tn->loadFile('sample_images/terrier.jpg');

// Send the HTTP Content-Type header
header ('Content-Type: '.$tn->getMime());

// Display the thumbnail
$tn->buildThumb();
?>