<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();
$id = $_GET['id'];
$data = getAllPersonEMailsExcept($pdo, $id);
echo json_encode($data);


