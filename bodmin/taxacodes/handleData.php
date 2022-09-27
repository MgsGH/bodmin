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
    updateTaxaCodeType($pdo, $id, $name, $_SESSION['loggedin']);
}


if ($_POST['mode'] === 'add'){
    $name = $_POST['name'];
    writeTaxaCodeType($pdo, $name, $_SESSION['loggedin']);
}


if ($_POST['mode'] === 'delete'){
    $taxacode_type_id = $_POST['id'];
    deleteTaxaCodeTypeTranslationTexts($pdo, $taxacode_type_id);
    deleteTaxaCodeType($pdo, $taxacode_type_id);
}


