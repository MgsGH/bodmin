<?php

include_once '../aahelpers/db.php';
$pdo = getPDO();
$lang = $_GET['lang'];
$data = getKeywordTableData($pdo);
echo json_encode($data);