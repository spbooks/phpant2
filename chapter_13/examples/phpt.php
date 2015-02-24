--TEST--
Foo::bar() method
--FILE--
<?php
require_once 'setup.php.inc';
$bar = $foo->bar();
assert(is_array($bar));
assert(in_array('bar', $bar));
?>
--EXPECT--