<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getRingTypeTranslations($pdo, $_GET['id']);
echo json_encode($data);
