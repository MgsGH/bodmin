<?php


include_once '../aahelpers/db.php';

$pdo = getPDO();
$locality_id = $_GET['locality_id'];

$data = getLocalityRingTypesNumbers($pdo, $locality_id);

echo json_encode($data);
