<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$taxon = $_GET['taxon'];
$languageId = $_GET['language'];

$data = getTaxonRecords ($pdo, $taxon, $languageId);

echo json_encode($data, JSON_UNESCAPED_UNICODE);
