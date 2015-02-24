<?php
class RequestPath
{
  private $parts = array();
  public function __construct()
  {
    // Example Path: /edit/trackbacks/for/163-My-Example-Page
    if (isset($_SERVER['PATH_INFO']))
    {
      // We're using AcceptPathInfo/MultiViews
      $path = (substr($_SERVER['PATH_INFO'], -1) == "/") ?
          substr($_SERVER['PATH_INFO'], 0, -1) :
          $_SERVER['PATH_INFO'];
    }
    else
    {
      // We're using mod_rewrite
      $path = (substr($_SERVER['REQUEST_URI'], -1) == "/") ?
          substr($_SERVER['REQUEST_URI'], 0, -1) :
          $_SERVER['REQUEST_URI'];
    }
    // Explode on "/"
    $bits = explode("/", substr($path, 1));
    
    // Set 'action' and 'type' special keys
    $parsed['action'] = array_shift($bits);
    $parsed[] = $parsed['action'];
    
    $parsed['type'] = array_shift($bits);
    $parsed[] = $parsed['type'];
    
    $parts_size = sizeof($bits);
    
    // Make sure we only have key-value pairs
    if ($parts_size % 2 != 0) {
      // We don't, lets pretend we do for now
      $parts_size -= 1;
    }
    
    // Add all key-value pairs to our $parsed array
    for ($i = 0; $i < $parts_size; $i+=2) {
      $parsed[$bits[$i]] = $bits[$i+1];
      $parsed[] = $bits[$i+1];
    }
    
    // If we had an errant value, place it on the end
    if (sizeof($bits) % 2 != 0) {
      $parsed[] = array_pop($bits);
    }
    
    // Assign to the $this->_parts property
    $this->parts = $parsed;
  }
  
  public function __get($key)
  {
    return $this->parts[$key];
  }
  public function __set($key, $value)
  {
    $this->_parts[$key] = $value;
  }
  public function __isset($key)
  {
    return isset($this->_parts[$key]);
  }
}
?>