<?php

/**
 * ThumbnailException Class<br />
 * Base custom exception class for the Thumbnail class.<br />
 * Ensures consistent logging to error_log for all exceptions.
 * @see Thumbnail <br />
 * @access public
 */
class ThumbnailException extends Exception
{
  public function __construct($message = null, $code = 0) 
  {
    parent::__construct($message, $code);
    error_log('Error in '.$this->getFile().
      ' Line: '.$this->getLine().
      ' Error: '.$this->getMessage()
    );
  }
}
/**
 * ThumbnailFileException Class<br />
 * Indicates file access exception.<br />
 * @see ThumbnailException
 * @access public
 */
class ThumbnailFileException extends ThumbnailException {}
/**
 * ThumbnailNotSupportedException Class<br />
 * Indicates requested MIM type is not supported.<br />
 * @see ThumbnailException
 * @access public
 */
class ThumbnailNotSupportedException extends ThumbnailException {}

/**
* Thumbnail class<br />
* Resizes images to thumbnails
* @access public
*/
class Thumbnail
{
  /**
  * Maximum width of the thumbnail in pixels
  * @access private
  * @var  int
  */
  private $maxWidth;

  /**
  * Maximum height of the thumbnail in pixels
  * @access private
  * @var  int
  */
  private $maxHeight;

  /**
  * Whether to scale image to fit thumbnail (true) or
  * strech to fit (false)
  * @access private
  * @var  boolean
  */
  private $scale;

  /**
  * Whether to inflate images smaller the the thumbnail
  * @access private
  * @var  boolean
  */
  private $inflate;

  /**
  * List of accepted image types based on MIME description
  * @access private
  * @var  array
  */
  private $types;

  /**
  * Stores function names for each image type e.g. imagecreatefromjpeg
  * @access private
  * @var array
  */
  private $imgLoaders;

  /**
  * Stores function names for each image type e.g. imagejpeg
  * @access private
  * @var array
  */
  private $imgCreators;

  /**
  * The source image
  * @access private
  * @var resource
  */
  private $source;

  /**
  * Width of source image in pixels
  * @access private
  * @var  int
  */
  private $sourceWidth;

  /**
  * Height of source image in pixels
  * @access private
  * @var  int
  */
  private $sourceHeight;

  /**
  * MIME type of source image
  * @access private
  * @var  string
  */
  private $sourceMime;

  /**
  * The thumbnail
  * @access private
  * @var  resource
  */
  private $thumb;

  /**
  * Width of thumbnail in pixels
  * @access private
  * @var  int
  */
  private $thumbWidth;

  /**
  * Height of thumbnail in pixels
  * @access private
  * @var  int
  */
  private $thumbHeight;

  /**
   * Thumbnail constructor
   * @param int max width of thumbnail
   * @param int max height of thumbnail
   * @param boolean (optional) if true image scales
   * @param boolean (optional) if true inflate small images
   * @access public
   */
  public function __construct($maxWidth, $maxHeight, $scale = true,
      $inflate = true)
  {
    $this->maxWidth = $maxWidth;
    $this->maxHeight = $maxHeight;
    $this->scale = $scale;
    $this->inflate = $inflate;
    $this->types = array('image/jpeg', 'image/png', 'image/gif');
    $this->imgLoaders = array(
        'image/jpeg' => 'imagecreatefromjpeg',
        'image/png'  => 'imagecreatefrompng',
        'image/gif' => 'imagecreatefromgif'
    );
    $this->imgCreators = array(
        'image/jpeg' => 'imagejpeg',
        'image/png'  => 'imagepng',
        'image/gif' => 'imagegif'
    );
  }

  /**
  * Loads an image from a file
  * @param string filename (with path) of image
  * @return boolean
  * @throws ThumbnailFileException
  * @throws ThumbnailNotSupportedException
  * @access public
  */
  public function loadFile ($image)
  {
    if (!$dims = @getimagesize($image))
    {
      throw new ThumbnailFileException('Could not find image: '.$image);
    }
    if (in_array($dims['mime'],$this->types))
    {
      $loader = $this->imgLoaders[$dims['mime']];
      $this->source = $loader($image);
      $this->sourceWidth = $dims[0];
      $this->sourceHeight = $dims[1];
      $this->sourceMime = $dims['mime'];
      $this->initThumb();
      return true;
    }
    else
    {
      throw new ThumbnailNotSupportedException('Image MIME type '.$dims['mime'].' not supported');
    }
  }

  /**
  * Loads an image from a string (e.g. database)
  * @param string the image
  * @param mime mime type of the image
  * @return boolean
  * @throws ThumbnailNotSupportedException
  * @throws ThumbnailFileException
  * @access public
  */
  public function loadData ($image, $mime)
  {
    if ( in_array($mime,$this->types) ) {
      if($this->source = @imagecreatefromstring($image))
      {
        $this->sourceWidth = imagesx($this->source);
        $this->sourceHeight = imagesy($this->source);
        $this->sourceMime = $mime;
        $this->initThumb();
        return true;
      }     
      else
      {     
        throw new ThumbnailFileException('Could not load image from string');
      }
    }
    else
    {
      throw new ThumbnailNotSupportedException('Image MIME type '.$mime.' not supported');
    }
  }

  /**
   * If a filename is provided, creates the thumbnail using that
   * name. If not, the image is output to the browser
   * @param string (optional) filename to create image with
   * @return boolean
   * @access public
   */
  public function buildThumb($file = null)
  {
    $creator = $this->imgCreators[$this->sourceMime];
    if (isset($file))
    {
      return $creator($this->thumb, $file);
    }
    else
    {
      return $creator($this->thumb);
    }
  }

  /**
   * Returns the mime type for the thumbnail
   * @return string
   * @access public
   */
  public function getMime()
  {
    return $this->sourceMime;
  }

  /**
   * Returns the width of the thumbnail
   * @return int
   * @access public
   */
  public function getThumbWidth()
  {
    return $this->thumbWidth;
  }
  /**
   * Returns the height of the thumbnail
   * @return int
   * @access public
   */
  public function getThumbHeight()
  {
    return $this->thumbHeight;
  }

  /**
  * Creates the thumbnail
  * @return void
  * @access private
  */
  private function initThumb ()
  {
    if ( $this->scale )
    {
      if ( $this->sourceWidth > $this->sourceHeight )
      {
        $this->thumbWidth = $this->maxWidth;
        $this->thumbHeight = floor(
            $this->sourceHeight*($this->maxWidth/$this->sourceWidth)
        );
      }
      else if ( $this->sourceWidth < $this->sourceHeight )
      {
        $this->thumbHeight = $this->maxHeight;
        $this->thumbWidth = floor(
            $this->sourceWidth*($this->maxHeight/$this->sourceHeight)
        );
      }
      else
      {
        $this->thumbWidth = $this->maxWidth;
        $this->thumbHeight = $this->maxHeight;
      }
    }
    else
    {
      $this->thumbWidth = $this->maxWidth;
      $this->thumbHeight = $this->maxHeight;
    }
    $this->thumb = imagecreatetruecolor(
        $this->thumbWidth,
        $this->thumbHeight
    );
    if ( $this->sourceWidth <= $this->maxWidth &&
            $this->sourceHeight <= $this->maxHeight &&
                $this->inflate == false )
    {
      $this->thumb = $this->source;
    }
    else
    {
      imagecopyresampled( $this->thumb, $this->source, 0, 0, 0, 0,
          $this->thumbWidth, $this->thumbHeight,
          $this->sourceWidth, $this->sourceHeight
      );
    }
  }
}
?>