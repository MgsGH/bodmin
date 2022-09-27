<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();

$imageId = $_GET['image'];
$languageId = $_GET['language'];

$data = getImageTaxaNamesViaPhotoId($pdo, $imageId, $languageId);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
