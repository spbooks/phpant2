<?php
// Include PEAR::Archive_Tar
require_once 'Archive/Tar.php' ;

// Instantiate Archive_Tar to compress
$tar = new Archive_Tar('demo.tar.gz', 'gz');

// An array of files to archive
$files = array(
  'example.ini',
  'writeSecureScripts.html'
);

// Create the archive file
$tar->create($files);

echo 'Archive created';


// Instantiate Archive_Tar to extract
$tar2 = new Archive_Tar('demo.tar.gz');
// Create the archive file
$tar2->extract('demo');

echo 'Archive extracted';
?>

