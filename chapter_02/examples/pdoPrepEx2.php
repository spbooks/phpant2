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
  $sql = 'Select * from city where CountryCode =:country';
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);
  $stmt->execute();
  while ($row = $stmt->fetchObject())
  {
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
