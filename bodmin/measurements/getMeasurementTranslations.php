<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$userData = getMeasurementsTranslations($pdo, $_GET['id']);
echo json_encode($userData);
