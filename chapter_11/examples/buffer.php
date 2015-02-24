<?php
// Start buffering the output
ob_start();

// Echo some text (which is stored in the buffer);
echo '1. Place this in the buffer<br />';

// Get the contents of the buffer
$buffer = ob_get_contents();

// Stop buffering and clean out the buffer
ob_end_clean();

// Echo some text normally
echo '2. A normal echo<br />';

// Echo the contents from the buffer
echo $buffer;
?>