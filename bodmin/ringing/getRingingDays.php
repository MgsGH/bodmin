<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getRingingDayPlaces($pdo);
echo json_encode($data);

