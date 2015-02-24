<?php
/**
 * A wrapper around PHP's session functions
 * <code>
 * $session = new Session();
 * $session->set('message','Hello World!');
 * echo ( $session->get('message'); // Displays 'Hello World!'
 * </code>
 * @access public
 */
class Session
{
  /**
   * Session constructor<br />
   * Starts the session with session_start()
   * <b>Note:</b> that if the session has already started,
   * session_start() does nothing
   * @access public
   */
  public function __construct()
  {
    session_start();
  }

  /**
   * Sets a session variable
   * @param string name of variable
   * @param mixed value of variable
   * @return void
   * @access public
   */
  public function set($name, $value)
  {
    $_SESSION[$name] = $value;
  }

  /**
   * Fetches a session variable
   * @param string name of variable
   * @return mixed value of session varaible
   * @access public
   */
  public function get($name)
  {
    if (isset($_SESSION[$name]))
    {
      return $_SESSION[$name];
    }
    else
    {
      return false;
    }
  }
  
  /**
   * unsets a session variable
   * @param string name of variable
   * @return void
   * @access public
   */
  public function del($name)
  {
    unset($_SESSION[$name]);
  }

  /**
   * Destroys the whole session
   * @return void
   * @access public
   */
  public function destroy()
  { 
    $_SESSION = array();
    session_destroy();
    session_regenerate_id();
  }
} 
?>
