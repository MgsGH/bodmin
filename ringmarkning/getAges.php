<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();

$lang = $_GET['lang'];
$ages = $_GET['ages'];

$data = getAgesOptions($pdo, $ages, $lang);
echo json_encode($data);
