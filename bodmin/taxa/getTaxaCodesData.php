<?php

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();
$taxa_id = $_GET['taxa_id'];
$lang_id = getCurrentLanguage();

$data = getTaxaCodesAndTexts($pdo, $taxa_id, $lang_id);
echo json_encode($data);
