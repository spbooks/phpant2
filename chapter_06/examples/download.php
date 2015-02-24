<?php
// Specify a file to download
$fileName = 'example.zip';
$mimeType = 'application/zip';
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 5') or
    strpos($_SERVER['HTTP_USER_AGENT'], 'Opera 7'))
{
  $mimeType = 'application/x-download';
}

// Tell the browser it's a file for downloading
header('Content-Disposition: attachment; filename=' . $fileName);
header('Content-Type: ' . $mimeType);
header('Content-Length: ' . filesize($fileName));

// Display the file
readfile($fileName);
?> 
