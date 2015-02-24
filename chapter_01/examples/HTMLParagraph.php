<?php
class HTMLParagraph
{
  private $content;
  public function __construct($content = '')
  {
    $this->content = $content;
  }
   
  public function getSource()
  {
    return '<p>' . $this->content . '</p>';
  }
  
  public function __toString()
  {
    return $this->getSource();
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head><title>OOP in PHP 5</title></head>
  <body>
<?php

$para = new HTMLParagraph('Hello world!');
echo $para->getSource();

$para2 = new HTMLParagraph('The __toString method makes life easy!');
echo "<h1>The Magic __toString Method</h1>\n";
echo $para2;


?>
  </body>
</html>