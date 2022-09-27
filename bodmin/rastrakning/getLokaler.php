<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$userData = getLocationsForDropDown($pdo, $_GET['langId']);
echo json_encode($userData);
