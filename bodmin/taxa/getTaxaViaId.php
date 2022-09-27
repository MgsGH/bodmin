<?php


include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getBaseTaxa($pdo, $_GET['id']);
echo json_encode($data);
