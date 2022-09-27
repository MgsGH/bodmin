<?php
session_start();
$path = '/home/hkghbhzh/public_html';
$lookinto = 'something.' . $_SERVER['SERVER_NAME'];
$developmentEnvironment = strpos($lookinto , 'fbo.localhost');

if ($developmentEnvironment){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/functions.php';

$pdo = getDataPDO();


if (($_POST['mode'] === 'edit') || ($_POST['mode'] === 'add')) {

    $time = $_POST['time'];
    $visibility = $_POST['visibility'];

    $clouds = $_POST['clouds'];
    $windDirection = $_POST['windDirection'];
    $windForce = $_POST['windForce'];
    $temperature = $_POST['temperature'];
    $pressure = $_POST['pressure'];
    $user = $_POST['user'];

}


if ($_POST['mode'] === 'edit'){

    $id = $_POST['id'];

    deleteWeatherObservationWeatherType($pdo, $id);

    // rewrite taxa and keyword(s)
    $aKeywords = explode(',', $_POST['weatherTypeIds']);
    foreach ($aKeywords as $keywordId) {
        writeWeatherObservationWeatherType($pdo, $id, $keywordId);
    }


    updateWeatherObservation($pdo, $id, $time, $visibility, $clouds, $windDirection, $windForce, $temperature, $pressure, $user );
}


if ($_POST['mode'] === 'add'){

    $keywords =  $_POST['weatherTypeIds'];
    $date = $_POST['date'];
    writeWeatherObservation($pdo, $date, $time, $visibility, $clouds, $windDirection, $windForce, $temperature, $pressure, $keywords, $user );
}


if ($_POST['mode'] === 'delete'){
    $id = $_POST['id'];
    deleteWeatherObservation($pdo, $id);
    deleteWeatherObservationWeatherType($pdo, $id);
}

