<?php
require 'rsssource.php.inc';

$xw = new xmlWriter();
$xw->openMemory(); // use openUri() to output directly to a file
$xw->startDocument('1.0', 'UTF-8');
$xw->startElement('rss');
$xw->startElement('channel');
$xw->writeElement('title', 'PHP XML Extensions');
$xw->writeElement('description', 'Information and examples for using the PHP XML extensions');
$xw->writeElement('link', 'http://example.com/extensions/xml/');
foreach ($extensions as $extension)
{
  $xw->startElement('item');
  $xw->writeElement('title', $extension['title']);
  $xw->writeElement('description', $extension['description']);
  $xw->writeElement('link', $extension['link']);
  $xw->endElement(); // item
}
$xw->endElement(); // channel
$xw->endElement(); // rss
$xml = $xw->outputMemory(true);
echo $xml;
?>