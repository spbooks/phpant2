<html>
<head>
  <title>file Fucntion</title>
  <style type="text/css">
  textarea {
    font-family: verdana;
    font-size: 12px;
    width: 400px;
    height: 300px;
  }
  </style>
</head>
  <body>
<?php
// Read file into a string
$file = file_get_contents('writeSecureScripts.html');

// Strip the HTML tags from the file
$file = strip_tags($file);
?>
    <form>
      <textarea>
<?php
// Display the file
echo htmlspecialchars($file);
?>
      </textarea>
    </form>
  </body>
</html>