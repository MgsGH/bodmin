<?php

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();
$userData = getUserModulePermission($pdo, $_GET['userId'], $_GET['moduleId']);
echo json_encode($userData);
