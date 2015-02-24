<?php
// make the DSN
$dsn = 'pgsql:host=localhost port=5432 dbname=world user=user ';
$dsn .= 'password=secret';

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
