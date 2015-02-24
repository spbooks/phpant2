<?php
// Set time limit to infinite
set_time_limit(0);

// Define server and target directory
$ftpServer = 'localhost';
$targetDir = '/';

// Connect to server
if (!$fp = ftp_connect($ftpServer, 21, 30))
{
  die('Connection failed');
}

// Login anonymously
if (!ftp_login($fp, 'anonymous', 'user@domain.com'))
{
  die('Login failed');
}

// Change directory
if (!ftp_chdir($fp, $targetDir))
{
  die ('Unable to change directory to: ' . $targetDir);
}

// Display the remote directory location
echo "<pre>Current Directory:" . ftp_pwd($fp) .
     "\n\n";

echo "Files Available:\n";

// Get a list of files on the server
$files = ftp_nlist($fp, '/');

// Display the files
foreach ($files as $file)
{
  echo $file . "\n";
}
echo '</pre>';
?>
