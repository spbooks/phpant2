<?php
// JpGraph does not work with notices enabled
error_reporting(E_ALL ^ E_NOTICE);

// Include the necessary JpGraph libraries
require_once ('jpgraph.php');       // Core engine
require_once ('jpgraph_pie.php');   // Pie graph
require_once ('jpgraph_pie3d.php'); // 3D Pie graph

// Sample sales data: could be a database query
$xdata = array('Mousemats','Pens','T-Shirts','Mugs'); // X Axis
$ydata = array (35,43,15,10);                         // Y Axis

// Set up the graph
$graph = new PieGraph(400,200,'auto');  // Width, height, cache filename
$graph->SetMarginColor('white');        // Margin color
$graph->SetShadow();                    // Use a drop shadow
$graph->SetFrame(true,'black');         // Frame color

// Set up the graph title
$graph->title->Set('March Sales');              // Title text
$graph->title->SetColor('black');               // Title color
$graph->title->SetFont(FF_VERDANA,FS_BOLD,14);  // Title font

// Set up the pie segment legend
$graph->legend->SetColor('black');      // Legend text color
$graph->legend->SetFillColor('gray');   // Legend background color
$graph->legend->Pos(0.02,0.61);         // Legend position

// Set up 3D pie chart
$pie = new PiePlot3d($ydata);  // Instantiate 3D pie with Y data
$pie->SetLegends($xdata);      // Add X data to legends
$pie->SetTheme('earth');       // Set color theme (earth|pastel|sand|water)
$pie->SetCenter(0.36);         // Center relative to X axis
$pie->SetSize(100);            // Size of pie radius in pixels
$pie->SetAngle(30);            // Set tilt angle of pie
$pie->ExplodeSlice(2);         // Pop out a slice
$pie->ExplodeSlice(3);         // Pop out another slice

// Set up values against each segment
$pie->value->SetFont(FF_VERDANA,FS_NORMAL,10); // The font
$pie->value->SetColor('black');                // Font color

// Finishing
$graph->Add($pie);  // Add bar plot to graph
$graph->Stroke();   // Send to browser
?>