<?php


include_once '../../aahelpers/db.php';

$pdo = getDataPDO();
$id = $_GET['usid'];
$data = getLoggedInPersonsSignature($pdo, $id);

echo  json_encode($data);
