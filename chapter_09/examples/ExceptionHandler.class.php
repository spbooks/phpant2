<?php
/**
 * Exception Handler class
 *
 * Use ExceptionHandler::handle() to handle exceptions. Exceptions
 * are logged to $_logFile, and a simple error page is displayed.
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
    echo $self;
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
   * Pretty print an error message
   * 
   * @return string
   */
  public function __toString()
  {
    $message =<<<EOH
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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
?>