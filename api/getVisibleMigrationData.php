<?php


include '../aahelpers/db.php';

$pdo = getDataPDO();

$date = $_GET['date'];
$language = $_GET['lang'];

$data = getStrackData($pdo, $date, $language);

echo  json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
