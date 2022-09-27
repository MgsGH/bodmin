<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/common-functions.php';

$lang = $_GET['lang'];
$date = $_GET['ymd'];
$pdo = getDataPDO();


$dayData = getBlogDayData($pdo, $lang, $date);

echo  json_encode($dayData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);

