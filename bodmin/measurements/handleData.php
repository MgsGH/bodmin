<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();
//logSessionData();

if (($_POST['mode'] === 'edit') || ($_POST['mode'] === 'add')){

    $name = $_POST['name'];
    $standardMeasurement = $_POST['standard'];
    $sortOrder = $_POST['sortOrder'];
    $displayCommon = $_POST['disp_common'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $months = $_POST['months'];
    $valCommon = $_POST['val_common'];
    $min = $_POST['min'];
    $max = $_POST['max'];

    if ($_POST['mode'] === 'edit'){
        $id = $_POST['id'];
        updateMeasurement($pdo, $id, $name, $standardMeasurement, $sortOrder, $displayCommon, $sex, $age, $months, $valCommon, $min, $max, $_SESSION['loggedin']);
    }

    if ($_POST['mode'] === 'add'){
        writeMeasurement($pdo, $name, $standardMeasurement, $sortOrder, $displayCommon, $sex, $age, $months, $min, $valCommon, $max, $_SESSION['loggedin']);
    }
}

if ($_POST['mode'] === 'delete'){
    $id = $_POST['id'];
    deleteMeasurementTranslations($pdo, $id);
    deleteMeasurement($pdo, $id);
}
