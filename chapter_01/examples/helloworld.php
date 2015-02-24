<?php
$haystack = 'Hello World!';
$needle   = 'orld';
// Use the strpos() function
$position = strpos($haystack, $needle);
echo 'The substring "' . $needle . '" in "' .
    $haystack . '" begins at character ' . $position;
?>