<?php
require 'rsssource.php.inc';

$document = new DOMDocument('1.0', 'UTF-8');
$rss = $document->createElement('rss');
$rss->setAttribute('version', '2.0');
$channel = $document->createElement('channel');
$title = $document->createElement('title', 'PHP XML Extensions');
$description = $document->createElement('description', 'Information and examples for using the PHP XML extensions');
$link = $document->createElement('link', 'http://example.com/extensions/xml/');
$channel->appendChild($title);
$channel->appendChild($description);
$channel->appendChild($link);
foreach ($extensions as $extension)
{
  $item = $document->createElement('item');
  $title = $document->createElement('title', $extension['title']);
  $description = $document->createElement('description', $extension['description']);
  $link = $document->createElement('link', $extension['link']);
  $item->appendChild($title);
  $item->appendChild($description);
  $item->appendChild($link);
  $channel->appendChild($item);
}
$rss->appendChild($channel);
$document->appendChild($rss);
echo $document->saveXML();
?>