<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$data = getWebLocalities( $pdo, "2" );

echo json_encode($data);
