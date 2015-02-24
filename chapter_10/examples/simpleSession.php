<?php
session_start();
// If session variable doesn't exist, register it
if (!isset($_SESSION['test']))
{
  $_SESSION['test'] = 'Hello World!';
  echo '$_SESSION[\'test\'] is registered.<br />' .
      'Please refresh page';
}
else
{
  // It's registered so display it
  echo '$_SESSION[\'test\'] = ' . $_SESSION['test'];
}
?>
