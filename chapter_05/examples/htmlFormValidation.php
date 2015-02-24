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
      '<strong>Image <em>must</em> be no more than 64x64 pixels in size.'
  );
  
  // Don't forget the Submit button!
  $form->addElement('submit', 'register', "Register Now!");

  // Add Validation
  $form->addRule('first_name', 
      'You must enter your first name', 
      'required', null, 'client'
  );
  $form->addRule('first_name', 
      'Your first name must be at least 3 letters', 
      'minlength', '3', 'client'
  );
  $form->addRule('last_name', 
      'You must enter your last name', 
      'required', null, 'client'
  );
  $form->addRule('last_name', 
      'Your last name must be at least 3 letters', 
      'minlength', '3', 'client'
  );
  $form->addRule('email', 
      'You must enter your email address', 
      'required', null, 'client'
  );
  $form->addRule('email', 
      'Please enter a valid email address',
      'email', FALSE, 'client'
  );
  $form->addRule('login', 
      'You must enter a login name', 
      'required', null, 'client'
  );
  $form->addRule('login', 
      'Your login name must be between 6-20 characters long', 
      'rangelength', array(6, 20), 'client'
  );
  $form->addRule('password', 
      'You must enter a password', 
      'required', null, 'client'
  );
  $form->addRule('password', 
      'Your Password must be at least 6 characters long.', 
      'minlength', '6', 'client'
  );
  
  // Process Form
  if ($form->validate())
  {
    // Form Validates
    // Handle Form here
    
    // Remove unnecessary elements and show result
    $form->removeElement('validemail');
    $form->removeElement('reqs');
    $form->removeElement('avatar');
    $form->removeElement('register');
    $form->freeze();
    $formsource = $form->toHtml();
  }
  else
  {
    // Form has not yet been submitted, or is invalid, show form
    $formsource = $form->toHtml();
  }
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