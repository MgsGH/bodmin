<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

$date = '2022-08-20';
$language = '2';
$data = getOngoingYearStrackDataMaxMin($pdo, $date, $language);
//$data = getCompleteYearsStrackDataMaxMin($pdo, $date, $language);

var_dump($data);

//echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
