<?php
//header('Content-Type: text/xml; charset=UTF-8');

include_once "helpers/rssSql.php";
include_once "helpers/rss_functions.php";

$connection = rss_getADBConnection();
$days = rss_getDaysWithNews($connection);

$xmlStr = '<?xml version="1.0" encoding="UTF-8" ?>';
$xmlStr =  $xmlStr . '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">';

$xmlStr =  $xmlStr . '<channel>';
$xmlStr =  $xmlStr . '
  <title>Falsterbo Fågelstation - Dagboken</title> 
  <link>https://www.falsterbofagelstation.se</link>
  <description>Dagliga uppdateringar från stationen</description> 
  <atom:link href="https://www.falsterbofagelstation.se/news/dagbok/rss/rss.xml" rel="self" type="application/rss+xml" />
  ';

$numberOfNews = 5;
for ($i = 0; $i <= $numberOfNews; $i++){

    $day = mysqli_fetch_assoc($days);
    $dag = $day['DAG'];
    $rssDate = $day['RSSDATE'];
    $baseURL = 'https://www.falsterbofagelstation.se/news/dagbok/log_read.php?valdag=';
    $guid = $baseURL . $dag;

    $text = rss_getTextForDay($dag);
    $text = cleanUpText($text);

    $ringingText = rss_getRingingInfo($connection, $dag);


    $text = $text . '<p>' . $ringingText . '</p>';
    $text = htmlspecialchars($text);

    $xmlStr = $xmlStr . '<item>';
    $xmlStr = $xmlStr . '<title>Dagboken - ' . $dag . '</title>';
    $xmlStr = $xmlStr . '<pubDate>'.$rssDate.'</pubDate>';
    $xmlStr = $xmlStr . '<guid>'.$guid.'</guid>';
    $xmlStr = $xmlStr . '<link>'.$guid.'</link>';
    $xmlStr = $xmlStr . '<description>'.$text.'</description>';
    $xmlStr = $xmlStr . '</item>';

}

$xmlStr = $xmlStr . '</channel>
</rss>
';

$myFile = fopen("rss.xml", "w");
fwrite($myFile, $xmlStr);
fclose($myFile);


var_dump($xmlStr);
echo "<br/>";
echo "Dooone";


function cleanUpText($s)
{

    $s = str_replace('<br>', '<br/>', $s);
    $s = str_replace('title="" alt="" ', '', $s);
    $s = str_replace(' class="bildram2"', '', $s);
    $s = utf8_encode($s);

    return $s;
}
