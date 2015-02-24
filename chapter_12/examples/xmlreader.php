<?php
require_once 'Rss_XmlReader.class.php';

$rss = new Rss_XmlReader('http://rss.sitepoint.com/f/sitepoint_blogs_feed');
echo "Title: ", $rss->channelTitle, "\n",
    "Description: ", $rss->channelDesc, "\n",
    "Link: ", $rss->channelLink, "\n";
foreach ($rss->items as $item)
{
  echo "Item: {$item['title']}\nLink: "
      . "{$item['link']}\nDescription:\n{$item['desc']}\n";
}
?>