<?php
// If a cached version exists use it...
if (file_exists('./cache/page.cache'))
{
  // Read and display the file
  readfile('./cache/page.cache');
  exit();
}

// Start buffering the output
ob_start();

// Display some HTML
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Cached Page</title>
  </head>
  <body>
    This page was cached with PHP's
    <a href="http://www.php.net/outcontrol">Output Control Functions</a>
  </body>
</html>
<?php
// Get the contents of the buffer
$buffer = ob_get_contents();

// Stop buffering and display the buffer
ob_end_flush();

// Write a cache file from the contents
$fp = fopen('./cache/page.cache','w');
fwrite($fp,$buffer);
fclose($fp);
?>