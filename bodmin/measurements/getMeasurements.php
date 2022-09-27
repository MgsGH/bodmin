<?php
include_once '../aahelpers/db.php';

$pdo = getPDO();

$userData = getAllMeasurements($pdo);
echo json_encode($userData);
