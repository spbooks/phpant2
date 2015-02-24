<?php
// Include Magic Quotes stripping script
require_once 'strip_quotes.php';
// Include Session class
require_once 'Session.class.php';
// Include Auth class
require_once 'Auth.class.php';
// Include the DB access credentials
require_once 'dbcred.php';
// try to make the connection to the database
try
{
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
} 
// handle a connection error
catch (PDOException $e)
{
  error_log('Error in '.$e->getFile().
      ' Line: '.$e->getLine().
      ' Error: '.$e->getMessage()
  );
  header('Location: error.php?err=Database Error&msg=' . $e->getMessage());
  exit();
}
// Instantiate the Auth class
$auth = new Auth($db, 'login.php', 'secret');
// For logging out
if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
  $auth->logout();
}
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Welcome</title>
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
    <h1>Welcome</h1>
    <p>You are now logged in</p>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'test') {
      echo '<p>This is a test page. You are still logged in</p>';
    }
    ?>
    <p><a href="<?php echo $_SERVER['PHP_SELF'];
      ?>?action=test">Test page</a></p>
    <p><a href="<?php echo $_SERVER['PHP_SELF'];
      ?>?action=logout">Logout</a></p>
  </body>
</html>