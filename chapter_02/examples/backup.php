<?php
// Include the MySQLDump class
require_once 'MySQLDump.class.php';

$dbUser = 'user';               // db User
$dbPass = 'secret';             // db User Password
$dbName = 'world';              // db name
$dest   = '/home/user/backups'; // Path to directory
$zip    = 'bz2';               // ZIP utility to compress with

// Instantiate MySQLDump
$mysqlDump = new MySQLDump($dbUser, $dbPass, $dbName, $dest, $zip);

// Perform the backup
$mysqlDump->backup();
?>
