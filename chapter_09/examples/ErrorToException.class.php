<?php
/**
 * Error -> Exception Handling
 */
class ErrorException extends Exception 
{
  /**
   * Create an Exception from an Error
   *
   * Throws an Exception from a PHP error (if the PHP error
   * handler has been set to this method).
   *
   * @static
   * @access public
   * @throws ErrorException
   */
  public static function handle($errno, $errstr)
  {
    throw new self($errstr, $errno);
  }
}
?>