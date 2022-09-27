<?php
include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';


$pdo = getPDO();


$userData = getRingTypes($pdo);
echo json_encode($userData);
