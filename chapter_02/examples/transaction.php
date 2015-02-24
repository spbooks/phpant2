<?php
/* a hypothetical transaction at our local bank. We will move some
 * money from our saving account to our checking account (to pay for 
 * that vacation of course). If there is a problem in the middle of
 * this transaction (say after you withdraw it from the savings account
 * but before you deposit in the checking) we can roll back the
 * transaction - your money doesn't disappear and your vacation is saved.
 *
 * This is only hypothetical.
 * You will not be able to run this example without the required
 * database support.
 */
try
{
  $dbh = new PDO($dsn, $user, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);
  $dbh->beginTransaction();
  $sql = 'INSERT INTO transactions (acctNo,    
                                    type, 
                                    value, 
                                    adjustment)
                            VALUES (:acctNo,
                                    :type,
                                    :value,
                                    :adjust)';
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':acctNo'=>$acctFrom,
                        ':type'=>$withdrawal,
                        ':value'=>$amount,
                        ':adjust'=>'-'));
  $sql = 'INSERT INTO transactions (acctNo,    
                                    type, 
                                    value, 
                                    adjustment)
                            VALUES (:acctNo,
                                    :type,
                                    :value,
                                    :adjust)';
  $stmt = $dbh->prepare($sql);
  $stmt->execute(array(':acctNo'=>$acctTo,
                        ':type'=>$deposit,
                        ':value'=>$amount,
                        ':adjust'=>'+'));
  $dbh->commit();
}
catch (Exception $e)
{
  $dbh->rollBack(); 
  echo 'Exception Caught. ';
  echo 'Error with the database: <br />';
  echo 'SQL Query: ', $sql;
  echo 'Error: ' . $e->getMessage();
}
?>
