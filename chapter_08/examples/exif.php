<?php
    // requires PHP exif functions: Your PHP must be compiled in with --enable-exif.
    // Get the exif data
    $exif_data = exif_read_data( 'sample_images/terrier.jpg' );
    echo '<pre>';
    print_r($exif_data);
    echo '</pre>';
?>