<?php
// Start a session
session_start();

// Check to see if $viewImages is registered
if (isset($_SESSION['viewImages']) && $_SESSION['viewImages'] == true)
{
  // An array of available images
  $images = array(
      'golden_retriever.jpg',
      'husky.jpg'
      );

  // If $_GET['img'] is set and in available...
  if (isset($_GET['img']) && in_array($_GET['img'],$images))
  {
    // Get the image information
    $dims = getimagesize('sample_images/'.$_GET['img']);

    // Send the correct HTTP headers
    header('Content-Disposition: inline; filename=' . $_GET['img']);
    header('Content-Type: '.$dims['mime']); # PHP 4.3.x +
    header('Content-Length: ' . filesize('sample_images/'.$_GET['img']));

    // Display the image
    readfile('sample_images/'.$_GET['img']);
  }
  else
  {
    header("HTTP/1.1 404 Not Found"); 
    header("Content-Type: text/plain" );
    echo "Invalid image or no image specified\n";
  }
}
else
{
  header("HTTP/1.1 404 Not Found"); 
  header("Content-Type: text/plain" );
  echo "This image is protected from hotlinking\n";
}
?>