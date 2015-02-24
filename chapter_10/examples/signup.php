<?php
// have to disable E_STRICT reporting for PEAR packages
error_reporting(E_ALL);

// Include the SignUp class
require_once 'Signup.class.php';

// Include the QuickForm class
require_once 'HTML/QuickForm.php';

// Include the PEAR Mail_Mime class
require_once 'Mail.php';  
require_once 'Mail/mime.php';

// database credentials
require 'dbcred.php';
$reg_messages = array(
    'success' => array(
        'title' => 'Confirmation Successful',
        'content' => '<p>Thank you. Your account has now been confirmed.' .
        '<br />You can now <a href="access.php">login</a></p>'
    ),
    'confirm_error' => array(
        'title' => 'Confirmation Problem',
        'content' => '<p>There was a problem confirming your account.' .
        '<br />Please try again or contact the site ' .
        'administrators</p>'
    ),
    'email_sent' => array(
        'title' => 'Check your email',
        'content' => '<p>Thank you. Please check your email to ' .
        'confirm your account</p>'
    ),
    'email_error' => array(
        'title' => 'Email Problem',
        'content' => '<p>Unable to send confirmation email.<br />' .
        'Please contact the site administrators.</p>'
    ),
    'signup_not_unique' => array(
        'title' => 'Registration Problem',
        'content' => '<p>There was an error creating your account.<br />' .
        'The desired username or email address has already been taken.</p>'
    ),
    'signup_error' => array(
        'title' => 'Registration Problem',
        'content' => '<p>There was an error creating your account.<br />' .
        'Please contact the site administrators.</p>'
    )
);
// Settings for SignUp class
$listener = 'http://localhost/phpant2/chapter_10/examples/signup.php';
$frmName = 'Your Name';
$frmAddress = 'noreply@yoursite.com';
$subj = 'Account Confirmation';
$msg = <<<EOD
<html>
<body>
<h2>Thank you for registering!</h2>
<div>The final step is to confirm 
your account by clicking on:</div>
<div><confirm_url/></div>
<div>
<b>Your Site Team</b>
</div>
</body>
</html>
EOD;

try
{
  // Instantiate the PDO object for the database connection
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
      
  // Instantiate the signup class
  $signUp = new SignUp($db, $listener, $frmName,
      $frmAddress, $subj, $msg, TRUE);
  
  // Is this an account confirmation?
  if (isset($_GET['code']))
  {
    try
    {
      $signUp->confirm($_GET['code']);
      $display = $reg_messages['success']; 
    } catch (SignUpException $e){
      $display = $reg_messages['confirm_error'];
    }
  }
  // Otherwise display the form  
  else
  {
    // A function for comparing password
    function cmpPass($element, $confirmPass)
    { 
      $password = $GLOBALS['form']->getElementValue('password');
      return $password == $confirmPass;
    }
  
    // A function to encrypt the password
    function encryptValue($value)
    {
      return md5($value);
    }
    
    /*  Make the form */
    // Instantiate the QuickForm class
    $form = new HTML_QuickForm('regForm', 'POST');
  
    // Register the compare function
    $form->registerRule('compare', 'function', 'cmpPass');
  
    // The login field
    $form->addElement('text', 'login', 'Desired Username');
    $form->addRule('login', 'Please provide a username', 'required',
        FALSE, 'client');
    $form->addRule('login', 'Username must be at least 6 characters',
        'minlength', 6, 'client');
    $form->addRule('login',
        'Username cannot be more than 50 characters', 'maxlength', 50,
        'client');
    $form->addRule('login',
        'Username can only contain letters and numbers',
        'alphanumeric', NULL, 'client');
  
    // The password field
    $form->addElement('password', 'password', 'Password');
    $form->addRule('password', 'Please provide a password',
        'required', FALSE, 'client');
    $form->addRule('password',
        'Password must be at least 6 characters', 'minlength', 6,
        'client');
    $form->addRule('password',
        'Password cannot be more than 12 characters', 'maxlength', 12,
        'client');
    $form->addRule('password',
        'Password can only contain letters and numbers',
        'alphanumeric', NULL, 'client');
  
    // The field for confirming the password
    $form->addElement('password', 'confirmPass', 'Confirm Password');
    $form->addRule('confirmPass', 'Please confirm password',
        'required', FALSE, 'client');
    $form->addRule('confirmPass', 'Passwords must match',
        'compare', 'function');
  
    // The email field
    $form->addElement('text', 'email', 'Email Address');
    $form->addRule('email', 'Please enter an email address',
        'required', FALSE, 'client');
    $form->addRule('email', 'Please enter a valid email address',
        'email', FALSE, 'client');
    $form->addRule('email', 'Email cannot be more than 50 characters',
        'maxlength', 50, 'client');
  
    // The first name field
    $form->addElement('text', 'firstName', 'First Name');
    $form->addRule('firstName', 'Please enter your first name',
        'required', FALSE, 'client');
    $form->addRule('firstName',
        'First name cannot be more than 50 characters', 'maxlength',
        50, 'client');
  
    // The last name field
    $form->addElement('text', 'lastName', 'Last Name');
    $form->addRule('lastName', 'Please enter your last name',
        'required', FALSE, 'client');
    $form->addRule('lastName',
        'Last name cannot be more than 50 characters', 'maxlength',
        50, 'client');
  
    // The signature field
    $form->addElement('textarea', 'signature', 'Signature');
  
    // Add a submit button called submit and "Send" as the button text
    $form->addElement('submit', 'submit', 'Register');
    /* End making the form */
  
    // If the form is submitted...
    if ($form->validate())
    {
      // Apply the encryption filter to the password
      $form->applyFilter('password', 'encryptValue');
      
      // Build an array from the submitted form values
      $submitVars = array(
          'login' => $form->getSubmitValue('login'),
          'password' => $form->getSubmitValue('password'),
          'email' => $form->getSubmitValue('email'),
          'firstName' => $form->getSubmitValue('firstName'),
          'lastName' => $form->getSubmitValue('lastName'),
          'signature' => $form->getSubmitValue('signature')
      );
      
      try
      {
        // Create signup 
        $signUp->createSignup($submitVars);
        // Send confirmation email
        $signUp->sendConfirmation();
        $display = $reg_messages['email_sent'];
      }
      catch (SignUpEmailException $e)
      {
        $display = $reg_messages['email_error'];
      }
      catch (SignUpNotUniqueException $e)
      {
        $display = $reg_messages['signup_not_unique'];
      }
      catch (SignUpException $e)
      {
        $display = $reg_messages['signup_error'];
      }
    }
    else
    {
      // If not submitted, display the form
      $display = array(
          'title' => 'New Registration',
          'content' => $form->toHtml()
      );
    }
  }
}
catch (Exception $e)
{
  error_log('Error in '.$e->getFile().
      ' Line: '.$e->getLine().
      ' Error: '.$e->getMessage()
  );
  $display = $reg_messages['signup_error'];
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

