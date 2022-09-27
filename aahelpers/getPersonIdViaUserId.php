<?php

include_once '../aahelpers/db.php';
$pdo = getPDO();
$id = $_GET['id'];
$data = getPersonIdViaUserId($pdo, $id);
echo json_encode($data);
