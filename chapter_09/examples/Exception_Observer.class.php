<?php
/**
 * Exception observer interface
 */
interface Exception_Observer
{
  /**
   * Receive updates from Observable_Exception
   * 
   * @param Observable_Exception $e 
   * @return void
   */
  public function update(Observable_Exception $e);
}
?>