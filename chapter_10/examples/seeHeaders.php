<?php
// Connect to sitepoint.com
$fp = fsockopen('www.sitepoint.com', '80');

// Send the request
fputs($fp,
    "GET /subcat/98 HTTP/1.1\r\nHost: www.sitepoint.com\r\n\r\n");

// Fetch the response
$response = '';
while (!feof($fp))
{
  $response .= fgets($fp, 128);
}
fclose($fp);

// Convert HTML to entities
$response = htmlspecialchars($response);

// Display the response
echo nl2br($response);
?>

