<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

$id = $_POST['trapping_method_id'];
deleteMeasurementTranslations($pdo, $id);

//logPostData();

foreach ($_POST as $item => $value){

    if ($item !== 'trapping_method_id'){
        $language_id = substr($item, 9);
        writeMeasurementTranslationText($pdo, $language_id, $id, $value, $_SESSION['loggedin']);
    }

}

/*
This is an example of incoming POST data
trapping_method_id: 1
language-1: Harbour road
language-2: Hamnvägen
 */