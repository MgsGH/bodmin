<?php


include_once '../aahelpers/db.php';


$lang = $_GET['lang'];
$pdo = getDataPDO();

//$data = getMostRecentWeather($pdo);
$data = getMostRecentWeatherOldTable($pdo, $lang);
echo json_encode($data);

