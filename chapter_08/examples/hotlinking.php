<?php
// Start a session
session_start();

// Register a variable in the session
$_SESSION['viewImages'] = true;
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> Preventing Hotlinking </title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  </head>
  <body>
    <p>Here is the image:</p>
    <img src="getimage.php?img=husky.jpg">
  </body>
</html>