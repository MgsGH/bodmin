<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$lang_id =

$data = getTaxaTranslations($pdo, $_GET['id']);
echo json_encode($data);
