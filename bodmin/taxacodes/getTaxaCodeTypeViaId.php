<?php


include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getTaxaCodeTypeViaId($pdo, $_GET['id']);
echo json_encode($data);