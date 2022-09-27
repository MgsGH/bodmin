<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();
logSessionData();

if ($_POST['mode'] === 'edit'){
    updateKeyword($pdo, $_POST['keyword_category_id'], $_POST['keyword_id'], $_POST['keyword_text'], $_SESSION['userId']);
}


if ($_POST['mode'] === 'add'){
    writeKeyword($pdo, $_POST['keyword_category_id'], $_POST['keyword_text'], $_SESSION['userId']);
}


if ($_POST['mode'] === 'delete'){
    deleteKeyword($pdo, $_POST['keyword_id']);
    deleteKeywordTranslations($pdo, $_POST['keyword_id']);
}

