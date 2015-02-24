<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>OOP in PHP 5</title>
    <style type="text/css">
      .introduction {
        font-style: italic;
      }
    </style>
  </head>
  <body>

<?php
require 'HTMLParagraph.class.php';
require 'HTMLImage.class.php';

$para = new HTMLParagraph("The object oriented programming\n" .
    " paradigm is an approach to programming that's intended\n" .
    " to encourage the development of well-structured and\n" .
    " maintainable applications.",
    array(
      'id' => 'oop_intro',
      'class' => 'introduction'
    )
);
$logo = new HTMLImage('',
    array(
      'id' => 'logo',
      'src' => 'php.gif'
    )
);
echo $logo;
echo "\n<h1>OOP in PHP 5</h1>\n";
echo $para;

?>

  </body>
</html>