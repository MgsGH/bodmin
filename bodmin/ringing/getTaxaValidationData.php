<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getTaxaValidationData($pdo);

echo json_encode($data);
