<?php // content="text/plain; charset=utf-8"
session_start();

require_once ('../jpgraph/src/jpgraph.php');
require_once ('../jpgraph/src/jpgraph_line.php');
require_once ('../jpgraph/src/jpgraph_bar.php');

$season = $_REQUEST['season'];
if ($season == 'FA'){
    $antalString = $_SESSION['fa-antal'];
    $arString = $_SESSION['fa-ar'];
    $arFemString = $_SESSION['fa-ar-fem'];
    $antalFemString = $_SESSION['fa-antal-fem'];
    unset($_SESSION['fa-antal']);
    unset($_SESSION['fa-ar']);
    unset($_SESSION['fa-ar-fem']);
    unset($_SESSION['fa-antal-fem']);
} elseif ($season == 'FB'){
    $antalString = $_SESSION['fb-antal'];
    $arString = $_SESSION['fb-ar'];
    $arFemString = $_SESSION['fb-ar-fem'];
    $antalFemString = $_SESSION['fb-antal-fem'];
    unset($_SESSION['fb-antal']);
    unset($_SESSION['fb-ar']);
    unset($_SESSION['fb-ar-fem']);
    unset($_SESSION['fb-antal-fem']);
} elseif ($season == 'FC'){
    $antalString = $_SESSION['fc-antal'];
    $arString = $_SESSION['fc-ar'];
    $arFemString = $_SESSION['fc-ar-fem'];
    $antalFemString = $_SESSION['fc-antal-fem'];
    unset($_SESSION['fc-antal']);
    unset($_SESSION['fc-ar']);
    unset($_SESSION['fc-ar-fem']);
    unset($_SESSION['fc-antal-fem']);
}

$antal = explode(",", $antalString);
$ar = explode(",", $arString);
$five = explode(",", $antalFemString );
$fiveYearAverageYears = explode(",", $arFemString );

// Create the graph. These two calls are always required
$graph = new Graph(420,290);
$graph->SetScale('int');
$graph->SetScale('lin');

// $lm,$rm,$tm,$bm
$graph->img->SetMargin(45,20,20,20);


/*
$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
$graph->yaxis->SetTickSide(SIDE_LEFT);
$graph->yaxis->SetColor("#000080");
$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
$graph->xaxis->SetTickLabels($xdata);
$graph->xaxis->SetTextLabelInterval(2,0);
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->xaxis->SetColor("#000080");
*/

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

