<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();
//logSessionData();

if ($_POST['mode'] === 'edit'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    updateTrappingMethod($pdo, $id, $name);
}


if ($_POST['mode'] === 'add'){
    $name = $_POST['name'];
    writeTrappingMethod($pdo, $name);
}


if ($_POST['mode'] === 'delete'){
    $trapping_method_id = $_POST['id'];
    deleteTrappingMethodsTranslations($pdo, $trapping_method_id);
    deleteTrappingMethod($pdo, $trapping_method_id);
}


