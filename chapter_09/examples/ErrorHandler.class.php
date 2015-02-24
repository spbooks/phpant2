<?php
/**
 * Error Handler class
 *
 * Handles E_USER_ERROR, E_USER_WARNING, E_WARNING, E_USER_NOTICE,
 * and E_NOTICE errors.
 */
class ErrorHandler
{
  /**
   * Location of NOTICE log
   * @var string
   */
  protected $_noticeLog = '/tmp/notice.log';

  /**
   * Error message
   * @var string
   */
  public $message = '';

  /**
   * Filename where error occurred
   * @var string
   */
  public $filename = '';

  /**
   * Line number in {@link $file} where error occurred
   * @var int
   */
  public $line = 0;

  /**
   * Error variable context
   * @var array
   */
  public $vars = array();

  /**
   * Constructor
   *
   * @return void
   */
  public function __construct($message, $filename, $linenum, $vars)
  {
    $this->message  = $message;
    $this->filename = $filename;
    $this->linenum  = $linenum;
    $this->vars     = $vars;
  }
  
  /**
   * Handle errors
   *
   * @param mixed $errno
   * @param mixed $errmsg
   * @param mixed $filename
   * @param mixed $line
   * @param mixed $vars
   * @return boolean
   */
  public static function handle($errno, $errmsg, $filename, $line, $vars)
  {
    $self = new self($errmsg, $filename, $line, $vars);
    switch ($errno) {
      case E_USER_ERROR:
        return $self->handleError();
      case E_USER_WARNING:
      case E_WARNING:
        return $self->handleWarning();
      case E_USER_NOTICE:
      case E_NOTICE:
        return $self->handleNotice();
      default:
        // Returning false tells PHP to revert control to the
        // default error handler
        return false;
    }
  }

  /**
   * Handle E_USER_ERROR
   *
   * E_USER_ERRORs are fatal. Send an email to the sysadmin, and
   * halt execution.
   *
   * @return void
   */
  public function handleError()
  {
    // Get backtrace
    ob_start();
    debug_print_backtrace();
    $backtrace = ob_get_flush();
    $body =<<<EOT
A fatal error occured in the application:
Message:   {$this->message}
File:      {$this->filename}
Line:      {$this->line}
Backtrace:
{$backtrace}
EOT;
    // Use PHP's error_log() function to send an email
    error_log($body, 1, 'sysadmin@example.com', "Fatal error occurred\n");
    exit(1); // non 0 exit status indicates script failure
  }
  
  /**
   * Handle warnings
   *
   * Warnings indicate environmental errors; email sysadmin and
   * continue
   *
   * @return boolean
   */
    public function handleWarning()
    {
      $body =<<<EOT
An environmental error occured in the application, and may indicate a
potential larger issue:
Message:   {$this->message}
File:      {$this->filename}
Line:      {$this->line}
EOT;
    // Use PHP's error_log() function to send an email
    return error_log($body, 1, 'sysadmin@example.com', "Subject: Non-fatal error occurred\n");
  }

  /**
   * Handle notices
   *
   * Notices shouldn't likely occur, but if they do, let's log
   * them.
   *
   * @return boolean
   */
    public function handleNotice()
    {
      $body =<<<EOT
A NOTICE was raised with the following information:
Message:   {$this->message}
File:      {$this->filename}
Line:      {$this->line}
EOT;
    $body = date('[Y-m-d H:i:s] ') . $body . "\n";
    // Use PHP's error logging facility, and log to a file we
    // specify; since it returns a boolean, use this as the
    // return value
    return error_log($body, 3, $this->_noticeLog);
  }
}

/**
 * Set ErrorHandler::handle() as default error handler
 */
set_error_handler(array('ErrorHandler', 'handle'));