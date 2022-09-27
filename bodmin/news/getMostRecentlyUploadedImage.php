<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$date = 0;
$uploadedBy = 0;

$data = getMostRecentlyUploadedImage($pdo, $date, $uploadedBy );
echo json_encode($data);
