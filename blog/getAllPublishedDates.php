<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$lang = $_GET['lang'];
$data = getAllPublishedDates($pdo, $lang);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
