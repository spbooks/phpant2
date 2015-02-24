<?php
// Open the file handle for reading
$fp = fopen('http://www.sitepoint.com/print/758', 'r');

// Loop while the connection is good and not at end of file
while (!feof($fp))
{
  // Get a chunk to the next linefeed
  $chunk = fgets($fp);
  echo $chunk;
}

// Close the file handle!
fclose($fp);
?>
