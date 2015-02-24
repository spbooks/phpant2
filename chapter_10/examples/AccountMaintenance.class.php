<?php
/**
 * AccountException Class<br />
 * Base custom exception class for the AccountMaintenance class.<br />
 * Ensures consistent logging to error_log for all exceptions.
 * @see AccountMaintenance <br />
 * @access public
 */
class AccountException extends Exception
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
 * AccountDatabaseException Class<br />
 * Indicates database exception.<br />
 * @see AccountException
 * @access public
 */
class AccountDatabaseException extends AccountException {}
/**
 * AccountUnknownException Class<br />
 * Indicates account could not be found.<br />
 * @see AccountException
 * @access public
 */
class AccountUnknownException extends AccountException {}
/**
 * AccountPasswordException Class<br />
 * Indicates problem generating password.<br />
 * @see AccountException
 * @access public
 */
class AccountPasswordException extends AccountException {}
/**
 * AccountPasswordResetException Class<br />
 * Indicates problem resetting password.<br />
 * @see AccountException
 * @access public
 */
class AccountPasswordResetException extends AccountException {}

/**
 * AccountMaintenance Class<br />
 * Provides functionality for users to manage their own accounts
 * <b>Note:</b> requires the Session and Auth class be available
 * @access public
 * @uses Session
 * @uses Auth
 */
class AccountMaintenance
{
  /**
   * Database connection
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
   * A list of words to use in generating passwords
   * @access protected
   * @var array
   */
  protected $words;

  /**
   * AccountMaintenance constructor
   * @param object instance of database connection
   * @access public
   */
  public function __construct(PDO $db)
  {
    $this->db  = $db;
    $this->cfg = parse_ini_file('access_control.ini', TRUE);
  }

  /**
   * Given a username / email combination, resets the password
   * for that user and returns the new password.
   * @param string login name
   * @param string email address
   * @return array of user details
   * @throws AccountDatabaseException
   * @throws AccountUnknownException
   * @throws AccountResetPasswordException
   * @access public
   */
  public function resetPassword($login, $email)
  {
    //Put the cfg vars into local vars for readability
    $user_table = $this->cfg['users_table']['table'];
    $user_id = $this->cfg['users_table']['col_id'];
    $user_login = $this->cfg['users_table']['col_login'];
    $user_pass = $this->cfg['users_table']['col_password'];
    $user_email = $this->cfg['users_table']['col_email'];
    $user_first = $this->cfg['users_table']['col_name_first'];
    $user_last = $this->cfg['users_table']['col_name_last'];
    $user_sig = $this->cfg['users_table']['col_signature'];
    
    try
    {
      $sql = "SELECT " . $user_id . ",
          " . $user_login . ", " . $user_pass . ",
          " . $user_first . ", " . $user_last . "
          FROM
          " . $user_table . "
          WHERE
          " . $user_login . "=:login
          AND
          " . $user_email . "=:email";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':login', $login);
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
      throw new AccountDatabaseException('Database error when finding' .
          ' user: '.$e->getMessage());
    }
    
    if (count($row) != 1)
    {
      throw new AccountUnknownException('Could not find account'); 
    }
    
    try
    {
      $password = $this->generatePassword();
      $sql = "UPDATE " . $user_table . "
          SET
          " . $user_pass . "=:pass
          WHERE
          " . $user_id . "=:id";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':pass',md5($password));
      $stmt->bindParam(':id', $row[0][$user_id]); 
      $stmt->execute();
    }
    catch (AccountPasswordException $e)
    {
      throw new AccountResetPasswordException('Error when generating' .
          ' password: '.$e->getMessage()); 
    }
    catch (PDOException $e)
    {
      throw new AccountDatabaseException('Database error when resetting' .
          ' password: '.$e->getMessage());  
    }
    $row[0][$user_pass] = $password;
    return $row;
  }
  
  /**
   * Add a list of words to generate passwords with
   * @param array
   * @return void
   * @access public
   */
  public function addWords($words)
  {
    $this->words = $words;
  }

  /**
   * Generates a random but memorable password
   * @return string the password
   * @throws AccountPasswordException
   * @access protected
   */
  protected function generatePassword()
  {
    $count = count($this->words);
    if ($count == 0)
    {
      throw new AccountPasswordException('No words to use!');
    }  
    mt_srand((double)microtime() * 1000000);
    $seperators = range(0,9);
    $seperators[] = '_';
    
    $password = array();
    for ($i = 0; $i < 4; $i++) {
      if ($i % 2 == 0) {
        shuffle($this->words);
        $password[$i] = trim($this->words[0]);
      } else {
        shuffle($seperators);
        $password[$i] = $seperators[0];
      }
    }
    shuffle($password);
    return implode('', $password);
  } 
  
  /**
   * Changes a password both in the database
   * and in the current session variable.
   * Assumes the new password has been
   * validated correctly elsewhere.
   * @param Auth instance of the Auth class
   * @param string old password
   * @param string new password
   * @throws AccountDatabaseException
   * @throws AccountUnknownException
   * @access public
   */
  public function changePassword($auth, $oldPassword, $newPassword)
  {
    //Put the cfg vars into local vars for readability
    $var_login = $this->cfg['login_vars']['login'];
    $user_table = $this->cfg['users_table']['table'];
    $user_login = $this->cfg['users_table']['col_login'];
    $user_pass = $this->cfg['users_table']['col_password'];
    
    // Instantiate the Session class
    $session = new Session();
    try
    {
      // Check the the login and old password match
      $sql = "SELECT *
          FROM " . $user_table . "
          WHERE
          " . $user_login . " = :login
          AND
          " . $user_pass . " = :pass";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':login', $session->get($var_login));
      $stmt->bindParam(':pass', md5($oldPassword));
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
      throw new AccountDatabaseException('Database error when finding' .
          ' user: '.$e->getMessage()); 
    }
    if (count($result) != 1)
    {
      throw new AccountUnknownException('Could not find account'); 
    }
    
    try
    { 
      // Update the password
      $sql = "UPDATE " . $user_table . "
          SET
          " . $user_pass . " = :pass
          WHERE
          " . $user_login . " = :login";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':login', $session->get($var_login));
      $stmt->bindParam(':pass', md5($newPassword));
      $stmt->execute();
      $auth->storeAuth($session->get($var_login),
        md5($newPassword));
    }
    catch (PDOException $e)
    {
      throw new AccountDatabaseException('Database error when updating' .
          ' password: '.$e->getMessage()); 
    }
  }
} 

?>