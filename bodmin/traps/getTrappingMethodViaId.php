<?php


include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getTrappingMethodViaId($pdo, $_GET['id']);
echo json_encode($data);