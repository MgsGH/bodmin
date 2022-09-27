<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getAllTaxaRingTypesData($pdo);
echo json_encode($data);