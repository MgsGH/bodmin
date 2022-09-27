<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();


$publ_id = $_GET['id'];
$language_id = $_GET['lang'];

$data = getKeywordsForPublication($pdo, $publ_id, $language_id);
echo json_encode($data);