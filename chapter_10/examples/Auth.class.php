<?php
/**
 * Authentication class<br />
 * Automatically authenticates users on construction<br />
 * <b>Note:</b> requires the Session class be available
 * @access public
 * @uses Session
 */
class Auth
{
  /**
   * Instance of database connection class
   * @access protected
   * @var PDO object
   */
  protected $db;

  /**
   * Configuration array
   * @access protected
   * @var array
   */
  protected $cfg;
  
  /**
   * Instance of Session class
   * @access protected
   * @var Session object
   */
  protected $session;

  /**
   * Url to re-direct to in case not authenticated
   * @access protected
   * @var string
   */
  protected $redirect;

  /**
   * String to use when making hash of username and password
   * @access protected
   * @var string
   */
  protected $hashKey;

  /**
   * Auth constructor
   * Checks for valid user automatically
   * @param object database connection
   * @param string URL to redirect to on failed login
   * @param string key to use when making hash of user name and
   *               password
   * @param boolean if passwords are md5 encrypted in database
   *               (optional)
   * @return void
   * @access public
   */
  function __construct(PDO $db, $redirect, $hashKey)
  {
    $this->db       = $db;
    $this->cfg      = parse_ini_file('access_control.ini', TRUE);
    $this->redirect = $redirect;
    $this->hashKey  = $hashKey;
    $this->session  = new Session();
    $this->login();
  }
  
  /**
   * Checks username and password against database
   * @return void
   * @access private
   */
  private function login()
  {
    //Put the cfg vars into local vars for readability
    $var_login = $this->cfg['login_vars']['login'];
    $var_pass = $this->cfg['login_vars']['password'];
    $user_table = $this->cfg['users_table']['table'];
    $user_login = $this->cfg['users_table']['col_login'];
    $user_pass = $this->cfg['users_table']['col_password'];
    
    
    // See if we have values already stored in the session
    if ($this->session->get('login_hash'))
    {
      $this->confirmAuth();
      return;
    }

    // If this is a fresh login, check $_POST variables
    if (!isset($_POST[$var_login]) ||
        !isset($_POST[$var_pass]))
    {
      $this->redirect();
    }
    
    $password = md5($_POST[$var_pass]);
    
    try
    {
      // Query to count number of users with this combination
      $sql = "SELECT COUNT(*) AS num_users " .
          "FROM " . $user_table . " WHERE " . 
          $user_login . "=:login AND " .
          $user_pass . "=:pass";
          
      $stmt = $this->db->prepare($sql);
      // bind the user input
      $stmt->bindParam(':login', $_POST[$var_login]);
      $stmt->bindParam(':pass', $password);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
      // create your own error handling logic - I will redirect.
      // If the redirect page has the capability I could alter the 
      // redirect method to handle an added error message that can
      // be passed on to the page.  for simplicity - we will skip that.
      error_log('Error in '.$e->getFile().
          ' Line: '.$e->getLine().
          ' Error: '.$e->getMessage()
      );
      $this->redirect();
    }
    // If there isn't is exactly one entry, redirect
    if ($row['num_users'] != 1)
    {    
      $this->redirect();
    // Else is a valid user; set the session variables
    }
    else
    {
      $this->storeAuth($_POST[$var_login], $password);
    }
  }
  
  /**
   * Sets the session variables after a successful login
   * @return void
   * @access public
   */
  public function storeAuth($login, $password)
  {
    $this->session->set($this->cfg['login_vars']['login'], $login);
    // remember the $password var is a MD5 - never keep the plaintext password
    $this->session->set($this->cfg['login_vars']['password'], $password);

    // Create a session variable to use to confirm sessions
    $hashKey = md5($this->hashKey . $login . $password);
    $this->session->set($this->cfg['login_vars']['hash'], $hashKey);
  }
  
  /**
   * Confirms that an existing login is still valid
   * @return void
   * @access private
   */
  private function confirmAuth()
  {
    $login = $this->session->get($this->cfg['login_vars']['login']);
    $password = $this->session->get($this->cfg['login_vars']['password']);
    $hashKey = $this->session->get($this->cfg['login_vars']['hash']);
    if (md5($this->hashKey . $login . $password) != $hashKey)
    {
      $this->logout(true);
    }
  }
  
  /**
   * Logs the user out
   * @param boolean Parameter to pass on to Auth::redirect()
   *               (optional)
   * @return void
   * @access public
   */
  public function logout($from = false)
  {
    $this->session->del($this->cfg['login_vars']['login']);
    $this->session->del($this->cfg['login_vars']['password']);
    $this->session->del($this->cfg['login_vars']['hash']);
    // For security reasons I am choosing to destroy the session 
    // here to start a completely new one.  If however you need to keep 
    // any other data in the session other than Auth data - you 
    // may choose not to do this.
    $this->session->destroy(); 
    $this->redirect($from);  
  }
  
  /**
   * Redirects browser and terminates script execution
   * @param boolean adverstise URL where this user came from
   *               (optional)
   * @return void
   * @access private
   */
  private function redirect($from = true)
  {
    if ($from)
    {
      header('Location: ' . $this->redirect . '?from=' .
          $_SERVER['REQUEST_URI']);
    }
    else
    {
      header('Location: ' . $this->redirect);
    }
    exit();
  }
}
?>