<?php
  require_once 'RequestPath.class.php';
  $request = new RequestPath();
  echo "Request action: {$request->action}</br>\n";
  echo "Request type: {$request->type}</br>\n";
  echo "Request for: {$request->for}</br>\n";
?>