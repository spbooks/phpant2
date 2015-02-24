<?php
// this is a hypothetical example. You will not be able to run this example
// without the appropriate database setup.

// include DB access credentials - for example:
// define('DBHOST, 'localhost);
include '/home/myinc/db.php';

// Instantiate PDO connection
$db = new PDO(DBHOST, DBUSER, DBPASS, DBNAME);

// Instantiate Archive_Tar
$tar = new Archive_Tar('demo/articles.tar.gz', 'gz');

$sql = "SELECT article_id, body FROM articles";

foreach ($db->query($sql) as $row)
{
  // Add a string as a file
  $tar->addString('articles/' . $row['article_id'] . '.txt',
      $row['body']);
}
echo 'Article archive created';
?>
