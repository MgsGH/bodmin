<?php


include '../aahelpers/db.php';
include '../aahelpers/functions.php';

$lang = $_GET['lang'];
$pdo = getDataPDO();
$data = getMostRecentNewsText($pdo, $lang);


$recodedData = [];
$search = "/bilder/maxipics";
$replace =  "/v2images/maxipics";

foreach ($data as $row){

    $aRow = [];
    $aRow['DATE'] = $row["DATE"];
    $aRow["TEXT"] = str_replace($search, $replace, $row["TEXT"]);
    array_push($recodedData, $aRow);

}

echo  json_encode($recodedData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
