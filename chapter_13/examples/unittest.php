<?php
/**
* Test class for class Foo
*
* @uses PHPUnit_Framework_TestCase
* @package Sitepoint
* @subpackage UnitTests
* @copyright Copyright (C) 2006-Present, SitePoint Properties, Ltd.
* @author Matthew Weier O'Phinney <XXX@YYYY.ZZZ>
*/
class FooTest extends PHPUnit_Framework_TestCase
{
  /**
  * @var Foo
  */
  protected $_foo;
  /**
  * Setup test environment
  *
  * @return void
  */
  public function setUp()
  {
    $this->_foo = new Foo('sitepoint');
  }
  /**
  * Tear down test environment
  *
  * @return void
  */
  public function tearDown()
  {
    unset($this->_foo);
  }
  /**
  * Verify that the constructor properly sets the name attribute
  *
  * @return void
  */
  public function testConstructorSetsName()
  {
    $this->assertEquals('sitepoint', $this->_foo->name);
    $foo = new Foo('anthology');
    $this->assertEquals('anthology', $foo->name);
  }
  /**
  * Verify that non-string $name arguments cause the constructor * to throw an exception
  *
  * @return void
  */
  public function testConstructorThrowsExceptionOnBadName()
  {
    try
    {
      $foo = new Foo('');
      $this->fail('Empty string should throw exception');
    }
    catch (Exception $e)
    {
      // success
    }
    try
    {
      $foo = new Foo(array('boo', 'bar'));
      $this->fail('Array should throw exception');
    }
    catch (Exception $e)
    {
      // success
    }
    try
    {
      $foo = new Foo(new Stdclass());
      $this->fail('Object should throw exception');
    }
    catch (Exception $e)
    {
      // success
    }
    try
    {
      $foo = new Foo(true);
      $this->fail('Boolean should throw exception');
    }
    catch (Exception $e)
    {
      // success
    }
  }
  /**
  * Verify Foo::bar() returns an array containing the value 'bar'
  *
  * @return void
  */
  public function testBar()
  {
    $bar = $this->_foo->bar();
    $this->assertTrue(is_array($bar));
    $this->assertContains('bar', $bar);
  }
  /**
  * Verify that baz() sets the $baz property
  *
  * @return void */
  public function testBazSetsBazProperty()
  {
    $this->_foo->baz(true);
    $this->assertTrue($this->_foo->baz);
    $this->_foo->baz(false);
    $this->assertFalse($this->_foo->baz);
    $this->_foo->baz(1);
    $this->assertTrue($this->_foo->baz);
    $this->_foo->baz(0);
    $this->assertFalse($this->_foo->baz);
  }
}
?>