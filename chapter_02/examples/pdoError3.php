<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

$country = 'USA';
try
{
  $dbh = new PDO($dsn, $user, $password);
  // set the error mode to exception 
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);  
  // intentionally typo the table name
  $sql = 'Select * from cities where CountryCode =:country';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':country', $country, PDO::PARAM_STR);
  $stmt->execute();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print $row['Name'] . "\t";
    print $row['CountryCode'] . "\t";
    print $row['Population'] . "\n";
  }
}
catch (PDOException $e)
{ 
  echo 'PDO Exception Caught.  ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo '<pre>';
  echo 'Error: ' . $e->getMessage() . '<br />';
  echo 'Code:  ' . $e->getCode() . '<br />';
  echo 'File:  ' . $e->getFile() . '<br />';
  echo 'Line:  ' . $e->getLine() . '<br />';
  echo 'Trace: ' . '<br />' . $e->getTraceAsString();
  echo '</pre>';
}
?>
