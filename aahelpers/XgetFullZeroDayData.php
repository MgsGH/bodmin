<?php


include '../aahelpers/db.php';

$language = $_GET['lang'];
$date = $_GET['date'];
$pdo = getDataPDO();

$data = getFullZeroDayData($pdo, $date, $language);

echo  json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);

