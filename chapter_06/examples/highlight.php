<?php
// Define an array of allowed files - VERY IMPORTANT!
$allowed = array('fileInfo.php', 
                'fileGetFunc.php', 
                'fileHandle.php', 
                'fileHandle2.php');

// If it's an allowed file, display it.
if (isset($_GET['view']) && in_array($_GET['view'], $allowed))
{
  highlight_file($_GET['view']);
}
else
{
  // Specify current directory
  $location = './';

  // Open current directory
  $dir = dir($location);

  // Loop through the directory
  while ($entry = $dir->read())
  {

    // Show allowed files only
    if (in_array($entry, $allowed))
    {
      echo '<a href="' . $_SERVER['PHP_SELF'] .
          '?view=' . $entry . '">' . $entry . "</a><br />\n";
    }
  }

  // Close it again!
  $dir->close();
}
?>
