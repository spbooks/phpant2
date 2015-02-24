<?php
/**
 * Math methods
 */
class Math
{
    /**
     * Return the sum of all values in an array
     * 
     * @param array $values An array of values to sum
     * @return int
     */
    public static function add($method, $params)
    {
       return array_sum($params[0]);
    }
}

/**
 * Return the product of some values
 * 
 * @param string $method The XML-RPC method name called
 * @param array $params Array of parameters from the request
 * @return int
 */
function product($method, $params)
{
    return array_product($params);
}

$server = xmlrpc_server_create();
xmlrpc_server_register_method($server, 'math.add', array('Math', 'add'));
xmlrpc_server_register_method($server, 'product', 'product');
 // grab raw POST
$request = file_get_contents('php://input');
$response = xmlrpc_server_call_method($server, $request, null);
// Return response
header('Content-Type: text/xml');
echo $response;
?>