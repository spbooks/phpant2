<?php
  // Include HTML_QuickForm
  require_once 'HTML/QuickForm.php';
  
  // Instantiate our form, called 'Create'
  $form = new HTML_QuickForm('Create', 'post', basename(__FILE__));
  
  // Our Default Form Options
  $opts = array('size' => 20, 'maxlength' => 255);
  // Add our form elements
  $form->addElement('static', 'header', null, 
      '<h1>Register</h1>'
  );
  
  $form->addElement('text', 'first_name', 'First Name', $opts);
  
  $form->addElement('text', 'last_name', 'Last Name', $opts);
  
  $form->addElement('text', 'login', 'Login Name', $opts);
  
  $form->addElement('password', 'password', 'Password', $opts);
  
  $form->addElement('text', 'email', 'E-Mail', $opts);
  
  $form->addElement('static', 'validemail', null, 
      '<strong>E-Mail address must be valid, and will only be'.
      ' used for account verification.</strong>'
  );
  
  $form->addElement('textarea', 'signature', 'Signature', 
      array('rows' => 10, 'cols' => 20));
  
  $form->addElement('file', 'avatar', 'Avatar Image');
  
  $form->addElement('static', 'reqs', null, 
      '<strong>Image <em>must</em> be no more than 64x64 pixels in size.</strong>'
  );
  
  // Don't forget the Submit button!
  $form->addElement('submit', 'register', "Register Now!");
  
  $formsource = $form->toHtml();
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Register</title>
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
    <?php echo $formsource; ?>
  </body>
</html>