<?php

include '../aahelpers/db.php';

$date = $_GET['date'];
$lang = $_GET['lang'];
$pdo = getDataPDO();
$data = getWeatherForDateLegacyTableTest($pdo, $date, $lang);

//echo  json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
echo  json_encode($data);

