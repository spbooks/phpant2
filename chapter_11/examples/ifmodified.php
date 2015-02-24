<?php
$file = 'ifmodified.txt';

// A randomizer...
$random = array (0,1,1);
shuffle($random);

// Randomly update the file
if ( $random[0] == 0 ) {
  $fp = fopen($file, 'w');
  fwrite($fp, 'x');
  fclose($fp);
}

// Get the time the file was last modified
//$lastModified = filemtime($cache->_file);

$lastModified = filemtime($file);
// Issue an HTTP last modified header
header ( 'Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');

// Get client headers - Apache only
$request = getallheaders();

if (isset($request['If-Modified-Since']))
{
  // Split the If-Modified-Since (Netscape < v6 sends this incorrectly)
  $modifiedSince = explode(';', $request['If-Modified-Since']);

  // Turn the client request If-Modified-Since into a timestamp
  $modifiedSince = strtotime($modifiedSince[0]);
}
else
{
  // Set modified since to 0
  $modifiedSince = 0;
}

// Compare the time the content was last modified with what the client sent
if ($lastModified <= $modifiedSince)
{
  // Save on some bandwidth!
  header('HTTP/1.1 304 Not Modified');
  exit();
}

// Display the time the page was last modified
echo ( 'The GMT is now '.gmdate('H:i:s').'<br />' );
echo ( '<a href="'.$_SERVER['PHP_SELF'].'">View Again</a><br />' );
?>