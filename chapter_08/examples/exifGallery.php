<?php
// requires PHP exif functions: Your PHP must be compiled in with --enable-exif.

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
    // JPG image?
    if($ext[$size-1] == 'jpg')
    {
      // Get Exif data
      $exif_data = exif_read_data( 'sample_images/' . $image );
    }
    else
    {
      // Reset array (prevents images without Exif data displaying data for the previous image)
      $exif_data = array();
    }

    // Start default image output
    $image_html .= '<div class="image">';
    $image_html .= '<div class="thumbnail">';
    $image_html .= '<a href="sample_images/' . $image . '">';
    $image_html .= '<img src="sample_images/thumb_' . $image . '">';
    $image_html .= '</a></div>';
    $image_html .= '<div class="exifdata">';

    // Add photo date, if set
    if(isset($exif_data['FileDateTime']))
    {
      $image_html .= '<p>Date: ' .
          date( 'jS F Y',  $exif_data['FileDateTime'] ) . '</p>';
    }

    // Add camera make, if set
    if(isset( $exif_data['Make']))
    {
      $image_html .= '<p>Taken with: ' . $exif_data['Make'];

      // Also add camera model, if set
      if(isset($exif_data['Model']))
      {
          $image_html .= ' ' . $exif_data['Model'];
      }
      $image_html .= '</p>';
    }
    $image_html .= '</div></div>';
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
        height: 260px;
        text-align: center;
        border: 5px solid #F2F2F2;
        margin: 5px;
        padding: 5px;
        position: relative;
      }
      div.image img {
        border: none;
      }
      div.thumbnail {
        width: 200px;
        height: 200px;
      }
      div.exifdata {
        padding: 5px;
        background-color: #F2F2F2;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 200px;
        height: 50px;
      }
    </style>
  </head>
  <body>
    <h1>Gallery</h1>
    <?php echo ( $image_html ); ?>
  </body>
</html>