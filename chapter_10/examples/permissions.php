<?php 
// Include Session class
require_once 'Session.class.php';

// Include Auth class
require_once 'Auth.class.php';

// Include User class
require_once 'User.class.php';

// include DB credentials
require_once 'dbcred.php';

try
{
  // instantiate a PDO object
  $db = new PDO($dsn, $user, $password);

  // Instantiate the Authentication class
  $auth = new Auth($db, 'login.php', 'secret');
  
  // Instantiate the User class
  $authuser = new User($db); 
  
  // Switch on the view GET variable
  switch (@$_GET['view']) {
    case 'create':
      // Define permission (a name in permissions table)
      $permission = 'create';
      // Create a message for users with access to this area
      $msg = 'You are able to create new content.';
      break;
    case 'edit':
      $permission = 'edit';
      $msg = 'You are able to edit existing content.';
      break;
    case 'delete':
      $permission = 'delete';
      $msg = 'You are able to delete existing content.';
      break;
    default:
      $permission = 'view';
      $msg = 'You are able to read existing content.';
  }
  
  // Check the user's permission. If inadequate, change the msg
  if (!$authuser->checkPermission($permission)) {
    $msg = 'You do not have permission to do this.';
  }
} 
// handle a connection error
catch (Exception $e)
{
  // handle as business rules dictate
  $msg = 'An error has occurred: ' . $e->getMessage();
}                            
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Permissions Test</title>
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
      h2 {
        font-size: 1em;
        color: navy
      }
    </style>
  </head>
  <body>
    <h1>Permissions Test</h1>
    <p>
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>">View</a> |
      <a href="<?php echo $_SERVER['PHP_SELF'];
        ?>?view=create">Create</a> |
      <a href="<?php echo $_SERVER['PHP_SELF'];
        ?>?view=edit">Edit</a> |
      <a href="<?php echo $_SERVER['PHP_SELF'];
        ?>?view=delete">Delete</a>
    </p>
    <h2><?php echo $authuser->getFirstName() . ' ' . $authuser->getLastName(); ?></h2>
    <p>Permission Level: '<?php echo $permission ?>'</p>
    <p><?php echo $msg; ?></p>
  </body>
</html>