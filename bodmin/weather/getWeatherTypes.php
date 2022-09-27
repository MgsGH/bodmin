<?php

$path = '/home/hkghbhzh/public_html';
$lookinto = 'something.' . $_SERVER['SERVER_NAME'];
$developmentEnvironment = strpos($lookinto , 'fbo.localhost');

if ($developmentEnvironment){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

$data = getWeatherTypes($pdo, $_GET['lang_id']);
echo json_encode($data);
