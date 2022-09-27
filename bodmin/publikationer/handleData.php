<?php

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();
//logSessionData();


if ($_POST['mode'] === 'edit'){

    $id = $_POST['currentId'];
    $title = $_POST['title'];
    $journal = $_POST['journal'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $published = $_POST['published'];
    updatePublicationData($pdo, $id, $title, $journal, $author, $year, $published);
    //removeKeywordsAndTaxaForPublication($pdo, $id);

    // rewrite taxa and keyword(s)
    $aKeywords = explode(',', $_POST['keywordIds']);
    foreach ($aKeywords as $keywordId) {
        //writePicKeyword($pdo, $id, $keywordId);
    }

    $aTaxa = explode(',', $_POST['taxaIds']);
    foreach ($aTaxa as $taxaId) {
        //writePicTaxa($pdo, $id, $taxaId);
    }

}


if ($_POST['mode'] === 'add'){

    $keywords = $_POST['keywordIds'];
    $taxa = $_POST['taxaIds'];

    // writes publication meta data, including keywords and taxa
    $title = $_POST['title'];
    $journal = $_POST['journal'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $published = $_POST['published'];
    $id = writePublicationData($pdo, $title, $journal, $author, $year, $published, $keywords, $taxa);

    // write the uploaded file as well
    /*
    $data = deCodePostImg($_POST['imgSmallData']);
    $target_dir = "/bilder/minipics/";
    $target_file = $target_dir . "minipic-" . $bildId . $extension;
    file_put_contents($target_file, $data);
    */

}


if ($_POST['mode'] === 'delete'){

    $bildId = $_POST['currentId'];
    removeKeywordsAndTaxaForImage($pdo, $bildId);
    removeImageRecord($pdo, $bildId);

    $file = '/bilder/minipics/minipic-' . $bildId . $extension;
    removeFile($file);

    $file = '/bilder/maxipics/maxipic-' . $bildId . $extension;
    removeFile($file);

}


function deCodePostImg($imgAsString){

    $img = $imgAsString;
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    return base64_decode($img);

}



//error_log('Antal arter i denna postning: ' . sizeof($_POST['taxaIds']) . PHP_EOL, 3, "my-errors.log");
