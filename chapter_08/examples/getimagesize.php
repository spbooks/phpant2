<?php
// Specify source image
$sourceImage = 'sample_images/terrier.jpg';

// Get the size of the original
$dims = getimagesize($sourceImage);

echo ( '<pre>' );
print_r($dims);
echo ( '</pre>' );
?>
