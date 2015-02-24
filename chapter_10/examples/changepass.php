<?php
// have to disable E_STRICT reporting for PEAR packages
error_reporting(E_ALL);  

// Include Session class
require_once 'Session.class.php';

// Include Authentication class
require_once 'Auth.class.php';

// Include AccountMaintenance class
require_once 'AccountMaintenance.class.php';

// Include QuickForm class
require_once 'HTML/QuickForm.php';

// Include the DB access credentials
require_once 'dbcred.php';

$reg_messages = array(
    'success' => array(
        'title' => 'Password Changed',
        'content' => '<p>Your password has been changed successfully.</p>'
    ),
    'no_account' => array(
        'title' => 'Account Problem',
        'content' => '<p>We could not find your account.<br />' .
        'Please contact the site administrators.</p>'
    ),
    'change_error' => array(
        'title' => 'Change Password Problem',
        'content' => '<p>There was an error changing your password.' .
        'Please contact the site administrators, or click ' .
        '<a href="' . $_SERVER['PHP_SELF'] . '">here</a> to ' .
        'try again.</p>'
    )
);
  
try
{
  // Instantiate the MySQL class
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
  // Instantiate the Authentication class
  $auth = new Auth($db, 'login.php', 'secret');
      
  // Instantiate the QuickForm class
  $form = new HTML_QuickForm('changePass', 'POST');
  
  // A function for comparing password
  function cmpPass($element, $confirm)
  { 
    $password = $GLOBALS['form']->getElementValue('newPassword');
    return $password == $confirm;
  }
  
  // Register the compare function
  $form->registerRule('compare', 'function', 'cmpPass');
  
  // Add a header to the form
  $form->addElement('header', 'MyHeader', 'Change your password');  
  
  // Add a field for the old password
  $form->addElement('password', 'oldPassword',
      'Current Password');
  $form->addRule('oldPassword', 'Enter your current password',
      'required', false, 'client');
  
  // Add a field for the new password
  $form->addElement('password', 'newPassword', 'New Password');
  $form->addRule('newPassword', 'Please provide a password',
      'required', false, 'client');
  $form->addRule('newPassword',
      'Password must be at least 6 characters',
      'minlength', 6, 'client');
  $form->addRule('newPassword',
      'Password cannot be more than 12 chars',
      'maxlength', 50, 'client');
  $form->addRule('newPassword',
      'Password can only contain letters and ' .
      'numbers', 'alphanumeric', NULL, 'client');
  
  // Add a field for password confirmation
  $form->addElement('password', 'confirm', 'Confirm Password');
  $form->addRule('confirm', 'Please confirm your password',
      'required', false, 'client');
  $form->addRule('confirm', 'Your passwords do not match',
      'compare', false, 'client');
  
  // Add a submit button
  $form->addElement('submit', 'submit', 'Change Password');
  
  // If the form is submitted...
  if ($form->validate())
  {
    // Instantiate Account Maintenance class
    $aMaint = new AccountMaintenance($db);
    // Change the password
    $aMaint->changePassword($auth,
        $form->getSubmitValue('oldPassword'),
        $form->getSubmitValue('newPassword')
    );
    $display = $reg_messages['success'];
  }
  else
  {
    // If not submitted, display the form
    $display = array(
        'title' => 'Change Password',
        'content' => $form->toHtml()
    );
  } 
}
catch (AccountUnknownException $e)
{
  $display = $reg_messages['no_account'];
}
catch (Exception $e)
{
  error_log('Error in '.$e->getFile().
      ' Line: '.$e->getLine().
      ' Error: '.$e->getMessage()
  );
  $display = $reg_messages['change_error'];
}        
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $display['title']; ?></title>
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
    <h1><?php echo $display['title']; ?></h1>
    <?php echo $display['content']; ?>
  </body>
</html>
