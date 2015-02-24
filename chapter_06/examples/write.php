<?php
// Fetch a file into an array
$lines = file('writeSecureScripts.html');

// Open file for writing (create if doesn't exist)
$fp = fopen('writeSecureScripts.txt', 'w');

// Loop through lines of original
foreach ($lines as $line) {
  // Strip out HTML
  $line = strip_tags($line);
  // Write the line
  fwrite($fp, $line);
}

fclose($fp);
 
// Display the new file
echo '<pre>';
echo file_get_contents('writeSecureScripts.txt');
echo '</pre>';
?>
