<?php
// Include the ThumbNail class
require_once('Thumbnail.class.php');

$image_html = '';

// Open the sample_images subdirectory
$dir = dir('sample_images');
// Read through the files looking for images to convert, and add them to a image_html string
while ($image = $dir->read())
{
  // Get the file extension
  $ext = explode('.',$image);
  $size = count($ext);
  // Check that it's a valid file
  if (($ext[$size-1] == 'png' || $ext[$size-1] == 'jpg' || $ext[$size-1] == 'gif')
      && !preg_match('/^thumb_/', $image)
      && $image != '.' && $image != '..')
  {
    // If no thumbnail exists for this image
    if ( !file_exists('sample_images/thumb_'.$image) )
    {
      // Instantiate the thumbnail without scaling small images
      $tn = new Thumbnail(200, 200, true, false);
      // Create the thumbnail
      $tn->loadFile('sample_images/'.$image);
      $tn->buildThumb('sample_images/thumb_'.$image);
    }
    // Add this image to the image_html string
    $image_html .= '<div class="image">' .
        '<a href="sample_images/'.$image.'">' .
        '<img src="sample_images/thumb_'.$image.'">' .
        '</a></div>';
  }
}
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> Thumbnail Example </title>
    <style type="text/css">
      body {
        font-family: Tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
      }
      h1 {
        font-size: 2em;
        color: navy
      }
      div.image {
        float: left;
        width: 200px;
        height: 200px;
        text-align: center;
        border: 5px solid #F2F2F2;
        margin: 5px;
        padding: 5px;
        }
        div.image img {
          border: none;
        }
    </style>
  </head>
  <body>
    <h1>Gallery</h1>
    <?php echo ( $image_html ); ?>
  </body>
</html>