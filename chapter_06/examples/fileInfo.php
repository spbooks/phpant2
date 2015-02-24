<?php
// Function to convert a size to bytes to large units
function fileSizeUnit($size)
{
  if ($size >= 1073741824)
  {
    $size = number_format(($size / 1073741824), 2);
    $unit = 'GB';
  }
  else if ($size >= 1048576)
  {
    $size = number_format(($size / 1048576), 2);
    $unit = 'MB';
  }
  else if ($size >= 1024)
  {
    $size = number_format(($size / 1024), 2);
    $unit = 'KB';
  }
  else if ($size >= 0)
  {
    $unit = 'B';
  }
  else
  {
    $size = '0';
    $unit = 'B';
  }
  return array('size' => $size, 'unit' => $unit);
}

$file = 'writeSecureScripts.html';

// set the default timezone to use. Available since PHP 5.1
// needed otherwise date() throws an E_STRICT error in v5.2
date_default_timezone_set('UTC');

// Does the file exist
if (file_exists($file))
{
  echo 'Yep: ' . $file . ' exists.<br />';
}
else
{
  die('Where has: ' . $file . ' gone!<br />');
}

// Is it a file? Could be is_dir() for directory
if (is_file($file))
{
  echo $file . ' is a file<br />';
}

// Is it readable
if (is_readable($file))
{
  echo $file . ' can be read<br />';
}

// Is it writable
if (is_writable($file))
{
  echo $file . ' can be written to<br />';
}

// When was it last modified?
$modified = date("D d M g:i:s", filemtime($file));
                                
echo $file . ' last modifed at ' . $modified . '<br />';

// When was it last accessed?
$accessed = date("D d M g:i:s", fileatime($file));
echo $file . ' last accessed at ' . $accessed . '<br />';


// Use a more convenient file size
$size = fileSizeUnit(filesize($file));

// Display the file size
echo 'It\'s ' . $size['size'] . ' ' . $size['unit'] .
     ' in size.<br />';
  
?>
