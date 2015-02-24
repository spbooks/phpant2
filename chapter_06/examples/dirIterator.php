<?php
try
{
  // handle the various files in the directory like an array
  foreach ( new DirectoryIterator('./') as $Item )
  {
    echo $Item."\n";
    // tell me about this one file
    if ($Item->getFilename() == 'example.ini')
    {
      echo "\tProperties of example.ini\n";
      echo "\tFile name = "   . $Item->getFilename()  . "\n";
      echo "\tPath = "      . $Item->getPath()    . "\n";
      echo "\tPath name = "   . $Item->getPathname()  . "\n";
      echo "\tPermission = "  . $Item->getPerms()   . "\n";
      echo "\tInod = "      . $Item->getInode()   . "\n";
      echo "\tSize = "      . $Item->getSize()    . "\n";
      echo "\tOwner = "     . $Item->getOwner()   . "\n";
      echo "\tGroup = "     . $Item->getGroup()   . "\n";
      echo "\tAtime = "     . $Item->getATime()   . "\n";
      echo "\tMtime = "     . $Item->getMTime()   . "\n";
      echo "\tCTime = "     . $Item->getCTime()   . "\n";
      echo "\tType = "      . $Item->getType()    . "\n";
      echo "\tWritable = "    . $Item->isWritable()   . "\n";
      echo "\tReadable = "    . $Item->isReadable()   . "\n";
      echo "\tExecutable = "  . $Item->isExecutable() . "\n";
      echo "\tIs file = "     . $Item->isFile()     . "\n";
      echo "\tIs directory = "  . $Item->isDir()    . "\n";
      echo "\tIs link = "     . $Item->isLink()     . "\n";
      echo "\tIs dot = "    . $Item->isDot()    . "\n";
      echo "\tTo string = "   . $Item->__toString()   . "\n";
      echo '--------------------------------------------------'."\n";
      echo "\tFile contents = \n";
      readfile($Item->getPathName());
      echo '--------------------------------------------------'."\n"; 
    }
  }
  echo "\n\nAll the class methods\n";
  // give me all the methods available to the Directory Iterator
  foreach (get_class_methods('DirectoryIterator') as $methodName)
  {
    echo $methodName."\n";
  }
}
catch (Exception $e){
  // handle my exception
  echo 'No files Found!  Message returned: '.$e->getMessage()."\n";
}
?>
