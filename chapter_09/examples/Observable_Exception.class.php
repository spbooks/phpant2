<?php
/**
 * Observable exception class
 * 
 * @uses Exception
 */
class Observable_Exception extends Exception
{
  /**
   * Array of observers
   * @var array
   */
  public static $_observers = array();
  
  /**
   * Attach an observer
   * 
   * @param Exception_Observer $observer 
   * @return void
   */
  public static function attach(Exception_Observer $observer)
  {
    self::$_observers[] = $observer;
  }
  	
  /**
   * Constructor
   *
   * Initializes exception and notifies observers
   * 
   * @param string $message 
   * @param int $code 
   * @return void
   */
  public function __construct($message = null, $code = 0)
  {
    parent::__construct($message, $code);
    $this->notify();
  }
  
  /**
   * Notify observers
   * 
   * @return void
   */
  public function notify()
  {
    foreach (self::$_observers as $observer)
    {
      $observer->update($this);
    }
  }
}
?>