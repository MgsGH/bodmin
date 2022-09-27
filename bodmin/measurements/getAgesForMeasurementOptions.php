<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$lang = $_GET['lang'];

$data = getAgeOptionsForMeasurementOptions($pdo, $lang);
echo json_encode($data);



