<?php
  /**
   * Writes a cache file
   * @param string contents of the buffer
   * @param string filename to use when creating cache file
   * @return void
   */
  function writeCache($content, $filename)
  {
    $fp = fopen('./cache/' . $filename, 'w');
    fwrite($fp, $content);
    fclose($fp);
  }

  /**
   * Checks for cache files
   * @param string filename of cache file to check for
   * @param int maximum age of the file in seconds
   * @return mixed either the contents of the cache or false
   */
  function readCache($filename, $expiry)
  {
    if (file_exists('./cache/' . $filename))
    {
      if ((time() - $expiry) > filemtime('./cache/' . $filename))
      {
        return false;
      }
      $cache = file('./cache/' . $filename);
      return implode('', $cache);
    }
    return false;
  }

  // Start buffering the output
  ob_start();

  // Handle the page header
  if (!$header = readCache('header.cache', 604800))
  {
      // Display the header
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Chunked Cached Page</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
  </head>
  <body>
    <p>The header time is now: <?php echo date('H:i:s'); ?></p>
<?php
    $header = ob_get_contents();
    ob_clean();
    writeCache($header,'header.cache');
  }

  // Handle body of the page
  if (!$body = readCache('body.cache', 5))
  {
    echo 'The body time is now: ' . date('H:i:s') . '<br />';
    $body = ob_get_contents();
    ob_clean();
    writeCache($body, 'body.cache');
  }

  // Handle the footer of the page
  if (!$footer = readCache('footer.cache', 604800)) {
?>
    <p>The footer time is now: <?php echo date('H:i:s'); ?></p>
  </body>
</html>
<?php
    $footer = ob_get_contents();
    ob_clean();
    writeCache($footer, 'footer.cache');
  }
  // Stop buffering
  ob_end_clean();

  // Display the contents of the page
  echo $header . $body . $footer;
?>