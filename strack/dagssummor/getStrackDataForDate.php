<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

if (isset($_GET['date'])){

    $date = $_GET['date'];
    $language = 1;

    if (isset($_GET['language'])){
        $language = $_GET['language'];
    }

    $data = getStrackData($pdo, $date, $language);

}

echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);

