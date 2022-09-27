<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include $path . '/aahelpers/db.php';


$lang = $_GET['lang'];
$ymd = $_GET['ymd'];
$pdo = getDataPDO();
$data = getNewsTextForDate($pdo, $lang, $ymd);


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

