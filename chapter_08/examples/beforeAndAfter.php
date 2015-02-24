<?php
// Include the Thumbnail class
require_once('Thumbnail.class.php');

// Instantiate the thumbnail
$tn = new Thumbnail(200, 200);

// Load an image into a string (this could be from a database)
$image = file_get_contents('sample_images/terrier.jpg');

// Load the image data
$tn->loadData($image, 'image/jpeg');

// Build the thumbnail and store as a file
$tn->buildThumb('sample_images/nice_doggie.jpg');
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> Thumbnail Example </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style type="text/css">
      div { float: left; }
    </style>
  </head>
  <body>
    <div>
      <h1>Before...</h1>
      <p><img src="sample_images/terrier.jpg" alt="Original Image" /></p>
    </div>
    <div>
      <h1>After...</h1>
      <p>
        <img src="sample_images/nice_doggie.jpg"
             width="<?php echo ( $tn->getThumbWidth() );?>"
             height="<?php echo ( $tn->getThumbHeight() );?>"
             alt="Resized Image" />
      </p>
    </div>
  </body>
</html>