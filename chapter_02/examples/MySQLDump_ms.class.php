<?php
/**
 * MySQLDump_ms Class<br />
 * Backs up a database, creating a file for each day of the week,
 * using the mysqldump utility on a Windows operating system.<br />
 * No compression is used.<br />
 * Intended for command line execution<br />
 * Requires the user executing the script has permission to execute
 * mysqldump.
 * <code>
 * $mysqlDump = new MySQLDump_ms('user', 'secret', 'world',
 *                            'c:\backups');
 * $mysqlDump->backup();
 * </code>
 * @access public
 * @uses MySQLDump
 */
require_once 'AbstractMySQLDump.class.php';
class MySQLDump_ms extends MySQLDump
{
  /**
   * The backup command to execute
   * @access private
   * @var string
   */
  protected $cmd;

   /**
    * MySQLDump_ms constructor
    * @param string dbUser (MySQL User Name)
    * @param string dbPass (MySQL User Password)
    * @param string dbName (Database to select)
    * @param string dest (directory for backup file working off of C:\)
    * @param string zip (no compression used)
    * @access public
    */
  public function __construct($dbUser, $dbPass, $dbName, $dest,
      $zip = 'none')
  {
    $fname = $dbName . '.' . date("w") . '.sql'; 
    $this->cmd = 'mysqldump -u' . $dbUser . ' -p' . $dbPass .
        ' ' . $dbName . ' >' . $dest . '\\' . $fname;
  }

}
?>