<?php
require_once 'Zend/Feed/Rss.php';
$url = 'http://rss.sitepoint.com/f/sitepoint_blogs_feed';
$channel = new Zend_Feed_Rss($url);
// Use function syntax to grab properties as values
echo "Title: ", $channel->title(), "\n",
    "Description: ", $channel->description(), "\n",
    "Link: ", $channel->link(), "\n";
foreach ($channel as $item)
{
  echo "Item: ", $item->title(), "\n",
      "Link: ", $item->link(), "\n",
      "Description:\n", $item->description(), "\n";
}
?>