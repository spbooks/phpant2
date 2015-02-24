<?php
require_once 'HTMLParagraph.class.php';

class HTML
{
  public static function p($content, $attributes = array()) {
    return new HTMLParagraph($content, $attributes);
  } 
}
?>