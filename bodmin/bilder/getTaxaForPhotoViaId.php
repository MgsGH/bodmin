<?php

include_once '../../aahelpers/db.php';

$bild_id = $_GET['id'];
$language_id = $_GET['lang'];
$pdo = getDataPDO();

$data = getTaxaDataForPhoto($pdo, $bild_id, $language_id);
echo json_encode($data);
