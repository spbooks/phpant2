#!/usr/bin/php
<?php
// Read the email from the stdin file
$fp = fopen('php://stdin', 'r');
$email = fread ($fp, filesize('php://stdin'));
fclose($fp);
// Break the email up by linefeeds
$email = explode("\n", $email);
// Initialize vars
$numLines = count($email);
for ($i = 0; $i < $numLines; $i++) {
  // Watch out for the From header
  if (preg_match("/^From: (.*)/", $email[$i], $matches)) {
    $from = $matches[1];
    break;
  }
}
// Forward the message to the hotline email
if (strstr($from, 'vip@example.com')) {
  mail('you@yourdomain.com', 'Urgent Message!',
       'Check your mail!');
}
?>