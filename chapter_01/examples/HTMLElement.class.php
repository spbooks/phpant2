<?php
class HTMLElement
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
    return '<' . $this->tagname . $this->getAttributeSource() . '>' .
        $this->content . 
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
}

?>