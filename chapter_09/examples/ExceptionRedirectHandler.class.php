<?php
/**
 * Exception Handler class
 */
class ExceptionRedirectHandler
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
     * Error page to which to redirect
     * @var string 
     */
    public $redirect = 'http://www.example.com/error';
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
        header('HTTP/1.1 307 Temporary Redirect');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header('Location: ' . $self->redirect);
        exit(1);
    }

    /**
     * Log exception to {@link $_logfile}
     * 
     * @return void
     */
    public function log()
    {
        error_log(
            $this->_exception->getTraceAsString(), 
            3, 
            $this->_logFile
        );
    }
}
/**
 * Handle uncaught exceptions
 */
set_exception_handler(array('ExceptionRedirectHandler', 'handle'));