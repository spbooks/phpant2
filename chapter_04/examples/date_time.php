<?php
// to remove the E_STRICT errors
error_reporting(E_ALL);
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PHP Date and Time Functions</title>
    <meta http-equiv="Content-type"
        content="text/html; charset=iso-8859-1" />
    <style type="text/css">
      body {
        font-family: Tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
      }
      h1 {
        font-size: 1.2em;
        color: navy;
      }
      h2 {
        font-size: 1em;
        color: navy;
      }
      .example {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #C0C0C0;
      }
      code {
        color: #666;
      }
    </style>
  </head>
  <body>
    <h1>PHP Date and Time Functions</h1>
    <h2>Example: <code>mktime</code></h2>
    <div class="example">
    <?php
    echo '1st Jan 1899: '  . mktime(0, 0, 0, 1,  1,  1899) . '<br />';
    echo '1st Jan 1902: '  . mktime(0, 0, 0, 1,  1,  1902) . '<br />';
    echo '31st Dec 1969: ' . mktime(0, 0, 0, 12, 31, 1969) . '<br />';
    echo '1st Jan 1790: '  . mktime(0, 0, 0, 1,  1,  1970) . '<br />';
    echo '1st Jan 1937: '  . mktime(0, 0, 0, 1,  1,  2037) . '<br />';
    echo '1st Jan 2038: '  . mktime(0, 0, 0, 1,  1,  2038) . '<br />';
    echo '19th Jan 2038: ' . mktime(0, 0, 0, 1,  19, 2038) . '<br />';
    echo '20th Jan 2038: ' . mktime(0, 0, 0, 1,  20, 2038) . '<br />';
    echo '1st Jan 2039: '  . mktime(0, 0, 0, 1,  19, 2039)
    ?>
    </div>
    
    <h2>Example: <code>date</code></h2>
    <div class="example">
    <?php
    $timestamp = time();
    echo date("F jS, Y", $timestamp) . '<br />'; // August 24th, 2007
    date_default_timezone_set('America/New_York');
    echo date("F jS Y H:i:s") . '<br />'; // August 24th, 2007 03:06:29
    date_default_timezone_set('Africa/Cairo');
    echo date("F jS Y H:i:s"); // August 24th, 2007 10:06:29
    ?>
    </div>
    
    <h2>Example: <code>strtotime</code></h2>
    <div class="example">
    <?php
    $timestamp = strtotime("May 31st 1984");
    $weekday = date("l", $timestamp);
    echo $weekday; // Thursday
    ?>
     </div>
    <div class="example">
     <?php
    $timestamp = strtotime("October");
    $days = date("t", $timestamp);
    echo $days; // 31
    ?>
    </div>
    
    
  </body>
</html>