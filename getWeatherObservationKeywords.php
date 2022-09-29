<?php

include_once 'aahelpers/db.php';

$pdo = getPDO();

$data = getWeatherObservationKeywordsForDate($pdo, $_GET['id'], $_GET['lang']);
echo json_encode($data);
