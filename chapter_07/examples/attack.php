<?php
$error = FALSE;
if (isset($_POST['submit']))
{
  $to = 'example@localhost';
  // replace new lines with a space - prevents a user from adding headers 
	$subject = preg_replace('/[\r|\n]+/', " ", $_POST['subject']);
	$from = preg_replace('/[\r|\n]+/', " ", $_POST['from']);

	// basic validation for subject and email address
	$emailPattern = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/'; 
	if (preg_match('/^[^\w .!?\*%$#]+$/', $subject) || 
      !preg_match($emailPattern, $from))
	{
		$error = "Invalid input.  Try again.";
	}

  if ($error === FALSE && mail($to, $subject, $_POST['message'], "FROM: $from"))
  {
    $error = "Message Sent";
  } 
  else
  {
    $error .= " We could not send your message.  Sorry";
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">  
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Email Form</title>
    <style type="text/css">
      label {
        display: block;
      }
    </style>
  </head>
  <body>
  <?php if ($error !== FALSE) {echo $error;} ?>
  <form action="attack.php" method="post" accept-charset="utf-8" >
    <fieldset>
    <legend>Send a Message</legend>
      <label for="from">From:</label>
      <input type="text" name="from" id="from" />
      <label for="subject">Subject:</label>
      <input type="text" maxlength="75" name="subject" id="subject" />
      <label for="message">Message:</label>
      <textarea name="message" id="message" cols="50" rows="5" />Message Here</textarea><br />
      <input type="submit" name="submit" value="Send Email" />
    </fieldset>
  </form>
  </body>
</html>
