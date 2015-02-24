<?php
$doc = new SimpleXMLElement(
    'http://rss.sitepoint.com/f/sitepoint_blogs_feed', 
    null, 
    true    // tell SimpleXML that we're supplying a URL
);
// search for titles with an item parent
foreach ($doc->xpath('//item/title') as $title)
{ 
    echo $title, "\n";
}
?>