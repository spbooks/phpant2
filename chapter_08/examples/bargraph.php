<?php
// JpGraph does not work with notices enabled
error_reporting(E_ALL ^ E_NOTICE);

// Include the necessary JpGraph libraries
require_once ('jpgraph.php');       // Core engine
require_once ('jpgraph_bar.php');   // Bar graph

// Sample sales data: could be a database query
$xdata = array('Mousemats','Pens','T-Shirts','Mugs'); // X Axis
$ydata = array (35,43,15,10);                         // Y Axis

// Set up the graph
$graph = new Graph(400,200,'auto');     // Width, height,cache filename
$graph->img->SetMargin(40,20,20,40);    // Margin widths
$graph->SetScale('textlin');            // X text scale, Y linear scale
$graph->SetColor('white');              // Plot background
$graph->SetMarginColor('darkgray');     // Margin color
$graph->SetShadow();                    // Use a drop shadow
$graph->SetFrame(true,'black');         // Frame color

// Set up the graph title
$graph->title->Set('Sales Figures for March');  // Title text
$graph->title->SetColor('white');               // Title color
$graph->title->SetFont(FF_VERDANA,FS_BOLD,14);  // Title font

// Set up the X Axis
$graph->xaxis->title->Set('Product Type');              // Axis title text
$graph->xaxis->title->SetColor('black');                // Axis title color
$graph->xaxis->title->SetFont(FF_VERDANA,FS_BOLD,10);   // Axis title font
$graph->xaxis->SetTickLabels($xdata);                   // Add labels
$graph->xaxis->SetColor('black','white');               // Axis colors
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);         // Axis font
$graph->xaxis->HideTicks();                             // Hide ticks

// Set up the Y Axis
$graph->yaxis->title->Set('Units Sold');                // Axis title text
$graph->yaxis->title->SetColor('black');                // Axis title color
$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,10);   // Axis title font
$graph->yaxis->SetColor('black','white');               // Axis colors
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,8);         // Axis font
$graph->yaxis->HideTicks();                             // Hide ticks

// Create the Bar graph plot
$bplot = new BarPlot($ydata);                   // Instantiate with Y data
$bplot->SetWidth(0.75);                         // Width of bars
$bplot->SetFillColor('darkgray');		// Set bar background color

// Finishing
$graph->Add($bplot);    // Add bar plot to graph
$graph->Stroke();       // Send to browser
?>