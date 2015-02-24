<?php
// Open the file handle for reading
$fp = fopen('writeSecureScripts.html', 'rb');

// Loop until the end of the file
while (!feof($fp))
{
  // Get a chunk to the next linefeed
  $chunk = fgets($fp);
  echo $chunk;
}

// Close the file handle!
fclose($fp);
?>
