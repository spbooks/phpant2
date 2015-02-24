<?php
$doc = new DOMDocument;
$doc->preserveWhiteSpace = false;
$doc->load('http://rss.sitepoint.com/f/sitepoint_blogs_feed');
$xpath = new DOMXPath($doc);
// Grab all item titles
// search for titles with an item parent
$titles = $xpath->query('//item/title'); 
foreach ($titles as $title)
{
    echo $title->nodeValue, "\n";
}
?>