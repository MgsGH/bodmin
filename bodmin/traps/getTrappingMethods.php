<?php
include_once '../aahelpers/db.php';

$pdo = getPDO();

$userData = getAllTrappingMethods($pdo);
echo json_encode($userData);
