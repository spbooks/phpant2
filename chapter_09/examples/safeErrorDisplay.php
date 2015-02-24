<?php
/**
 * Error -> Exception Handling
 */
class ErrorToException extends Exception
{
  /**
   * Create an Exception from an Error
   *
   * @throws ErrorToException
   */
  public static function handle($errno, $errstr)
  {
    throw new self($errstr, $errno);
  }
}
set_error_handler(
    array('ErrorToException', 'handle'),
    E_USER_ERROR | E_WARNING | E_USER_WARNING
);

/**
 * Exception Handler class
 */
class ExceptionHandler
{
  /**
   * Exception caught
   * @var Exception
   */
  protected $_exception;
 
  /**
   * Exception log filename
   * @var string
   */
  protected $_logFile = '/tmp/exception.log';
 
  /**
   * Constructor
   *
   * @param Exception $e
   * @return void
   */
  public function __construct(Exception $e)
  {
    $this->_exception = $e;
  }
 
  /**
   * Handle exceptions
   *
   * @param Exception $e
   * @return void
   */
  public static function handle(Exception $e)
  {
    $self = new self($e);
    $self->log();
    while (@ob_end_clean());
    ob_start();
    echo $self;
    ob_end_flush();
  }
 
  /**
   * Log exception to {@link $_logfile}
   *
   * @return void
   */
  public function log()
  {
    error_log($this->_exception->getTraceAsString(), 3, $this->_logFile);
  }

  /**
   * Generate string representation of error (error page)
   *
   * @return string
   */
  public function __toString()
  {
    $message =<<<EOH
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Error</title>
  </head>
  <body>
    <h1>An error occurred in this application</h1>
    <p>
      An error occurred in this application; please try again. If
      you continue to receive this message, please
      <a href="mailto:webmaster@example.com">contact the webmaster</a>.
    </p>
  </body>
</html>
EOH;
    return $message;
  }
}

/**
 * Handle uncaught exceptions
 */
set_exception_handler(array('ExceptionHandler', 'handle'));

?>