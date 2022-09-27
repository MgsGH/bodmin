<?php

include_once '../aahelpers/db.php';

$lang = $_GET['lang'];

$pdo = getDataPDO();
$data = getWebReserves( $pdo, $lang );

echo json_encode($data);
