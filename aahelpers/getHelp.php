<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();
$language = $_GET['language'];
$module = $_GET['module'];

$userData = getHelp($pdo, $language, $module);
echo json_encode($userData);
