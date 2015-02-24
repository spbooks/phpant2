<?php
  // Include the DB access credentials
  require 'dbcred.php';
  // Include PEAR::HTML_Table
  require 'HTML/Table.php';
  // try to make the connection to the database
  try
  {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM user";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $table = new HTML_Table;
    $table->setAutoGrow(true);
    $table->addRow(array("","Login","Password","E-Mail",
        "First Name","Last Name","Signature"), null, "th");
        
    while ($row = $stmt->fetch(PDO::FETCH_NUM))
    {
        $table->addRow($row);
    }
    
    $tablesource = $table->toHTML();    
  } 
  // handle a connection error
  catch (PDOException $e)
  {
    error_log('Error in '.$e->getFile().
        ' Line: '.$e->getLine().
        ' Error: '.$e->getMessage()
    );
    $tablesource = "";
  }
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PEAR::HTML_Table</title>
    <meta http-equiv="Content-type"
        content="text/html; charset=iso-8859-1" />
    <style type="text/css">
      body {
        font-family: Tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
      }
      h1 {
        font-size: 1.2em;
        color: navy
      }
    </style>
  </head>
  <body>
    <h1>PEAR::HTML_Table</h1>
    <?php echo $tablesource ?>
  </body>
</html>