<?php
// An array of allowed users and their passwords
$users = array(
  'jackbenimble' => 'sekret',
  'littlepig' => 'chinny'
);

// If there's no Authentication header, exit
if (!isset($_SERVER['PHP_AUTH_USER']))
{
  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Basic realm="PHP Secured"');
  exit('This page requires authentication');
}

// If the user name doesn't exist, exit
if (!isset($users[$_SERVER['PHP_AUTH_USER']]))
{
  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Basic realm="PHP Secured"');
  exit('Unauthorized!');
}

// Is the password doesn't match the username, exit
if ($users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW'])
{
  header('HTTP/1.1 401 Unauthorized');
  header('WWW-Authenticate: Basic realm="PHP Secured"');
  exit('Unauthorized!');
}

echo 'You\'re in ! Your credentials were:<br />';
echo 'Username: ' . $_SERVER['PHP_AUTH_USER'] . '<br />';
echo 'Password: ' . $_SERVER['PHP_AUTH_PW'];
?>
