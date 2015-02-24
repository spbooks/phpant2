<?php

// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

// try to make the connection to the database
try
{
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
  $sql = 'CALL getQuote()';
  $stmt = $dbh->prepare($sql); 
  $stmt->execute();
  $return_string = $stmt->fetch();
}
catch (PDOException $e)
{
  echo 'PDO Exception Caught.  ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo 'Error: ' . $e->getMessage();
}

echo 'Called stored procedure.  It returned: ', $return_string[0];

?>
