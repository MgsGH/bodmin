<?php

// https://phppot.com/php/mysql-blob-using-php/


include_once '../aahelpers/db.php';

$pdo = getPDO();

if(isset($_GET['id'])) {

    $id = $_GET['id'];
    $imgData = getMiniPic($pdo, $id);

    var_dump($imgData);

    header("Content-type: " . "image/jpg");
    echo $imgData[0]["MINPIC"];

}


