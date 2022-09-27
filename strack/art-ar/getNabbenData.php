<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/common-functions.php';

$pdo = getDataPDO();

$selectYear = 2021;
$selectedArt = 'BIVRÅ';

$data = getNabbenDailyTotals($pdo, $selectYear, $selectedArt);

echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
