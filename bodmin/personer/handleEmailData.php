<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/functions.php';

$pdo = getDataPDO();


$id = $_POST['id'];
deleteEmailForPersonId($pdo, $id);

foreach ($_POST as $item => $value){

    if ($item !== 'id'){
        writeEmailForPersonId($pdo, $id, $value);
    }

}

