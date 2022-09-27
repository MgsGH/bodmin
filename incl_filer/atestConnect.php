<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/incl_filer/connect_new.php';

//$pdo = getDataPDO();
$pdo = getSQLIConnection();

echo('Connection OK');

//$data = getSortiment($pdo);
//echo json_encode($data);
