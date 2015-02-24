<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

$country = 'USA';
// try to make the connection to the database
try
{
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT COUNT(*) FROM city WHERE CountryCode =:country';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);
  $result = $stmt->execute();
  echo 'There are ', $stmt->fetchColumn(), ' rows returned.';
} 
// if there is a problem we can handle it here
catch (PDOException $e)
{
  echo 'PDO Exception Caught.  ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo 'Error: ' . $e->getMessage();
}
?>
