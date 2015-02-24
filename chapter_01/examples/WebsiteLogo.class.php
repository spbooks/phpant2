<?php
require_once 'HTMLImage.class.php';

class WebsiteLogo
{
  private $img;
  public function __construct($imagesrc, $title, $alt)
  {
    $this->img = new HTMLImage('',array('src' => $imagesrc,
        'title' => $title,
        'alt' => $alt,
        'class' => 'sitelogo'));
  }
  
  public function getSource()
  {
    return $this->img->getSource();
  }
  
  public function __toString()
  {
    return $this->getSource();
  }
}
?>