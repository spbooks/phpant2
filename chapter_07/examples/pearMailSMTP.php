<?php
// to remove the E_STRICT errors created by the PHP4 code in Mail
error_reporting(E_ALL);

// include Mail class
require 'Mail.php'; 

// choose which backend type we want
$mail = Mail::factory('smtp', array('host'=>'smtp.mydomain.com'));
// some headers we want to send
$hdrs = array(
    'From'    => 'Me <me@mydomain.com>',
    'CC'    => 'Mr Example <example@exampledomain.com>',
    'Subject' => 'Howdy'
);
// the body of the message
$body = 'Glad to meet you.';

// send the email
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
