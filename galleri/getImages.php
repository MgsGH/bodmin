<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();

$data = getImages($pdo);

echo json_encode($data, JSON_UNESCAPED_UNICODE);


