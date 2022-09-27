<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getAllMeasurementConfigurationData($pdo);
echo json_encode($data);
