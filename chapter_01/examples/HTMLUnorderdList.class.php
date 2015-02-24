<?php
require_once 'HTMLListItem.class.php';

class HTMLUnorderdList extends HTMLElement
{
  protected $tagname = 'ul';
  private $items = array();
  
  public function __construct($content, $attributes = array())
  {
    parent::__construct($content, $attributes);
  }
  
  public function addListItem(HTMLListItem $item)
  {
    $this->items[] = $item;
  }
  
  public function getSource()
  {
    if (count($this->items)) {
      $this->content = '';    
      foreach ($this->items as $item)
      {
        $this->content .= $item->getSource();
      }
    }
    return parent::getSource();
  } 
}

?>