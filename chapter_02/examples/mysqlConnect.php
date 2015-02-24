<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

// try to make the connection to the database
try
{
  $dbh = new PDO($dsn, $user, $password);
} 
// if there is a problem we can handle it here
catch (PDOException $e)
{
  echo 'Connection failed: ' . $e->getMessage();
}
?>
