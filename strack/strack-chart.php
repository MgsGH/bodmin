<?php
session_start();

require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_line.php');
require_once ('../jpgraph/src/jpgraph_bar.php');

$antalString = $_SESSION['nabben-antal'];
$arString = $_SESSION['nabben-ar'];
$fiveString = $_SESSION['nabben-antal-five'];
$fiveYearsString = $_SESSION['nabben-ar-five'];

unset($_SESSION['nabben-antal']);
unset($_SESSION['nabben-ar']);
unset($_SESSION['nabben-antal-five']);
unset($_SESSION['nabben-ar-five']);

$antal = explode(",", $antalString);
$ar = explode(",", $arString);
$five = explode(",", $fiveString);
$fiveYearAverageYears = explode(",", $fiveYearsString);

// Create the graph. These two calls are always required
$graph = new Graph(420,290);
$graph->SetScale('int');
$graph->SetScale('lin');
$graph->img->SetMargin(50,20,20,20);

//ändra marginal- och bakgrundsfärg
$graph->SetMarginColor('white');
$graph->SetFrame(0);

// Create the linear plot
$lplot=new LinePlot($five,$fiveYearAverageYears);
$lplot->SetColor("blue");
$lplot->SetWeight(3);
$lplot->mark->SetType(MARK_IMG_MBALL, 'blue', 0.4);

//Center the line plot in the center of the bars
$lplot->SetBarCenter();

$bplot=new BarPlot($antal, $ar);
$bplot->SetFillColor('lightskyblue1');
$bplot->SetColor('blue');
$bplot->SetWidth(0.7);


// Add the plot(s) to the graph
$graph->Add($bplot);
$graph->Add($lplot);

// Display the graph
$graph->Stroke();
?>

PHP Fatal error:  Uncaught TypeError: Argument 1 passed to JpGraphException::defaultHandler() must be an instance of Exception, instance of Error given in C:\\xampp\\apps\\fbo\\htdocs\\jpgraph\\jpgraph_errhandler.inc.php:158\nStack trace:\n#0 [internal function]: JpGraphException::defaultHandler(Object(Error))\n#1 {main}\n  thrown in C:\\xampp\\apps\\fbo\\htdocs\\jpgraph\\jpgraph_errhandler.inc.php on line 158, referer: http://fbo.localhost/tests/chart-test.php



