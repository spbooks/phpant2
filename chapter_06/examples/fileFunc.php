<html>
<head>
  <title>file Fucntion</title>
  <style type="text/css">
  .even {
    background-color:#F5F6F6;
  }
  .odd {
    background-color:#FFF;
  }
  </style>
</head>
<body>
<?php
// Read file into an array
$file = file('writeSecureScripts.html');

// Count the number of lines
$lines = count($file);

// Initialise $alt
$alt = '';

// Loop through the lines in the file
for ($i=0; $i<$lines; $i++) {
  // Creates alternating background color with a ternary
  $alt = ($alt == 'even') ? 'odd' : 'even';

  // Display the line inside a div tag
  echo '<div class="' . $alt . '">';
  // Use htmlspecialchars to see the raw HTML
  echo $i . ': ' . htmlspecialchars($file[$i]);
  echo "</div>\n";
}
?>
</body>
</html>