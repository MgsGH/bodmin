<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$taxa_id = $_GET['taxa_id'];
$lang_id = $_GET['lang_id'];

$data = getMeasurementConfigurationData($pdo, $taxa_id, $lang_id);
echo json_encode($data);

