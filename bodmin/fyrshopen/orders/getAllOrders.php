<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/sales/data/db.php';
$language_id = $_GET['language'];
$pdo = getSalesPDO();
$data = getOrders($pdo, $language_id);
echo json_encode($data);
