<?php
// Include the MySQLDump class
require_once 'AbstractMySQLDump.class.php';

try
{
  $dbUser = 'user';               // db User
  $dbPass = 'secret';             // db User Password
  $dbName = 'world';              // db name
  $dest   = 'c:\backups'; // Path to directory
  $zip    = 'none';               // ZIP utility to compress with
  
  // Instantiate MySQLDump
  $mysqlDump = MySQLDump::factory($dbUser, $dbPass, $dbName, $dest, $zip);
  
  // Perform the backup
  $mysqlDump->backup();
}
catch (Exception $e)
{
  echo $e->getMessage();
}
?>
