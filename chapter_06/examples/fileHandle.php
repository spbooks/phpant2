<?php
// Variable to store the location of the file
$location = 'writeSecureScripts.html';

// Open the file handle for reading
$fp = fopen($location, 'rb');

// Read the complete file into a string variable
$file_contents = fread($fp, filesize($location));

// Close the file handle
fclose($fp);

echo $file_contents;
?>
