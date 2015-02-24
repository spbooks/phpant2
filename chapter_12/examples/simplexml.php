<?php
$url = 'http://rss.sitepoint.com/f/sitepoint_blogs_feed';
$xml = simplexml_load_file($url);
$channel = $xml->channel;
echo "Title: ", (string) $channel->title, "\n",
    "Description: ", (string) $channel->description, "\n",
    "Link: ", (string) $channel->link, "\n";
foreach ($channel->item as $item)
{
  echo "Item: ", (string) $item->title, "\n",
      "Link: ", (string) $item->link, "\n",
      "Description:\n", (string) $item->description, "\n";
}
?>