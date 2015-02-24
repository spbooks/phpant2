<?php
/**
 * UserException Class<br />
 * Base custom exception class for the User class.<br />
 * Ensures consistent logging to error_log for all exceptions.
 * @see User <br />
 * @access public
 */
class UserException extends Exception
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
 * UserDatabaseException Class<br />
 * Indicates database exception.<br />
 * @see UserException
 * @access public
 */
class UserDatabaseException extends UserException {}

/**
 * User Class<br />
 * Used to store information about users, such as permissions
 * @access public
 */
class User
{
  /**
   * Database connection
   * @access protected
   * @var  PDO object
   */
  protected $db;
  
  /**
   * Configuration array
   * @access protected
   * @var array
   */
  protected $cfg;
  
  /**
   * The id which identifies this user
   * @access protected
   * @var int
   */
  protected $userId;
  
  /**
   * First Name
   * @access protected
   * @var string
   */
  protected $firstName;
  
  /**
   * Last Name
   * @access protected
   * @var string
   */
  protected $lastName;
  
  /**
   * Email Address
   * @access protected
   * @var string
   */
  protected $email;
  
  /**
   * Permissions
   * @access protected
   * @var array
   */
  protected $permissions;

  /**
   * User constructor
   * @param object instance of database connection
   * @access public
   */
  public function __construct(PDO $db)
  {
    $this->db = $db;
    $this->cfg = parse_ini_file('access_control.ini', TRUE);
    $this->populate();
  }
 
  /**
   * Determines the user's id from the login session variable
   * @return void
   * @throws UserDatabaseException
   * @access private
   */
  private function populate()
  {
    //Put the cfg vars into local vars for readability
    $var_login = $this->cfg['login_vars']['login'];
    $user_table = $this->cfg['users_table']['table'];
    $user_id = $this->cfg['users_table']['col_id'];
    $user_login = $this->cfg['users_table']['col_login'];
    $user_email = $this->cfg['users_table']['col_email'];
    $user_first = $this->cfg['users_table']['col_name_first'];
    $user_last = $this->cfg['users_table']['col_name_last'];
    
    $session = new Session();
    try
    {
      $sql = "SELECT
          " . $user_id . ", " . $user_email . ", 
          " . $user_first . ", " . $user_last . "
          FROM
          " . $user_table . "
          WHERE
          " . $user_login . " = :login";
      $stmt = $this->db->prepare($sql);
      $login = $session->get($var_login);
      $stmt->bindParam(':login', $login);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e){
      throw new UserDatabaseException('Database error when populating' .
          ' user details: '.$e->getMessage());
    }
    $this->userId = $row[$user_id];
    $this->email = $row[$user_email];
    $this->firstName = $row[$user_first];
    $this->lastName = $row[$user_last];
  }
  
  /**
   * Returns the user's id
   * @return int
   * @access public
   */
  public function getId()
  {
    return $this->userId;
  }
 
  /**
   * Returns the users first name
   * @return string
   * @access public
   */
  public function getFirstName()
  {
    return $this->firstName;
  }
  
  /**
   * Returns the users last name
   * @return string
   * @access public
   */
  public function getLastName()
  {
    return $this->lastName;
  }
  
  /**
   * Returns the users email
   * @return string
   * @access public
   */
  public function getEmail()
  {
    return $this->email;
  }
  
  /**
   * Checks to see if the user has the named permission
   * @param string name of a permission
   * @return boolean TRUE is user has permission
   * @throws UserDatabaseException
   * @access public
   */
  public function checkPermission($permission)
  {
    // If I don't have any permissions, fetch them
    if (!isset($this->permissions))
    {
      //Put the cfg vars into local vars for readability
      $perm_table = $this->cfg['permission_table']['table'];
      $perm_id = $this->cfg['permission_table']['col_id'];
      $perm_name = $this->cfg['permission_table']['col_name'];
      $u2c_table = $this->cfg['user_to_collection_table']['table'];
      $u2c_id = $this->cfg['user_to_collection_table']['col_id'];
      $c2p_table = $this->cfg['collection_to_permission_table']['table'];
      $c2p_id = $this->cfg['collection_to_permission_table']['col_id'];
      $c2p_pid = $this->cfg['collection_to_permission_table']['col_permission_id'];
      
      try
      {
        $this->permissions = array();
        $sql = 'SELECT p.'. $perm_name .' as perm
            FROM
            ' . $u2c_table . ' uc 
            INNER JOIN ' . $c2p_table . ' cp 
            ON uc.' . $u2c_id . ' = cp.' . $c2p_id . '
            INNER JOIN ' . $perm_table . ' p
            ON cp.' . $c2p_pid . ' = p.' . $perm_id . '
            WHERE uc.user_id =:user';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user', $this->userId);
        $stmt->execute();
      
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
          $this->permissions[] = $row['perm'];
        }
      }
      catch(PDOException $e)
      {
        throw new UserDatabaseException('Database error when checking' .
          ' permissions: '.$e->getMessage());
      }
    }
    if (in_array($permission, $this->permissions))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}  
?>