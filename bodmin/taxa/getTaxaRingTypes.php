<?php

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();
$taxa_id = $_GET['taxa_id'];
$langId = getCurrentLanguage();

$data = getTaxaRingTypesData($pdo, $taxa_id, $langId);
echo json_encode($data);