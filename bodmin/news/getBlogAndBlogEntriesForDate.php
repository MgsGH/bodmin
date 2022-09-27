<?php

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();

$result = array();

$data = getBlogForDate($pdo, $_GET['d']);
array_push($result, $data);

$entries = getBlogEntriesForDate($pdo, $_GET['d']);
array_push($result, $entries );

echo json_encode($result);
