<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

//$city = 'New York';
$city ="' or Name LIKE '%" ;
// try to make the connection to the database
try
{
  $dbh = new PDO($dsn, $user, $password);
  // set the error mode to exception 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
      
  // Danger of SQL injections here, this is the wrong way
  $sql = "Select * from city where Name ='". $city ."'";
  
  // This is the right way
  // $sql = "Select * from city where Name ='".$dbh->quote($city)."'";
  
  foreach ($dbh->query($sql) as $row) 
  {
    print $row['Name'] . "\t";
    print $row['CountryCode'] . "\t";
    print $row['Population'] . "\n";
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
