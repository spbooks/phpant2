<?php
// to remove the E_STRICT errors
error_reporting(E_ALL);
require_once "HTML/Table/Matrix.php";
define("EMPTY_COLUMN", "");
$months = array("January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December");

if (isset($_GET['month']) && in_array($_GET['month'], $months)) 
{
  $month = $_GET['month'];
}
else
{
 $month = date("F"); 
}
    
if (isset($_GET['year']) && is_numeric($_GET['year']) && $_GET['year'] >= 1970 && $_GET['year'] <= 2038)
{
  $year = $_GET['year'];
}
else
{
  $year = date("Y");
}
$start_date = strtotime("$month 1st $year");
$end_date = strtotime("$month " .date("t", $start_date). " $year");
$date_range = range(1, date("t", $start_date));
$previous_month = strtotime("-1 month", $start_date);
$next_month = strtotime("+1 month", $start_date);
$previous_year = strtotime("-1 year", $start_date);
$next_year = strtotime("+1 year", $start_date);
$html = "<a href='" .$_SERVER['SCRIPT_NAME']. "?month=%s&amp;year=%s'>%s</a>";

if (date("Y", $previous_year) >= 1970)
{
  $calendar_data[] = sprintf($html, date("F", $start_date), date("Y", $previous_year), date("Y", $previous_year));
}
else
{
  $calendar_data[] = EMPTY_COLUMN;
}

$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = date("Y", $start_date);
$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = EMPTY_COLUMN;

if (date("Y", $next_year) < 2038 && date("Y", $next_year) != 1969)
{
  $calendar_data[] = sprintf($html, date("F", $start_date), date("Y", $next_year), date("Y", $next_year));
}
else
{
  $calendar_data[] = EMPTY_COLUMN;
}

$calendar_data[] = sprintf($html, date("F", $previous_month), date("Y", $previous_month), date("M", $previous_month));
$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = date("M", $start_date);
$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = EMPTY_COLUMN;
$calendar_data[] = sprintf($html, date("F", $next_month), date("Y", $next_month), date("M", $next_month));
$calendar_data[] = "Mon";
$calendar_data[] = "Tue";
$calendar_data[] = "Wed";
$calendar_data[] = "Thu";
$calendar_data[] = "Fri";
$calendar_data[] = "Sat";
$calendar_data[] = "Sun";
$blank_days = date("N", $start_date);

for ($i = 1; (int) $blank_days > $i; $i++)
{
  $calendar_data[] = EMPTY_COLUMN;
}
foreach ($date_range as $day)
{
  $calendar_data[] = $day;
}

$calendar = new HTML_Table_Matrix();
$calendar->setTableSize(8,7);
$calendar->setData($calendar_data);
$filler = HTML_Table_Matrix_Filler::factory("LRTB", $calendar);
$calendar->accept($filler);
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>PHP Calendar</title>
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
      #cal table {
        border-collapse: collapse;
      }
      #cal table td {
        border: 1px solid #C0C0C0;
        padding: 3px;
        width: 20px;
      }
    </style>
  </head>
  <body>
    <h1>PHP Calendar</h1>
    <div id="cal">
    <?php echo $calendar->toHTML(); ?>
    </div>
  </body>
</html>