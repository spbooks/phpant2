<?php
require 'rsssource.php.inc';

$rss = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0"></rss>');
$rss->addChild('channel');
$rss->channel->addChild('title', 'PHP XML Extensions');
$rss->channel->addChild('description', 'Information and examples for using the PHP XML extensions');
$rss->channel->addChild('link', 'http://example.com/extensions/xml/');
foreach ($extensions as $extension)
{
  $item = $rss->channel->addChild('item');
  $item->addChild('title', $extension['title']);
  $item->addChild('description', $extension['description']);
  $item->addChild('link', $extension['link']);
}
echo $rss->asXML();
?>