<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();
$language_id = getCurrentLanguage();
logg($language_id);

if ($_POST['mode'] === 'edit'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    updateRingType($pdo, $id, $name, $type, $language_id);
}


if ($_POST['mode'] === 'add'){
    $name = $_POST['name'];
    $type = $_POST['type'];
    writeRingType($pdo, $name, $type, $language_id);
}


if ($_POST['mode'] === 'delete'){
    $ring_type_id = $_POST['id'];
    deleteRingTypeTranslations($pdo, $ring_type_id);
    deleteRingType($pdo, $ring_type_id);
}


