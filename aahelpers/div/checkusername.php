<?php
include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';

$pdo = getPDO();
$userData = getUser($pdo, $_GET['username']);
echo json_encode($userData);




