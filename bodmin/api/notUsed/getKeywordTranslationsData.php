<?php

include_once '../aahelpers/db.php';
$pdo = getPDO();
$keyword = $_GET['keyword'];
$data = getKeywordTranslationsData($pdo);
echo json_encode($data);
