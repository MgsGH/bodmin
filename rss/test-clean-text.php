<?php


include_once "helpers/rssSql.php";
include_once "helpers/rss_functions.php";

$connection = rss_getADBConnection();
$days = rss_getDaysWithNews($connection);

$numberOfNews = 5;
for ($i = 0; $i <= $numberOfNews; $i++){

    $day = mysqli_fetch_assoc($days);
    $dag = $day['DAG'];
    $rssDate = $day['RSSDATE'];
    $baseURL = 'https://www.falsterbofagelstation.se/news/dagbok/log_read.php?valdag=';
    $guid = $baseURL . $dag;

    $text = rss_getTextForDay($dag);
    $originalText = $text;
    $text = cleanUpText($text);

    $ringingText = rss_getRingingInfo($connection, $dag);
    $ringingText = cleanUpText($ringingText);

    $text = $text . '<br/>' . $ringingText;

    /*
        $text = str_replace('<img src= "https://www.falsterbofagelstation.', '<img src="https://www.falsterbofagelstation.', $text);
        $text = str_replace('.jpg" >', '.jpg">', $text);

    */
    //$text = htmlspecialchars($text);

    echo("<p>");
    var_dump($text);
    echo("</p>");

}

function cleanUpText($s){

    $s = str_replace('title="" alt="" ', '', $s);
    $s = str_replace(' class="bildram2"', '', $s);
    $s = utf8_encode($s);
    $s = tidy_repair_string($s, array(
        'indent'         => true,
        'output-html'   => true,
        'wrap'           => 1024,
        'show-body-only' => true,
        'clean' => true,
        'input-encoding' => 'latin1',
        'output-encoding' => 'utf8',
        'logical-emphasis' => false,
        'bare' => true,
    ));

    return $s;

}



