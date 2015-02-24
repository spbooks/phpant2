<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

$country = 'A';
// try to make the connection to the database
try
{
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
  // use LIKE in the SQL
  $sql = 'Select * from city where CountryCode LIKE :country';
  $stmt = $dbh->prepare($sql);
  // add the wildcard to the param
  $country = $country.'%';
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);
  $stmt->execute();
  while ($row = $stmt->fetchObject()) {
    print $row->Name . "\t";
    print $row->CountryCode . "\t";
    print $row->Population . "\n";
  }
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
