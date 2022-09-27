<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();

$data = getKeywordTranslations($pdo, $_GET['id']);
echo json_encode($data);
