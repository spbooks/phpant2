<?php
/**
 * Sends the Expires HTTP 1.0 header.
 * @param int number of seconds from now when page expires
 */
function setExpires($expires) {
  header('Expires: '.gmdate('D, d M Y H:i:s', time()+$expires).'GMT');
}

// Set the Expires header
setExpires(10);

// Display a page
echo ( 'This page will self destruct in 10 seconds<br />' );
echo ( 'The GMT is now '.gmdate('H:i:s').'<br />' );
echo ( '<a href="'.$_SERVER['PHP_SELF'].'">View Again</a><br />' );
?>