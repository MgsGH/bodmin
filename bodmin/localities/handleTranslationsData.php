<?php
session_start();


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/functions.php';

$pdo = getDataPDO();

$location_id = $_POST['location_id'];
deleteLocationTranslations($pdo, $location_id);

logDBPostData();

foreach ($_POST as $item => $value){

    if ($item !== 'location_id'){
        $language_id = substr($item, 9); // language_xx
        writeLocationText($pdo, $language_id, $location_id, $value, $_SESSION['loggedin']);
    }

}


