<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

$taxa_id = $_POST['taxa_id'];
deleteTaxaCodeTypeCodes($pdo, $taxa_id);

logPostData();

foreach ($_POST as $item => $value){

    if ($item !== 'taxa_id'){
        $user = $_SESSION['userId'];
        $codeType_id = substr($item, 13);
        writeTaxaCodeTypeCode($pdo, $codeType_id, $taxa_id, $value, $user);
    }

}

/*
   taxa_id: 2
   taxaCodeType-5: EnNyKod
   01234567899012

 */