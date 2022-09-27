<?php

include_once '../aahelpers/db.php';
$pdo = getPDO();
$lang = $_GET['lang'];
$data = getAllKeywordCategoriesOverSattningar($pdo, $lang);
echo json_encode($data);

