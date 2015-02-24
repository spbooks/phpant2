<?php
require_once 'Zend/XmlRpc/Client.php';
try
{
  $client = new Zend_XmlRpc_Client('http://localhost/phpant2/chapter_12/examples/zend_xmlrpc_serv.php');
  $proxy = $client->getProxy();
  $add = $proxy->math->add(array(1,2));
  $mult = $proxy->math->multiply(array(21343243346,989554365486));
  echo '1 + 2 = ' . $add . "<br />";
  echo '21343243346 * 989554365486 = ' . $mult;
}
catch (Zend_XmlRpc_Client_FaultException $e)
{
  echo $e->getMessage();
}
?>