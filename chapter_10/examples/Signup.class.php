<?php
/**
 * SignUpException Class<br />
 * Base custom exception class for the SignUp class.<br />
 * Ensures consistent logging to error_log for all exceptions.
 * @see SignUp <br />
 * @access public
 */
class SignUpException extends Exception
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
 * SignUpDatabaseException Class<br />
 * Indicates database exception in signup process.<br />
 * @see SignUpException
 * @access public
 */
class SignUpDatabaseException extends SignUpException {}

/**
 * SignUpNotUniqueException Class<br />
 * Indicates user already exists in signup process.<br />
 * @see SignUpException
 * @access public
 */
class SignUpNotUniqueException extends SignUpException {}

/**
 * SignUpEmailException Class<br />
 * Indicates email problem in signup confirmation process.<br />
 * @see SignUpException
 * @access public
 */
class SignUpEmailException extends SignUpException {}

/**
 * SignUpConfirmationException Class<br />
 * Indicates confirmation problem in signup process.<br />
 * @see SignUpException
 * @access public
 */
class SignUpConfirmationException extends SignUpException {}
 
 
/**
 * SignUp Class<br />
 * Provides functionality for for user sign up<br />
 * <b>Note:</b> this class requires
 * @link http://pear.php.net/package/Mail_Mime/docs Mail_Mime
 * @access public
 */
class SignUp
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
   * The name / address the signup email should be sent from
   * @access protected
   * @var array
   */
  protected $from;

  /**
   * The name / address the signup email should be sent to
   * @access protected
   * @var array
   */
  protected $to;

  /**
   * The subject of the confirmation email
   * @access protected
   * @var string
   */
  protected $subject;

  /**
   * Text of message to send with confirmation email
   * @access protected
   * @var string
   */
  protected $message;

  /**
   * Whether to send HTML email or not
   * @access protected
   * @var boolean
   */
  protected $html;

  /**
   * Url to use for confirmation
   * @access protected
   * @var string
   */
  protected $listener;

  /**
   * Confirmation code to append to $this->listener
   * @access protected
   * @var string
   */
  protected $confirmCode;

  /**
   * SignUp constructor
   * @param object instance of database connection
   * @param string URL for confirming the the signup
   * @param string name for confirmation email
   * @param string address for confirmation email
   * @param string subject of the confirmation message
   * @param string the confirmation message containing
   *     <confirm_url/>
   * @param boolean true if html email, false if text
   * @access public
   */
  public function __construct(PDO $db, $listener, $frmName, $frmAddress, $subj,
                  $msg, $html)
  {
    $this->db             = $db;
    $this->cfg            = parse_ini_file('access_control.ini', TRUE);
    $this->listener       = $listener;
    $this->from[$frmName] = $frmAddress;
    $this->subject        = $subj;
    $this->message        = $msg;
    $this->html           = $html;
  }
    /**
   * Creates the confirmation code
   * @return void
   * @access private
   */
  private function createCode($login)
  {
    srand((double)microtime() * 1000000); 
    $this->confirmCode = md5($login . time() . rand(1, 1000000));
  }
  
  /**
   * Inserts a record into the signup table
   * @param array contains user details. See constants defined for
   *              array keys
   * @return boolean true on success
   * @throws SignUpDatabaseException
   * @throws SignUpNotUniqueException
   * 
   * @access public
   */
  public function createSignup($userDetails)
  {
    //Put the cfg vars into local vars for readability
    $user_table = $this->cfg['users_table']['table'];
    $user_login = $this->cfg['users_table']['col_login'];
    $user_pass = $this->cfg['users_table']['col_password'];
    $user_email = $this->cfg['users_table']['col_email'];
    $user_first = $this->cfg['users_table']['col_name_first'];
    $user_last = $this->cfg['users_table']['col_name_last'];
    $user_sig = $this->cfg['users_table']['col_signature'];
    
    $sign_table = $this->cfg['signup_table']['table'];
    $sign_login = $this->cfg['signup_table']['col_login'];
    $sign_pass = $this->cfg['signup_table']['col_password'];
    $sign_email = $this->cfg['signup_table']['col_email'];
    $sign_first = $this->cfg['signup_table']['col_name_first'];
    $sign_last = $this->cfg['signup_table']['col_name_last'];
    $sign_sig = $this->cfg['signup_table']['col_signature'];
    $sign_code = $this->cfg['signup_table']['col_code'];
    $sign_created = $this->cfg['signup_table']['col_created'];
    
    try
    {
      // First check login and email are unique in user table
      $sql = "SELECT COUNT(*) AS num_row FROM " . $user_table . "
          WHERE
          " . $user_login . "=:login OR
          " . $user_email . "=:email";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':login', $userDetails[$user_login]);
      $stmt->bindParam(':email', $userDetails[$user_email]);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
      throw new SignUpDatabaseException('Database error when checking' .
          ' user is unique: '.$e->getMessage());
    }

    if ($result['num_row'] > 0)
    {
      throw new SignUpNotUniqueException('username and email address not unique');
    }

    $this->createCode($userDetails[$user_login]);
    $toName = $userDetails[$user_first] . ' ' . $userDetails[$user_last];
    $this->to[$toName] = $userDetails[$user_email];
    
    try
    {
      $sql = "INSERT INTO " . $sign_table . 
          "(". $sign_login . ", " . $sign_pass .
          ", " . $sign_email . ", " . $sign_first . 
          ", " . $sign_last . ", " . $sign_sig . 
          ", " . $sign_code . ", " . $sign_created . ") ".
          "VALUES (:login, :password,
          :email, :firstname, :lastname, :signature, :confirm, :time)";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':login', $userDetails[$user_login]);
      $stmt->bindParam(':password', $userDetails[$user_pass]);
      $stmt->bindParam(':email', $userDetails[$user_email]);
      $stmt->bindParam(':firstname', $userDetails[$user_first]);
      $stmt->bindParam(':lastname', $userDetails[$user_last]);
      $stmt->bindParam(':signature', $userDetails[$user_sig]);
      $stmt->bindParam(':confirm', $this->confirmCode);
      $stmt->bindParam(':time', time());
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new SignUpDatabaseException('Database error when inserting' .
          ' into signup: '.$e->getMessage());
    }
  }
  
  /**
   * Sends the confirmation email
   * @throws SignUpEmailException
   * @access public
   */
  public function sendConfirmation()
  {
    // Pear Mail_Mime included in the calling script
    $fromName = key($this->from);
    $hdrs = array(
        'From'    => $this->from[$fromName],
        'Subject' => $this->subject
    );
    $crlf = "\n"; 
  
    if ($this->html)
    {
      $replace = '<a href="' . $this->listener . '?code=' .
          $this->confirmCode . '">' . $this->listener .
          '?code=' . $this->confirmCode . '</a>';
    }
    else
    {
      $replace = $this->listener . '?code=' . $this->confirmCode;
    }
    $this->message = str_replace('<confirm_url/>',
        $replace,
        $this->message
    );

    $mime = new Mail_mime($crlf);
    $mime->setHTMLBody($this->message);
    $mime->setTXTBody(strip_tags($this->message));
    $body = $mime->get();
    $hdrs = $mime->headers($hdrs);
    $mail = Mail::factory('mail');
    $succ = $mail->send($this->to, $hdrs, $body); 
    if (PEAR::isError($succ))
    {
      throw new SignUpEmailException('Error sending confirmation email: ' .
          $succ->getDebugInfo());
    }
  }
  /**
   * Confirms a signup against the confirmation code. If it
   * matches, copies the row to the user table and deletes
   * the row from signup
   * @throws SignUpDatabaseException 
   * @throws SignUpConfirmationException
   * @access public
   */
  public function confirm($confirmCode)
  {
    //Put the cfg vars into local vars for readability
    $user_table = $this->cfg['users_table']['table'];
    $user_login = $this->cfg['users_table']['col_login'];
    $user_pass = $this->cfg['users_table']['col_password'];
    $user_email = $this->cfg['users_table']['col_email'];
    $user_first = $this->cfg['users_table']['col_name_first'];
    $user_last = $this->cfg['users_table']['col_name_last'];
    $user_sig = $this->cfg['users_table']['col_signature'];
    
    $sign_table = $this->cfg['signup_table']['table'];
    $sign_id = $this->cfg['signup_table']['col_id'];
    $sign_login = $this->cfg['signup_table']['col_login'];
    $sign_pass = $this->cfg['signup_table']['col_password'];
    $sign_email = $this->cfg['signup_table']['col_email'];
    $sign_first = $this->cfg['signup_table']['col_name_first'];
    $sign_last = $this->cfg['signup_table']['col_name_last'];
    $sign_sig = $this->cfg['signup_table']['col_signature'];
    $sign_code = $this->cfg['signup_table']['col_code'];
    
    try
    {
      $sql = "SELECT * FROM " . $sign_table . "
            WHERE " . $sign_code . "=:confirmCode";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':confirmCode', $confirmCode);
      $stmt->execute();
      $row = $stmt->fetchAll();
    }
    catch (PDOException $e)
    {
        throw new SignUpDatabaseException('Database error when inserting' .
            ' user info: '.$e->getMessage());
    }
    
    if (count($row) != 1) {
        throw new SignUpConfirmationException(count($row) . 
            ' records found for confirmation code: ' . 
            $confirmCode
        );
    }
    
    try
    {
      // Copy the data from Signup to User table
      $sql = "INSERT INTO " . $user_table . " (
          " . $user_login . ", " . $user_pass . ", 
          " . $user_email . ", " . $user_first . ",
          " . $user_last . ", " . $user_sig . ") VALUES (
          :login, :pass, :email, :firstname, :lastname, :sign )"; 
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':login',$row[0][$sign_login]);
      $stmt->bindParam(':pass',$row[0][$sign_pass]);
      $stmt->bindParam(':email',$row[0][$sign_email]);
      $stmt->bindParam(':firstname',$row[0][$sign_first]);
      $stmt->bindParam(':lastname',$row[0][$sign_last]);
      $stmt->bindParam(':sign',$row[0][$sign_sig]);
      $stmt->execute();    
      // Delete row from signup table
      $sql = "DELETE FROM " . $sign_table . "
          WHERE " . $sign_id . "= :id";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':id', $row[0][$sign_id]);
      $stmt->execute();
    }
    catch (PDOException $e)
    {
      throw new SignUpDatabaseException('Database error when inserting' .
          ' user info: '.$e->getMessage());
    }
  }
} 
?>