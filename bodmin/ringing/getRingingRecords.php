<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$date_locality_id = $_GET['id'];

$data = getRingingDataForDayPlace($pdo, $date_locality_id);

echo json_encode($data);

