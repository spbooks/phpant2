<?php
class Foo
{
  public function bar()
  {
    echo 'Do';
  }
}

class MyFoo extends Foo
{
  public function bar()
  {
    parent::bar();
    echo ' more!';
  }
}

class FooTest extends PHPUnit_Framework_TestCase
{
  /**
  * Foo Object
  * @var Foo
  */
  protected $_foo;

  /**
  * Setup environment
  */
  public function setUp()
  {
    $this->_foo = new Foo();
  }

  /**
  * Teardown environment
  */
  public function tearDown()
  {
    unset($this->_foo);
  }
  /**
  * Test the bar() method
  */
  public function testBar()
  {
    // test method body
  }
}
?>