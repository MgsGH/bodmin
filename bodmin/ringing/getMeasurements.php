<?php


include_once '../aahelpers/db.php';

$pdo = getPDO();
$locationAndDateId = $_GET['id'];
$lang = $_GET['lang_id'];

$data = getMeasurements($pdo, $locationAndDateId, $lang);

echo json_encode($data);


