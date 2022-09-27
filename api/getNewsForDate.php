<?php

include '../aahelpers/db.php';
include '../aahelpers/functions.php';

$lang = $_GET['lang'];
$date = $_GET['date'];
$pdo = getDataPDO();
$data = getNewsTextForDate($pdo, $lang, $date);


$recodedData = [];
$search = "../bilder/maxipics";
$replace = "../bodmin/bilder/maxipics";

foreach ($data as $row){

    $aRow = [];
    $aRow['DATE'] = $row["DATE"];
    $aRow["TEXT"] = str_replace($search, $replace, $row["TEXT"]);
    array_push($recodedData, $aRow);

}


echo  json_encode($recodedData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
