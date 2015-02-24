<?php
// Open the current directory
$location = './';

// Open current directory
$dp = opendir($location);

// Loop through the directory
while ($entry = readdir($dp))
{
  // If $entry is a directory...
  if (is_dir($location . $entry))
  {
    echo '[Dir] ' . $entry . '<br />';
  // If $entry is a file...
  }
  else if (is_file($location . $entry))
  {
    echo '[File] ' . $entry . '<br />';
  }
}

// Close it again!
closedir($dp);
?>
