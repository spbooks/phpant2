<?php
require_once 'Zend/XmlRpc/Server.php';
require_once 'Math.class.php';

/**
 * Get some info from the server
 * 
 * @return struct
 */
function getInfo()
{
  return array(
      'publisher' => 'SitePoint',
      'title' => 'The PHP Anthology'
  );
}

$server = new Zend_XmlRpc_Server();
// Math class methods will be available in the 'math' namespace
$server->setClass('Math', 'math');    
// getInfo() function will be available as server.getInfo
$server->addFunction('getInfo', 'server');
// Handle a request
echo $server->handle();
?>