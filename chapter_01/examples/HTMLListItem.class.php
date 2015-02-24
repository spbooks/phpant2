<?php
require_once 'HTMLElement.class.php';

class HTMLListItem extends HTMLElement
{
  protected $tagname = 'li';
  public function __construct($content, $attributes = array())
  {
    parent::__construct($content, $attributes);
  }
}
?>