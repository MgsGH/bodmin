<?php


session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

$taxa_id = $_POST['taxa_id'];
deleteTaxaRingTypes($pdo, $taxa_id);

logPostData();

foreach ($_POST as $item => $value) {

    if ($item !== 'taxa_id') {
        $user = $_SESSION['userId'];
        $ring_type_id = substr($item, 9); //
        writeTaxaRingType($pdo, $ring_type_id, $taxa_id, $value, $user);
    }

}

/*
   taxa_id: 2
   ringCode-5: 5
   0123456789012

 */
