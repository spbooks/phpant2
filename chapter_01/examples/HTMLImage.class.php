<?php
require_once 'HTMLElement.class.php';

class HTMLImage extends HTMLElement
{
  protected $tagname = 'img';
  public function __construct($content, $attributes = array())
  {
    parent::__construct('', $attributes);
  }
  
  public function getSource()
  {
    return '<' . $this->tagname . $this->getAttributeSource() . ' />';
  }
  
  public function getAttributeSource()
  {
    if (!array_key_exists('alt',$this->attributes)) {
      $this->attributes['alt'] = 'This image needs alt text';
    }
    return parent::getAttributeSource();
  }
}
?>