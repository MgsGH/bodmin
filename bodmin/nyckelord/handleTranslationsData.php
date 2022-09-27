<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();

$keyword_id = $_POST['keyword_id'];
deleteKeywordTranslations($pdo, $keyword_id);

foreach ($_POST as $item => $value){

    if ($item !== 'keyword_id'){
        $language_id = substr($item, 9); // language_xx
        writeKeywordTranslationText($pdo, $language_id, $keyword_id, $value, $_SESSION['loggedin']);
    }

}


