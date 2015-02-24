<?php
/**
 *  A session handling class.
 *  A custom session handling class that will save the session 
 *  data to a MySQL database using PDO.  Because of the fixed  
 *  input params to the various functions I sometimes get values  
 *  and do nothing with them.
 * 
 *  Some basic error handling has been implemented with sending 
 *  error messages to the error log.  This can of course be modified 
 *  to work with any error handling logic dictated by the
 *  business rules.
 * 
 *  @param string $sess_table
 *  @param string $sess_db
 *  @param string $sess_db_host
 *  @param string $sess_db_usr
 *  @param string $sess_db_pass
 *  @param mixed $db
 *
 *  @uses PDO
 * 
 *  @todo this has had next to no testing done on it... need to 
 *  write a couple of test scripts for it.
 */
class DatabaseSession
{
  /**
   * table with session data 
   *
   * @var string
   * @access private
   */
  private $sess_table;
  
  /**
   * database where session table is 
   * 
   * @var string
   * @access private 
   */
  private $sess_db;
  
  /**
   * the server where the session database is 
   * 
   * @var string
   * @access private 
   */
  private $sess_db_host;
  
  /**
   * the user to access the session database 
   * 
   * @var string
   * @access private
   */
  private $sess_db_usr;
  
  /**
   * the password to access the session database 
   * 
   * @var string
   * @access private 
   */
  private $sess_db_pass;
  
  /**
   * The database connection object
   * 
   * @param mixed
   * @access private 
   */
  private $db;

 	/**
 	 * Moves the database access information to class vars.
 	 * 
 	 * @param string $sess_table
 	 * @param string $sess_db
 	 * @param string $sess_db_host
 	 * @param string $sess_db_usr
 	 * @param string $sess_db_pass
 	 * @access public
 	 * @return void
 	 */
  public function __construct($sess_db_usr = 'user', 
      $sess_db_pass = 'passwd', 
      $sess_table = 'session', 
      $sess_db = 'dbname', 
      $sess_db_host = 'localhost')
  {
    $this->sess_db_usr = $sess_db_usr;
    $this->sess_db_pass = $sess_db_pass;
    $this->sess_table = $sess_table;
    $this->sess_db = $sess_db;
    $this->sess_db_host = $sess_db_host;
  }

 	/**
 	 * Open a session by making a connection to the database holding 
 	 * the session data.
 	 * Return true or false.  Writes to the default error log if 
 	 * there is a problem.
 	 * 
 	 * @param $open
 	 * @param $path
 	 * @access public
 	 * @return bool 
 	 */
  public function open($path, $name)
  {
    try
    {
      $dsn = "mysql:host={$this->sess_db_host};dbname={$this->sess_db}";
      $this->db = new PDO($dsn, $this->sess_db_usr, $this->sess_db_pass );
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
      error_log('Error connecting to the session database.');
      error_log('Reason given:'.$e->getMessage()."\n");
      return false;
    }
    return true;
  }

 	/**
 	 * close the database connection and end the session 
 	 * Return true or false.
 	 * 
 	 * @access public
 	 * @return bool
 	 */
  public function close()
  {
    $this->db = null;
    return true;
  }

 	/**
 	 * retrieve the session data from the DB and place it in a string.
 	 * Must return a string - even an empty one.  Writes to the default 
 	 * error log if there is a problem.
 	 * 
 	 * @param mixed $sess_id
 	 * @access public
 	 * @return string
 	 */
  public function read($sess_id)
  {
    try
    {
      $sql = "SELECT sess_data FROM {$this->sess_table} WHERE sess_id = :id";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(array(':id'=>$sess_id));
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    { 
      error_log('Error reading the session data table in the session reading method.');
      error_log(' Query with error: '.$sql);
      error_log(' Reason given:'.$e->getMessage()."\n");
      return ''; 
    }
    if (count($res) > 0)
    {   
      return isset($res[0]['sess_data']) ? $res[0]['sess_data'] : '';
    }
    else
    {
      return '';
    }
  }

 	/**
 	 * Insert or update session data in the DB.
 	 * Return true or false.  Writes to the default error log if 
 	 * there is a problem.
 	 * 
 	 * @param $sess_id
 	 * @param $data
 	 * @access public
 	 * @return bool
 	 */
  public function write($sess_id, $data)
  {
    try
    {
      $sql = "SELECT sess_data FROM {$this->sess_table} WHERE sess_id = :id";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(array(':id'=>$sess_id));
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)  
    { 
      error_log('Error reading the session data table in the session writing method.');
      error_log(' Query with error: '.$sql);
      error_log(' Reason given:'.$e->getMessage()."\n");
      return false; 
    }
    try
    {
      if (count($res) > 0) 
      {
        $sql = "UPDATE {$this->sess_table} SET sess_last_acc = NOW(), sess_data = :data" .
            " WHERE sess_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':id', $sess_id); 

      }
      else 
      {
        $sql ="INSERT INTO {$this->sess_table}(sess_id," .
            " sess_start, sess_last_acc," .
            " sess_data) VALUES (:id, NOW(), NOW(), :data)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $sess_id);
        $stmt->bindParam(':data', $data); 
      }
      $res = $stmt->execute();
    }
    catch (PDOException $e)
    {
      error_log('Error writing to the session data table.');
      error_log('Query with error: '.$sql);
      error_log('Reason given:'.$e->getMessage()."\n");
      return false;
    }
    return true;
  }

 	/**
 	 * Delete the session data row in the database
 	 * Return true or false.  Writes to the default error log 
 	 * if there is a problem.
 	 * 
 	 * @param $sess_id
 	 * @access public
 	 * @return bool
 	 */
  public function destroy($sess_id)
  {
    try
    {
      $sql = "DELETE FROM {$this->sess_table} WHERE sess_id = :id";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(array(':id'=>$sess_id)); 
    }
    catch (PDOException $e)
    {
      error_log('Error destroying the session.');
      error_log('Query with error: '.$sql);
      error_log('Reason given:'.$e->errorMessage()."\n");
      return false;
    }
    return true;
  }

 	/** 
 	 * Garbage collector for those that don't properly end 
 	 * a session or the session times out. Writes to the 
 	 * default error log if there is a problem.
 	 * 
 	 * @param $ttl
 	 * @access public
 	 * @return bool
 	 */
  public function gc($ttl)
  {
    $end = time() - $ttl;
    try
    {
      $sql = "DELETE FROM {$this->sess_table} WHERE sess_last_acc <:end";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(array(':id'=>$end));
    }
    catch (PDOException $e)
    {
      error_log('Error with the garbage collection method of the session class.');
      error_log('Query with error: '.$sql);
      error_log('Reason given:'.$e->getMessage());
      return false;
    }
    // may want to consider optimizing the table at a given rate to clean up all the 
    // deletes of a high traffic site - maybe use OPTIMIZE
    return true;
  }

  /**
  * class desructor
  * because of a few changes in the implementation of the way
  * sessions are closed out (after PHP v. 5.0.5) - when a page  
  * is done we now have to explicitly call the write and close 
  * ourselves.  PHP no longer does it automagically for us.
  * 
  * @param void
  * @return void
  */
  public function __destruct()
  {
    session_write_close();
  } 
}
?>