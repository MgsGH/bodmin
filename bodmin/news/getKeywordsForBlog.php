<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$blog_id = $_GET['id'];
$language_id = $_GET['lang'];
$pdo = getDataPDO();

$data = getKeywordsForBlog($pdo, $blog_id, $language_id);
echo json_encode($data);
