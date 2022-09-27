<?php

include_once '../aahelpers/db.php';
$pdo = getDataPDO();
$id = $_GET['id'];
$data = getPersonIdViaUserId($pdo, $id);
echo json_encode($data);
