<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$taxa_id = $_GET['taxa_id'];

$data = getMeasurementConfigurationDataForTaxa($pdo, $taxa_id);

echo json_encode($data);
