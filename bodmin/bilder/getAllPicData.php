<?php

include_once '../../aahelpers/db.php';
$pdo = getDataPDO();
$id = $_GET['id'];
$language_id = $_GET['language'];
$data = getAllPicDataViaId($pdo, $id, $language_id);
echo json_encode($data);