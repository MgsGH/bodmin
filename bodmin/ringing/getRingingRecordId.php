<?php


include_once '../aahelpers/db.php';

$pdo = getPDO();
$ringNo = $_GET['ring'];

$data = getRingingRecordId($pdo, $ringNo);

echo json_encode($data);
