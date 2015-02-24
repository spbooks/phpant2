<?php
// to remove the E_STRICT errors created by PEAR::Validate
error_reporting(E_ALL);
// Include Magic Quotes stripping script
require_once 'strip_quotes.php';
// Include PEAR::Validate
require_once 'Validate.php';

// Initialize errors array
$errors = array('name' => '', 'email' => '', 'url' => '');
// If the form is submitted...
if (isset($_POST['submit']))
{
  // Define the options for formatting the name field
  $name_options = array(
      'format'     => VALIDATE_ALPHA . VALIDATE_SPACE,
      'min_length' => 5
  );

  // Validate name
  if (!Validate::string($_POST['name'], $name_options))
  {
    $errors['name'] = ' class="error"';
  }

  // Validate email
  if (!Validate::email($_POST['email']))
  {
    $errors['email'] = ' class="error"';
  }

  // Validate url
  if (!Validate::url($_POST['url']))
  {
    $errors['url'] = ' class="error"';
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PEAR::Validator</title>
    <style type="text/css">
      form.userinfo {
        font-family: verdana;
        font-size: 12px;
        width: 30em;
      }

      form.userinfo h1 {
        font-weight: bold;
        font-size: 12px;
      }

      form.userinfo div {
        clear: both;
        margin: 5px 10px;
      }

      form.userinfo label {
        float: left;
      }

      form.userinfo span {
        float: right;
      }

      .error {
        color: red;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <form class="userinfo" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
      <?php
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
      ?>
      <h1>Enter your details</h1>
      <div>
        <label<?php echo $errors['name']; ?>>Name:</label>
        <span>
          <input type="text" name="name" value="<?php echo $name; ?>" />
        </span>
      </div>
      <div>
        <label<?php echo $errors['email']; ?>>Email:</label>
        <span>
          <input type="text" name="email" value="<?php echo $email; ?>" />
        </span>
      </div>
      <div>
        <label<?php echo $errors['url']; ?>>Website:</label>
        <span>
          <input type="text" name="url" value="<?php echo $url; ?>" />
        </span>
      </div>
      <div>
        <span>
          <input type="submit" name="submit" value="send" />
        </span>
      </div>
    </form>
  </body>
</html>