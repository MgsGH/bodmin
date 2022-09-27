<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();
$d = $_GET['datum'];
$data = getBookingsForDate($pdo, $d);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
