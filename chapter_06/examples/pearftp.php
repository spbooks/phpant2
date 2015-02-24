<?php
// Set execution time limit to infinite
set_time_limit(0);

// Include PEAR::Net_FTP
require_once 'NET/FTP.php';

// Define server, username and password
$ftpServer = 'localhost';
$ftpUser   = 'anonymous';
$ftpPass   = 'user@domain.com';

// Local Directory to place files
$localDir = 'import/';

// Remote Directory to fetch files from
$remoteDir = '/';

// Instantiate Net_FTP
$ftp = new Net_FTP();

// Set host and login details
$ftp->setHostname($ftpServer);
$ftp->setUsername($ftpUser);
$ftp->setPassword($ftpPass);

// Connect and login
$ftp->connect();
$ftp->login();

// Specify the extensions file
$ftp->getExtensionsFile('extensions.ini');

// Get the remote directory contents
if ($ftp->getRecursive($remoteDir, $localDir))
{
  echo 'Files transfered successfully';
}
else
{
  echo 'Transfer failed';
}
?>
