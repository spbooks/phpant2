<?php
require_once 'HTMLSource.interface.php';
abstract class HTMLElement implements HTMLSource
{
  protected $content;
  protected $tagname;
  protected $attributes;
  
  public function __construct($content, $attributes = array())
  {
    $this->content = $content;
    $this->attributes = $attributes;
  }
   
  public function getSource()
  {
    if ($this->content instanceof HTMLSource)
    {
      $html = $this->content->getSource();
    }
    else
    {
      $html = $this->content;
    }
  
    return '<' . $this->tagname . $this->getAttributeSource() . '>' .
        $html . 
        '</' . $this->tagname . '>';
  }
  
  public function getAttributeSource()
  {
    $attributes = '';  
    if (count($this->attributes)) {
      foreach ($this->attributes as $attrnme => $attrval)
      {
        $attributes .= ' ' . $attrnme . '="' . $attrval . '"';
      }
    }
    return $attributes;
  }
  
  public function __toString()
  {
    return $this->getSource();
  }
  
  abstract public function addContent(HTMLElement $element);
}
?>