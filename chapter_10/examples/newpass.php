<?php
// have to disable E_STRICT reporting for PEAR packages
error_reporting(E_ALL);

// Include Session class
require_once 'Session.class.php';
// Include AccountMaintenance class
require_once 'AccountMaintenance.class.php';
// Include QuickForm class
require_once 'HTML/QuickForm.php';
// Include PEAR::Mail_Mime class
require_once 'Mail.php';
require_once 'Mail/mime.php';
// Include the DB access credentials
require_once 'dbcred.php';

$reg_messages = array(
    'email_sent' => array(
        'title' => 'Check your email',
        'content' => '<p>Thank you. An email has been sent to:</p>'
    ),
    'email_error' => array(
        'title' => 'Email Problem',
        'content' => '<p>Unable to send your details.<br />' .
        'Please contact the site administrators.</p>'
    ),
    'no_account' => array(
        'title' => 'Account Problem',
        'content' => '<p>We could not find your account.<br />' .
        'Please contact the site administrators.</p>'
    ),
    'reset_error' => array(
        'title' => 'Password Reset Problem',
        'content' => '<p>There was an error resetting your password.<br />' .
        'Please contact the site administrators.</p>'
    )
);
// mailer settings
$yourEmail = 'you@yourdomain.com';
$subject = 'Your password';
$msg = 'Here are your login details. Please change your password.';
  
try
{
  // Instantiate the QuickForm class
  $form = new HTML_QuickForm('passwordForm', 'POST');
  
  // Add a header to the form
  $form->addElement('header', 'MyHeader', 'Forgotten Your Password?');
  
  // Add a field for the email address
  $form->addElement('text', 'email', 'Enter your email address');
  $form->addRule('email', 'Enter your email', 'required', FALSE,
      'client');
  $form->addRule('email', 'Enter a valid email address', 'email',
      FALSE, 'client');
  // Add a field for the login
  $form->addElement('text', 'login', 'Enter your login name');
  $form->addRule('login', 'Enter your login', 'required', FALSE,
      'client');               
  
  // Add a submit button called submit with label "Send"
  $form->addElement('submit', 'submit', 'Get Password'); 
  
  // If the form is submitted...
  if ($form->validate())
  {
    // Instantiate the MySQL class
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION);
    // Instantiate Account Maintenance class
    $aMaint = new AccountMaintenance($db);
    // Fetch a list of words
    $rawWords = file('words.txt');
    $word = array_map('trim', $rawWords);
    
    // Add the words to the class
    $aMaint->addWords($word);
    
    // Reset the password
    $details = $aMaint->resetPassword(
        $form->getSubmitValue('login'),
        $form->getSubmitValue('email'));
    
    $crlf = "\n";
    $text = $msg . "\n\nLogin: " . $details[0]['login'] .
        "\nPassword: " . $details[0]['password']; 
                  
    $hdrs = array(
        'From'      => $yourEmail,
        'Subject'   => $subject
    );
                
    $mime = new Mail_mime($crlf);
    $mime->setTXTBody($text);
    $body = $mime->get();
    $hdrs = $mime->headers($hdrs);
    $mail = Mail::factory('mail');    
    // Send the message
    $succ = $mail->send($form->getSubmitValue('email'), $hdrs, $body); 
    if (PEAR::isError($succ))
    {
      $display = $reg_messages['email_error'];
    }
    else
    {
      $display = $reg_messages['email_sent'];
      $display['content'] .= '<p>' . $form->getSubmitValue('email') . '</p>';
    }
  }
  else
  {
    // If not submitted, display the form
    $display = array(
        'title' => 'Reset Password',
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
  $display = $reg_messages['reset_error'];
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
