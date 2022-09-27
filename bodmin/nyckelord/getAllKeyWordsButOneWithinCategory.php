<?php


include_once '../aahelpers/db.php';
$pdo = getPDO();
$data = getAllKeywordsButOneWithinCategory($pdo, $_GET['category'], $_GET['exclude']);
echo json_encode($data);