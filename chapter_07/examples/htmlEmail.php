<?php
// to remove the E_STRICT errors created by the PHP4 code in Mail
error_reporting(E_ALL);

include('Mail.php');
include('Mail/mime.php');

$text = "Text version of email\nMessage made with PHP";
$html = '<html><body>HTML version of email<br />';
$html .= 'Messaage made with <img src="12345" /></body></html>';
$crlf = "\n";
$hdrs = array(
              'From'    => 'me@mydomain.com',
              'Subject' => 'Test HTMl Email with Embedded Image'
              );

$mime = new Mail_mime($crlf);
// set the text version of the email
$mime->setTXTBody($text);
// embed the image file
$mime->addHTMLImage('php.gif', 'image/gif', '12345', true);
// set the HTML version of the email
$mime->setHTMLBody($html);

//do not ever try to call these lines in reverse order
$body = $mime->get();
$hdrs = $mime->headers($hdrs);

$mail = Mail::factory('mail');   
$succ = $mail->send('you@yourdomain.com', $hdrs, $body);
// Check for sending errors
if (PEAR::isError($succ))
{
  echo 'Email sending failed: ' . $succ->getMessage();
}
else
{
  echo 'Email sent succesfully';
}
?>



