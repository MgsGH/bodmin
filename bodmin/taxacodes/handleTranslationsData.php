<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

$id = $_POST['taxacode_type_id'];
deleteTaxaCodeTypeTranslationTexts($pdo, $id);

//logPostData();

foreach ($_POST as $item => $value){

    if ($item !== 'taxacode_type_id'){
        $language_id = substr($item, 9);
        writeTaxaCodeTypeTranslationText($pdo, $language_id, $id, $value, $_SESSION['loggedin']);
    }

}

/*
This is an example of incoming POST data
trapping_method_id: 1
language-1: Harbour road
language-2: Hamnvägen
 */