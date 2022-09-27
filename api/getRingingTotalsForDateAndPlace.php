<?php

include '../aahelpers/db.php';

$language = $_GET['lang'];
$date = $_GET['date'];
$place = $_GET['place'];
$pdo = getDataPDO();

$data = getRingingDateTotals($pdo, $date, $language, $place);

echo  json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
