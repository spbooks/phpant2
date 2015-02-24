<?php
// This is hypothetical example. You will not be able to run
// this example without the appropriate database support

// to remove the E_STRICT errors created by the PHP4 code in Mail
error_reporting(E_ALL);
// include Mail and Mail_Mime class
require 'Mail.php'; 
require 'Mail/mime.php';

/* create the email */

// create a Mail_mime instance and tell it what line endings to use
$mime = new Mail_Mime("\r\n");
// add my text file attachment
$mime->addAttachment('php.gif', 'image/gif');
$header = array(
    'From'    => 'me@mydomain.com',
    'Subject' => 'Forum Newsletter'
);
// choose which backend type we want
$mail = Mail::factory('smtp', array('host'=>'smtp.mydomain.net'));

/* go to the database to get the member information */

// make the DSN
$dsn = 'mysql:host=localhost;dbname=forum;';
$user = 'user';
$password = 'secret';
// try to make the connection to the database
try
{
  $dbh = new PDO($dsn, $user, $password);
  // set the error mode to exception
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION); 
  // go to the DB to get our member listing
  $sql = 'SELECT member_email, firstname, lastname FROM member';
  
  /* cycle through the list sending the custom emails */
   
  foreach ($dbh->query($sql) as $row) 
  {
    // set my text body
    $mime->setTXTBody("Howdy {$row['firstname']} {$row['lastname']}");
    // do not reverse the order of these method calls
    $body = $mime->get();
    $hdrs = $mime->headers( $header);
    // send the email
    $succ = $mail->send($row['member_email'], $hdrs, $body);
    if (PEAR::isError($succ))
    {
      error_log("Email not sent to {$row['member_email']}: " . $succ->getMessage());
    }
  }
} 
// if there is a problem we can handle it here
catch (PDOException $e)
{
  echo 'PDO Exception Caught.  ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo 'Error: ' . $e->getMessage();
}
?>
