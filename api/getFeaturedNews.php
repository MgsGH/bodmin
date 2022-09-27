<?php

include '../aahelpers/db.php';

$lang = $_GET['lang'];
$pdo = getDataPDO();
$data = getFeaturedNewsTexts($pdo, $lang);

$recodedData = [];
$search = "/bilder/maxipics";
$replace = "/v2images/maxipics";

foreach ($data as $row){

    $aRow = [];
    $aRow['DATE'] = $row["DATE"];
    $aRow["TEXT"] = str_replace($search, $replace, $row["TEXT"]);
    array_push($recodedData, $aRow);

}

echo json_encode($recodedData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);
