<?php


include '../aahelpers/db.php';

$lang = $_GET['lang'];
$pdo = getDataPDO();
$data = getMostRecentPics($pdo, $lang);


echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
