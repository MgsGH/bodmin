<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

$taxa_id = $_POST['taxa_id'];
deleteTaxaTranslations($pdo, $taxa_id);

logPostData();

foreach ($_POST as $item => $value){

    if ($item !== 'taxa_id'){
        $language_id = substr($item, 9); // language_xx
        writeTaxaTranslationText($pdo, $language_id, $taxa_id, $value);
    }

}
