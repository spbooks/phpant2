<?php
// Load the original image
$image = imagecreatefromjpeg('sample_images/thumb_terrier.jpg');

// Get a color and allocate to the image pallet
$color = imagecolorallocate($image, 68, 68, 68);

// Add the text to the image
imagestring($image, 5, 90, 0, "Abbey '07", $color);

// Send the HTTP content header
header('Content-Type: image/jpg');

// Display the final image
imagejpeg($image);
?>