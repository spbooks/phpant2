<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PHP String Functions</title>
    <meta http-equiv="Content-type"
        content="text/html; charset=iso-8859-1" />
    <style type="text/css">
      body {
        font-family: Tahoma, Arial, Helvetica, sans-serif;
        font-size: 11px;
      }
      h1 {
        font-size: 1.2em;
        color: navy;
      }
      h2 {
        font-size: 1em;
        color: navy;
      }
      .example {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #C0C0C0;
      }
      code {
        color: #666;
      }
    </style>
  </head>
  <body>
    <h1>PHP String Functions</h1>
    <h2>Example: variable interpolation</h2>
    <div class="example">
    <?php
    $who = 'world';
    echo "Hello $who";
    ?>
    </div>
    
    <div class="example">
    <?php
    $user = array(
        "first_name" => "Davey",
        "last_name" => "Shafik"
    );
    // Using Braces
    echo "Hello {$user['first_name']} {$user['last_name']}";
    // Using Concatenation
    echo 'Hello ' . $user['first_name'] .' '. $user['last_name'];
    ?>
    </div>

    <h2>Example: Strings as arrays</h2>    
    <div class="example">
    <?php
    $string = 'Hello World!';
    $length = strlen($string);
    for ($i = 0; $i < $length; $i++)
    {
      echo $string[$i] . '<br />';
    }
    ?>
    </div>

    <h2>Example: <code>rawurlencode</code> and <code>htmlentities</code></h2>    
    <div class="example">
    <?php
    $text = "Ben & Jerrys Ice Cream";
    echo '<a href="/buy/' . rawurlencode($text) . '">Buy ' .htmlentities($text). '</a>';
    ?>
    </div>
    
    <div class="example">
    <?php
    $quote = '"So long, and thanks for all the fish!"';
    ?>
    
    <input type="text" name="fave_quote" value="<?php echo htmlentities($quote); ?>" />
    </div>
    
    <h2>Example: <code>nl2br</code></h2>
    <div class="example">
    <?php
    echo nl2br("<p>Dear Sir or Madam,
    This is my nicely formatted letter. I hope that it really impresses you.
    
    Look! I've started a new paragraph.
    Yours faithfully,
    Mike Format</p>");
    ?>
    </div>
    
    <h2>Example: <code>strip_tags</code></h2>
    <div class="example">
    <?php
    $text = 'This is <b>bold</b> and this is <i>italic</i>. What about this <a href="http://www.php.net/">link</a>?';
    echo strip_tags($text);
    ?>
    </div>
    
    <div class="example">
    <?php
    $text = 'This is <b>bold</b> and this is <i>italic</i>. What about this <a href="http://www.php.net/">link</a>?';
    echo strip_tags($text, '<b><i>');
    ?>
    </div>

    <h2>Example: <code>wordwrap</code></h2>    
    <div class="example">
    <?php
    $string = "This is a long sentence that will be cut at sixty characters automatically. Don't worry, no words will be broken up.";
    echo wordwrap($string, 60, "<br />");
    ?>
    </div>
    
    <h2>Example: <code>str_replace</code></h2>      
    <div class="example">
    <?php
    $word = 'general-purpose';
    $text = <<<EOD
PHP (recursive acronym for "PHP: Hypertext Preprocessor") is a widely used Open Source general-purpose scripting language.
EOD;
    
    echo str_replace($word, '<strong>' . $word . '</strong>', $text);
    ?>
    </div>
    
    <h2>Example: <code>strpos</code> and <code>substr_replace</code></h2> 
    <div class="example">
    <?php
    // Places part of a string inside an HTML tag
    function addTag($text, $word, $tag)
    {
      $length = strlen($word);
      $start  = strpos($text, $word);
      $word   = '<' . $tag . '>' . $word . '</' . $tag . '>';
      return substr_replace($text, $word, $start, $length);
    }
    $text = <<<EOD
PHP (recursive acronym for "PHP: Hypertext Preprocessor") is a widely used Open Source general-purpose scripting language.
EOD;
    
    echo addTag($text, 'general-purpose', 'strong');
    ?>
    </div>

    <h2>Example: <code>explode</code> and <code>implode</code></h2>    
    <div class="example">
    <?php
    $text = <<<EOD
This will be row 1
This will be row 2
This will be row 3
This will be row 4
EOD;
    
    $lines = explode(PHP_EOL, $text);
    echo '<table border="1">' .PHP_EOL;
    foreach ($lines as $line)
    {
      echo '<tr>' .PHP_EOL. '<td>' .$line. '</td>' .PHP_EOL. '</tr>' .PHP_EOL;
    }
    echo '</table>' .PHP_EOL;
    echo implode($lines, PHP_EOL);
    ?>
    
    </div>

    <h2>Example: <code>trim</code></h2>    
    <div class="example">
    <?php
    $string = '  This has whitespace at both ends   ';
    // Remove that whitespace
    $string = trim($string);
    if (strlen($string) > 0) {
      echo "OK!";
    }
    ?>
    </div>

    <h2>Example: <code>printf</code></h2>    
    <div class="example">
    <?php
    $fruit = array('banana', 'mango', 'pear');
    $price = array('30', '50', '35');
    
    // A string with formatting
    $format = 'A %s costs %d cents.<br />';
    
    for ($i = 0; $i < 3; $i++) {
      printf($format, $fruit[$i], $price[$i]);
    }
    ?>
    </div>
    <div class="example">
    <?php
    $format = '%2$d cents will buy you a %1$s.<br />';
    
    for ($i = 0; $i < 3; $i++) {
      printf($format, $fruit[$i], $price[$i]);
    }
    ?>
    </div>
    <div class="example">
    <?php
    $format = "%2\$d cents will buy you a %1\$s.<br />\n";
    
    for ($i = 0; $i < 3; $i++) {
      printf($format, $fruit[$i], $price[$i]);
    }
    
    ?>
    </div>
  </body>
</html>