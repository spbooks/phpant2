<?php
// have to disable E_STRICT reporting for PEAR packages
error_reporting(E_ALL);

// Include QuickForm class
require_once 'HTML/QuickForm.php';

// If $_GET['from'] comes from the Auth class
if (isset($_GET['from']))
{
  $target = $_GET['from'];
}
else
{
  // Default URL: usually index.php
  $target = 'access.php';
}

$form = new HTML_QuickForm('loginForm', 'POST', $target);

// Add a header to the form
$form->addElement('header', 'MyHeader', 'Please Login');    

// Add a field for the login name
$form->addElement('text', 'login', 'Username');
$form->addRule('login', 'Enter your login', 'required', false,
    'client');

// Add a field for the password
$form->addElement('password', 'password', 'Password');
$form->addRule('password', 'Enter your password', 'required',
    false, 'client');

// Add a submit button
$form->addElement('submit', 'submit', ' Login ');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Login Form</title>
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
    <h1>Please log in</h1>
    <?php echo $form->toHTML(); ?>
  </body>
</html>

