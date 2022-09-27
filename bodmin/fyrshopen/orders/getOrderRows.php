<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
$customer_id = $_GET['customer'];
$language_id = $_GET['language'];


include_once $path . '/sales/data/db.php';
$pdo = getSalesPDO();

$rows = getOrderRows($pdo, $customer_id, $language_id);
echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);

