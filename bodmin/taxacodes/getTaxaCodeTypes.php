<?php
include_once '../aahelpers/db.php';

$pdo = getPDO();

$userData = getTaxaCodesTypes($pdo);
echo json_encode($userData);
