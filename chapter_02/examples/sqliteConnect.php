<?php
// make the DSN
$dsn = 'sqlite2:"C:\sqlite\test.db"';

// try to make the connection to the database
try
{
  $dbh = new PDO($dsn);
} 
// if there is a problem we can handle it here
catch (PDOException $e)
{
  echo 'Connection failed: ' . $e->getMessage();
}
?>
