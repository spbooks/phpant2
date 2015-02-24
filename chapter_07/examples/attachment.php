<?php
// to remove the E_STRICT errors created by the PHP4 code in Mail
error_reporting(E_ALL);

// include Mail and Mail_Mimeclass
require 'Mail.php'; 
require 'Mail/mime.php';

// create a Mail_mime instance and tell it what line endings to use
$mime = new Mail_Mime("\r\n");
// set my text body
$mime->setTXTBody('See attached text file.');
// add my text file attachment
$mime->addAttachment(
    'test.txt', 
    'text/plain', 
    'attached.txt', 
    TRUE,
    'quoted-printable'
);

// do not reverse the order of these method calls
$body = $mime->get();
// some headers we want to send
$hdrs = $mime->headers(array(
    'From'    => 'me@mydomain.com',
    'Subject' => 'File Attachment'
));

// choose which backend type we want
$mail = Mail::factory('smtp', array('host'=>'smtp.mydomain.com'));
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
