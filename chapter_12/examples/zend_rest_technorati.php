<?php
require_once 'Zend\Rest\client.php';
$key = YourAPIKey; // Technorati requires an API key
$technorati = new Zend_Rest_Client('http://api.technorati.com/bloginfo');
$technorati->key($key);
$technorati->url('http://sitepoint.com');
$result = $technorati->get();
echo $result->weblog->name . ' (rank: '. $result->weblog->rank . ')';


?>