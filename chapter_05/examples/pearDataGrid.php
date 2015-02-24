<?php
  // Include the DB access credentials
  require 'dbcred.php';
  // Include the PEAR Structures_DataGrid class
  require 'Structures/DataGrid.php';
  
  // instantiate grid for 2 records per page
  $datagrid = new Structures_DataGrid(2);
  // Define our Datasource options, in this case MDB2 MySQL
  $options = array('dsn' => "mysql://$user:$password@$db_host/$db_name");
  
  // Define the Query
  $sql = "SELECT * FROM user";
  
  // Bind the Query to our Datagrid
  $bind = $datagrid->bind($sql, $options);
  // Test for Errors
  if (PEAR::isError($bind))
  {
    error_log('DataGrid Error: '. $bind->getMessage());
    $gridsource = '';
  }
  else
  {
    // Define our Column labels, using a 'column' => 'Label' format
    $columns = array(
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'E-Mail',
        'login' => 'Login Name',
        'signature' => 'Signature',
    );
    $datagrid->generateColumns($columns);
    // Some more options, for our renderer
    $renderer_options = array(
        'sortIconASC' => '&uArr;',
        'sortIconDESC' => '&dArr;',
        'headerAttributes' => array('bgcolor' => '#E3E3E3'),
        'evenRowAttributes' => array('bgcolor' => '#A6A6A6'),
    );
    $datagrid->setRendererOptions($renderer_options);
    
    // Add some final attributes to our table
    $renderer = $datagrid->getRenderer();
    $renderer->setTableAttribute('cellspacing', 0);
    $renderer->setTableAttribute('cellpadding', 5);
    $renderer->setTableAttribute('border', 1);
    // Render the table, be sure to check for errors 
    $gridbody = $datagrid->getOutput();
    if (PEAR::isError($gridbody))
    {
      error_log('DataGrid render error: ' . $gridbody->getMessage());
      $gridbody = '';
    }
    // Finally, render the pager, again checking for errors
    $gridpager = $datagrid->getOutput(DATAGRID_RENDER_PAGER);
    if (PEAR::isError($gridpager))
    {
      error_log('DataGrid render error: ' . $gridpager->getMessage());
      $gridpager = '';
    }
    $gridsource = $gridbody . $gridpager;
  }
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PEAR::Structures_DataGrid</title>
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
    <h1>PEAR::Structures_DataGrid</h1>
    <?php echo $gridsource ?>
  </body>
</html>
