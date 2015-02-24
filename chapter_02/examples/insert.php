<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

$id = '4080';
$name = 'Guam';
$country = 'GU';
$district = 'Guam';
$population = 171018;  // this is wrong but lets pretend

try
{   
  $dbh = new PDO($dsn, $user, $password);
  // set the error mode to exception 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);  
  $sql = 'INSERT INTO city (ID, 
                            Name, 
                            CountryCode, 
                            District, 
                            Population) 
                      VALUES (:id, 
                              :name, 
                              :country, 
                              :district, 
                              :pop)';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':country', $country);
  $stmt->bindParam(':district', $district);
  $stmt->bindParam(':pop', $population);
  $stmt->execute();    
}
catch (PDOException $e)
{
  echo 'PDO Exception Caught.  ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo 'Error: ' . $e->getMessage();
}
?>
