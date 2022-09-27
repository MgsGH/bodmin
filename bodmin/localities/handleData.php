<?php
session_start();

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/functions.php';

//$pdo = getDataPDO();


if ($_POST['mode'] === 'edit'){
    $name = $_POST['name'];
    $systematic = $_POST['systematic'];
    $monitoring = $_POST['monitoring'];
    $loggedInUser = $_SESSION['userId'];
    $id = $_POST['ringing_location_id'];
    updateLocation($pdo, $id, $name, $systematic, $monitoring, $loggedInUser);

    $jsonData = json_encode($id);
    echo($jsonData);

}


if ($_POST['mode'] === 'add'){
    $name = $_POST['name'];
    $systematic = $_POST['systematic'];
    $monitoring = $_POST['monitoring'];
    $loggedInUser = $_SESSION['userId'];
    $writtenId = writeLocation($pdo, $name, $systematic, $monitoring, $loggedInUser);

    $jsonData = json_encode($writtenId);
    echo($jsonData);

}


if ($_POST['mode'] === 'delete'){
    $ringing_location_id = $_POST['ringing_location_id'];
    deleteLocationTranslations($pdo, $ringing_location_id);
    deleteLocation($pdo, $ringing_location_id);
    $writtenId = 0;
    $jsonData = json_encode($writtenId);
    echo($jsonData);

}

