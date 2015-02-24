 <?php
  // Include the DB access credentials
  require 'dbcred.php';
  // Include the PEAR Structures_DataGrid class
  require 'Structures/DataGrid.php';

  // Custom Output Callback Functions
  function getName($data)
  {
    return $data['record']['first_name'] .' '.
        $data['record']['last_name'];
  }
  
  function getThumbnail($data)
  {
    if (strlen($data['record']['filename']) > 0)
    {
      return '<img src="images/avatars/'
	        .$data['record']['filename']. '" />';
    }
    else 
    {
      return '<img src="images/avatars/missing.gif" />';
    }
  }
  
  $datagrid = new Structures_DataGrid(2);
  
  // Add Custom Columns
  $thumb = new Structures_DataGrid_Column("", "thumb", "thumb", 
      null, null, "getThumbnail()");
  $datagrid->addColumn($thumb);
  
  $name = new Structures_DataGrid_Column("Name", "name", 
      "first_name", null, null, "getName()");
  $datagrid->addColumn($name);
  
  $email = new Structures_DataGrid_Column("E-Mail", "email",
      "email");
  $datagrid->addColumn($email);
  
  $login = new Structures_DataGrid_Column("Login Name", "login",
      "login");
  $datagrid->addColumn($login);
  
  $sig = new Structures_DataGrid_Column("Signature", "signature",
      "signature");
  $datagrid->addColumn($sig);
  
  // Add Default Sort
  $datagrid->setDefaultSort(array('first_name' => 'ASC'));
  
  $options = array('dsn' => "mysql://$user:$password@$db_host/$db_name");
  $sql = "SELECT DISTINCT * FROM user".
      " LEFT JOIN user_images".
      " ON user.id = user_images.user_id";
      
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
    $renderer_options = array(
        'sortIconASC' => '<img src="images/up.gif" />',
        'sortIconDESC' => '<img src="images/down.gif" />',
        'headerAttributes' => array('bgcolor' => '#E3E3E3'),
        'evenRowAttributes' => array('bgcolor' => '#A6A6A6'),
    );
    $datagrid->setRendererOptions($renderer_options);
    
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
    <title>PEAR::Structures_DataGrid, Customized!</title>
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
      img {
        border: none;
      }
    </style>
  </head>
  <body>
    <h1>PEAR::Structures_DataGrid, Customized!</h1>
    <?php echo $gridsource ?>
  </body>
</html>