<?php

try
{ 
  $request = xmlrpc_encode_request(
    'math.add', 
    array(array(1,2)), 
    array('encoding' => 'UTF-8')
  ); 
  
  $context = stream_context_create(array('http' => array(
      'method' => "POST",
      'header' => "Content-Type: text/xml",
      'content' => $request
  )));
  $file = file_get_contents(
      'http://localhost/phpant2/chapter_12/examples/zend_xmlrpc_serv.php',
      false,
      $context
   );
   if(!file) {
     throw new Exception('Unable to get response from web service');
   }
  $response = xmlrpc_decode($file);
  if (is_array($response) && xmlrpc_is_fault($response))
  {
    throw new Exception($response['faultString'],$response['faultCode']);
  }
  echo '1 + 2 = ' . $response;
}
catch (Exception $e)
{
  echo $e->getMessage();
}

?>
