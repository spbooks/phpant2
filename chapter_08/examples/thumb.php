<?php
// Specify source image
$sourceImage = 'sample_images/terrier.jpg';

// Specify thumbnail height and width
$thumbWidth = 200;
$thumbHeight = 200;

// Load the source image
$original = imagecreatefromjpeg($sourceImage);

// Get the size of the original
$dims = getimagesize($sourceImage);

// Create a blank thumbnail (note slightly reduced height)
$thumb = imagecreatetruecolor($thumbWidth,$thumbHeight);

// Copy a resized version of the original onto the thumbnail
imagecopyresampled( $thumb, $original, 0, 0, 0, 0,
    $thumbWidth, $thumbHeight, $dims[0], $dims[1] );

// Send the content header
header( "Content-type: image/jpeg" );

// Display the image
imagejpeg( $thumb );
?>