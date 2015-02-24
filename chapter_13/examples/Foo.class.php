<?php
/**
* Foo class for PHP Anthology Best Practices chapter
*
* @package Sitepoint
* @version @release-version@
* @copyright Copyright (C) 2006-Present, SitePoint Properties, Ltd.
* @author Matthew Weier O'Phinney <XXX@YYYY.ZZZ>
*/
class Foo
{
  /**
  * @var string
  */
  public $name;
  /**
  * @var boolean
  */
  public $baz = false;
  /**
  * Constructor
  *
  * @param string $name
  * @return void
  * @throws Exception with non-string $name
  */
  public function __construct($name)
  {
    if (!is_string($name) || empty($name)) {
      throw new Exception('Invalid name');
    }
    $this->name = $name;
  }
  /**
  * Bar returns an array
  *
  * @return array
  */
  public function bar()
  {
    return array(
        'baz',
        'bal',
        'boo'
    );
  }
  /**
  * Set the {@link $baz} flag
  *
  * @param boolean $flag
  * @return void
  */
  public function baz($flag)
  {
    $this->baz = ($flag) ? true : false;
  }
}
?>