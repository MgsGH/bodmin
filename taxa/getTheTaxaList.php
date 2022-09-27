<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$language = $_GET['language'];

$data =  getArtlista($pdo, $language);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
