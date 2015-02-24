<?php
// make the DSN
$dsn = 'mysql:host=localhost;dbname=world;';
$user = 'user';
$password = 'secret';

$country = 'USA';

$dbh = new PDO($dsn, $user, $password);
// intentionally typo the table name
$sql = 'Select * from cities where CountryCode =:country';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':country', $country, PDO::PARAM_STR);
$stmt->execute();
$code = $stmt->errorCode();
if (empty($code))
{
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
  {
    print $row['Name'] . "\t";
    print $row['CountryCode'] . "\t";
    print $row['Population'] . "\n";
  }
}
else
{
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo '<pre>';
  var_dump($stmt->errorInfo());
  echo '</pre>';
}
?>
