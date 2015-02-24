<?php
// Specify current directory
$location = './';

// Open current directory
$dir = dir($location);

// Loop through the directory
while ($entry = $dir->read())
{
  // If $entry is a directory...
  if (is_dir($location . $entry))
  {
    echo '[Dir] ' . $entry . '<br />';
  }
  // If $entry is a file...
  else if (is_file($location . $entry))
  {
    echo '[File] ' . $entry . '<br />';
  }
}

// Close it again!
$dir->close();
?>
