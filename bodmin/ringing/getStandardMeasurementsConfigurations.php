<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$lang = $_GET['lang_id'];

$data = getStandardMeasurementsOptions($pdo, $lang);

echo json_encode($data);

