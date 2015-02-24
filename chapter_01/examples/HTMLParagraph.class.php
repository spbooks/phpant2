<?php
require_once 'HTMLElement.class.php';

class HTMLParagraph extends HTMLElement
{
  protected $tagname = 'p';
  public function __construct($content, $attributes = array())
  {
    parent::__construct($content, $attributes);
  }
}

?>