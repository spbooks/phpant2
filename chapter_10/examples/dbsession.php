<?php
require_once 'DatabaseSession.class.php';

$session = new DatabaseSession('user', 'secret', 'session',
    'access_control','localhost');
session_set_save_handler(array($session, 'open'),
    array($session, 'close'),
    array($session, 'read'),
    array($session, 'write'),
    array($session, 'destroy'),
    array($session, 'gc')
); 
session_start(); 

$name = (isset($_SESSION['name']))? $_SESSION['name'] :'';

if ($name !== '')
{
    echo 'Welcome ', $name, ' to your session!';
}
else
{
    echo 'Lets start the session!';
    $_SESSION['name'] = 'PHP';
}
?>