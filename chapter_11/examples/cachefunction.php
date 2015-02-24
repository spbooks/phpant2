<?php
  error_reporting(E_ALL ^ E_NOTICE);
  // This script uses Amazon's web service, for wich we need a developer tag:
  $amazon_devtag = '';

  // Quit if no dev tag set
  if($amazon_devtag == '')
  {
    die('You need to add your Amazon devtag in to this script. If you don\'t have one yet,' .
        ' <a href="http://aws.amazon.com/">create one here</a>');
  } 

  // Include PEAR::SOAP Client class
  require_once 'SOAP/Client.php';

  // Include PEAR::Cache_Lite_Function
  require_once 'Cache/Lite/Function.php';

  // Instantiate the SOAP_WSDL class using the online document
  $wsdl = new SOAP_WSDL('http://soap.amazon.com/schemas3/AmazonWebServices.wsdl');

  // Instantiate the amazonClient class
  $amazonClient = $wsdl->getProxy(); 

  // Define options for Cache_Lite_Function
  // NOTE: fileNameProtection = true !
  $options = array(
    'cacheDir' => './cache/',
    'fileNameProtection' => true,
    'writeControl' => true,
    'readControl' => true,
    'readControlType' => 'strlen',
    'defaultGroup' => 'SOAP'
  );

  // Instantiate Cache_Lite_Function
  $cache = new Cache_Lite_Function($options);

  // Define the paramaters to be passed to the amazon service
  $params   = array(
    'manufacturer' => 'SitePoint',
    'mode'         => 'books',
    'devtag'       => $amazon_devtag,
    'type'         => 'lite',
  );

  // Get the results through the cache
  $results = $cache->call('amazonClient->ManufacturerSearchRequest', $params);

  // Extract the collection of books from the results
  if (PEAR::isError($results))
  {
    $message = 'XMLRPC Failed: ' . $results->getMessage();
    $books = array();
  }
  else
  {
    $message = '';
    $books = $results->Details;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>SitePoint Books</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style type="text/css">
      div.book {
        float: left;
        clear: right;
        width: 300px;
        min-height: 180px;
        margin: .5em;
        border: 1px solid #444;
        background-color: #aa0;
        padding: .5em;
      }
      div.book h2 {
        font-size: 1.1em;
        font-family: sans-serif;
        margin: 0;
      }
      div.book h2 a {
        color: #00a;
      }
      div.book h2 img {
        float: left;
        margin-right: 1em;
        border: 0;
      }
      div.book p {
        font-size: .9em;
        font-family: sans-serif;
        clear: both;
      }
    </style>
  </head>
  <body>
  	<h1>SitePoint Books at Amazon</h1>
    <?php echo $message ?>
  	<?php
    foreach($books as $book)
    {
    ?>
  		<div class="book">
  			<h2><a href="<?php echo $book->Url ?>" title="View this book at Amazon"><img src="<?php echo $book->ImageUrlSmall ?>" /><?php echo $book->ProductName ?></a></h2>
  			<p class="authors">Authors: <?php echo implode( ', ', $book->Authors ) ?></p>
  			<p class="price">Price: <?php echo $book->OurPrice ?></p>
  		</div>

  	<?php
    }
    ?>
  </body>
</html>
