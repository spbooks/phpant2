<?php
/**
 * RSS parser using XMLReader
 */
class Rss_XmlReader
{
  /**#@+
   * Channel metadata
   * @var string
   */
  public $channelTitle = '';
  public $channelDesc  = '';
  public $channelLink  = '';
  /**#@-*/
  /**
   * Individual item data
   * @var array
   */
  public $items = array();
  /**
   * Actual current XML feed
   * @var string
   */
  public $xml;
  /**
   * Create new object and optionally load feed
   * 
   * @param string $url Optional
   * @return void
   */
  public function __construct($url = null)
  {
    if (null !== $url)
    {
      $this->load($url);
    }
  }

  /**
  * Load feed and parse it
  * 
  * @param string $url URL or file resource
  * @return void
  */
  public function load($url)
  {
    $this->xml = file_get_contents($url);
    $xr = new XMLReader();
    $xr->XML($this->xml);
    $this->channelTitle = '';
    $this->channelDesc = '';
    $this->channelLink = '';
    $this->items = array();
    while ($xr->read())
    {
      if (XMLReader::ELEMENT == $xr->nodeType)
      {
        switch ($xr->localName)
        {
          case 'channel':
            $this->_getChannelInfo($xr);
            break;
          case 'item':
            $this->_getItem($xr);
            break;
        }
      }
    }
  }

  /**
   * Parse channel information
   * 
   * @param XMLReader $xr 
   * @return void
   */
  protected function _getChannelInfo($xr)
  {
    while ($xr->read() && ($xr->depth == 2))
    {
      if (XMLReader::ELEMENT == $xr->nodeType)
      {
        switch ($xr->localName)
        {
          case 'title':
            $xr->read();
            $this->channelTitle = $xr->value;
            break;
          case 'description':
            $xr->read();
            $this->channelDesc = $xr->value;
            break;
          case 'link':
            $xr->read();
            $this->channelLink = $xr->value;
            break;
        }
      }
    }
  }

  /**
   * Parse RSS item
   * 
   * @param XMLReader $xr 
   * @return void
   */
  protected function _getItem($xr)
  {
    $title = '';
    $link  = '';
    $desc  = '';
    $date  = '';
    while ($xr->read() && ($xr->depth > 2))
    {
      if (XMLReader::ELEMENT == $xr->nodeType)
      {
        switch ($xr->localName)
        {
          case 'title':
            $xr->read();
            $title = $xr->value;
            break;
          case 'description':
            $xr->read();
            $desc = $xr->value;
            break;
          case 'link':
            $xr->read();
            $link = $xr->value;
            break;
          case 'date':
            $xr->read();
            $date = $xr->value;
            break;
        }
      }
    }
    $this->items[] = array(
      'title' => $title,
      'link'  => $link,
      'desc'  => $desc,
      'date'  => $date
    );
  }
}
?>