<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();

$lang = $_GET['lang'];

$data = getMonthOptions($pdo, $lang);
echo json_encode($data);
