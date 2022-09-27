<?php

include_once '../aahelpers/db.php';
$pdo = getDataPDO();
$lang = $_GET['lang'];
$cat = $_GET['cat'];
$data = getKeywordsOverSattningarForCategory($pdo, $cat, $lang);
echo json_encode($data);
