<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

$name = 'Dededo';
$country = 'GU';
$district = 'Guam';
$population = 42980;  // according to the 2000 US census
try
{   
  $dbh = new PDO($dsn, $user, $password);
  // set the error mode to exception 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);  
  $sql = 'INSERT INTO city (Name, 
                            CountryCode, 
                            District, 
                            Population) 
                      VALUES (:name, 
                              :country, 
                              :district, 
                              :pop)';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':country', $country);
  $stmt->bindParam(':district', $district);
  $stmt->bindParam(':pop', $population);
  $stmt->execute();
  echo 'ID of last insert: ', $dbh->lastInsertId();
}
catch (PDOException $e)
{
  echo 'PDO Exception Caught.  ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo 'Error: ' . $e->getMessage();
}
?>
