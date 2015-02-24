<?php
$iniVars = parse_ini_file('example.ini', TRUE);
echo '<pre>';
print_r($iniVars);
echo $iniVars['Locations']['css'];
echo '</pre>';
?>
