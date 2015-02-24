<?php
// Load the original image
$image = imagecreatefromjpeg('sample_images/thumb_terrier.jpg');

// Get image width
$iWidth = imagesx($image);

// Get the watermark image
$watermark = imagecreatefrompng('sample_images/sitepoint_watermark.png');

// Get the height and width
$wmWidth = imagesx($watermark);
$wmHeight = imagesy($watermark);

// Find the far right position
$xPos = $iWidth - $wmWidth;

// Copy the watermark to the top right of original image
imagecopymerge($image, $watermark, $xPos, 0, 0, 0, $wmWidth, $wmHeight, 50); 

// Send the HTTP content header
header('Content-Type: image/jpg');

// Display the final image
imagepng($image);
?>