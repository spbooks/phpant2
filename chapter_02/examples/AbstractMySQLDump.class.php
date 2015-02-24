<?php
/**
 * abstract MySQLDump Class<br />
 * an abstract class is to be extended from.  The extensions handle the back up 
 * of the database, and create a file for each day of the week, using 
 * the mysqldump utility.<br />
 * Intended to be extended for command line execution in conjunction with
 * cron<br />
 * @access public
 */
require_once 'MySQLDump_ms.class.php';
require_once 'MySQLDump_nix.class.php';
abstract class MySQLDump
{
  public static function factory($dbUser, $dbPass, $dbName, $dest,
      $zip)
  {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
    {
      return new MySQLDump_ms($dbUser, $dbPass, $dbName, $dest,
          $zip);
    }
    else
    {
      return new MySQLDump_nix($dbUser, $dbPass, $dbName, $dest,
          $zip);
    }
  }

  abstract public function __construct($dbUser, $dbPass, $dbName, $dest,
      $zip = 'gz');
  /**
   * Runs the constructed command
   * @access public
   * @return void
   */
  public function backup()
  {
    system($this->cmd, $error);
    if ($error)
    {
      throw new MySQLDumpException('Backup failed: Command = ' . $this->cmd . ' Error = ' . $error);
    }
  } 
}

class MySQLDumpException extends Exception {}
?>