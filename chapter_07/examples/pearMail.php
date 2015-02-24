<?php
// to remove the E_STRICT errors created by the PHP4 code in Mail
error_reporting(E_ALL);
// include Mail class
require 'Mail.php'; 
// choose which backend type we want
$mail = Mail::factory('mail');
// some headers we want to send
$headers = array(
    'From'    => 'me@mydomain.com',
    'Subject' => 'Howdy'
);
// send the email
$succ = $mail->send('you@yourdomain.com', $headers, 'Glad to meet you.');
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