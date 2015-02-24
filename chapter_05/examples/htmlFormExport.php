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
      'You must enter your e-mail address', 
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
    $values = $form->exportValues();
    // Include the DB access credentials
    require 'dbcred.php';
    try
    {
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_ERRMODE, 
          PDO::ERRMODE_EXCEPTION);
  
      $sql = 'INSERT INTO user ' .
             '(login, password, email, first_name, last_name, signature)' .
             ' VALUES (:login, :password, :email, :firstname, :lastname, :sig)';
      
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':login', $values['login']);
      $stmt->bindParam(':password', $values['password']);
      $stmt->bindParam(':email', $values['email']);
      $stmt->bindParam(':firstname', $values['first_name']);
      $stmt->bindParam(':lastname', $values['last_name']);
      $stmt->bindParam(':sig', $values['signature']);
      $stmt->execute();
    
      $id = $db->lastInsertId();
      $type = $form->_submitFiles['avatar']['type'];
      $file = 'images/avatars/' . md5(microtime()) .
          basename($form->_submitFiles['avatar']['name']);
    
      move_uploaded_file(
          $form->_submitFiles['avatar']['tmp_name'],
          $file
      );
    
      $sql = 'INSERT INTO user_images' .
          ' (user_id, type, filename) VALUES' .
          ' (:id, :type, :file)';
    
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':type', $type);
      $stmt->bindParam(':file', $file);
      $stmt->execute();
       // Remove unnecessary elements and show result
      $form->removeElement('validemail');
      $form->removeElement('reqs');
      $form->removeElement('avatar');
      $form->removeElement('register');
      $form->freeze();
      $formsource = $form->toHtml() . '<p>The above information has been successfully submitted</p>';
    }
    catch(PDOException $e)
    {
      error_log('Registraiton form error: '. $e->getMessage());
      // Remove unnecessary elements and show result
      $form->removeElement('validemail');
      $form->removeElement('reqs');
      $form->removeElement('avatar');
      $form->removeElement('register');
      $form->freeze();
      $formsource = $form->toHtml() . '<p>An error has occurred. The above information was not successfully submitted</p>';
    }
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