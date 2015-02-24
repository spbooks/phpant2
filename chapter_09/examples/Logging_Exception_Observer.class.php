<?php
require 'Exception_Observer.class.php';
require 'Observable_Exception.class.php';

/**
 * Sample exception observer: log exception trace to file
 * 
 * @uses Exception_Observer
 */
class Logging_Exception_Observer implements Exception_Observer
{
  /**
   * Log filename
   * @var string 
   */
  protected $_filename = '/tmp/exception.log';

  /**
   * Constructor
   *
   * If filename provided, use it for logging.
   * 
   * @param string $filename 
   * @return void
   */
  public function __construct($filename = null)
  {
    if ((null !== $filename) && is_string($filename))
    {
      $this->_filename = $filename;
    }
  }

  /**
   * Log exceptions
   * 
   * @param My_Exception $e 
   * @return void
   */
  public function update(Observable_Exception $e)
  {
    error_log($e->getTraceAsString(), 3, $this->_filename);
  }
}
?>