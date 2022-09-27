<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

if (isset($_GET['userId'])) {
    $user = $_GET['userId'];

    $userData = getModulePermissions($pdo, $user);

    echo json_encode($userData);
}




