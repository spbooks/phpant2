<?php
  // Include the PEAR::Cache_Lite Output class
  require_once 'Cache/Lite/Output.php';

  // Define options for Cache_Lite
  $options = array(
    'cacheDir'        => './cache/',
    'writeControl'    => true,
    'readControl'     => true,
    'fileNameProtection' => false,
    'readControlType' => 'md5'
  );

  // Instantiate Cache_Lite_Output
  $cache = new Cache_Lite_Output($options);

  // Set lifetime for this "chunk"
  $cache->setLifeTime(604800);

  // Start the cache with an id and group for this chunk
  if (!$cache->start('header', 'Static')) {
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>PEAR::Cache_Lite example</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
</head>
<body>
  <h2>PEAR::Cache_Lite example</h2>
  <p>The header time is now: <?php echo date('H:i:s'); ?></p>
<?php
    // Stop and write the cache
    $cache->end();
  }

  $cache->setLifeTime(5);
  if (!$cache->start('body', 'Dynamic')) {
    echo 'The body time is now: ' . date('H:i:s') . '<br />';
    $cache->end();
  }

  $cache->setLifeTime(604800);
  if (!$cache->start('footer', 'Static')) {
?>
    <p>The footer time is now: <?php echo date('H:i:s'); ?></p>
  </body>
</html>
<?php
    $cache->end();
  }
?>