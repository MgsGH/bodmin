<?php

include_once '../aahelpers/db.php';
include_once '../aahelpers/common-functions.php';

$pdo = getDataPDO();

$datum = $_POST['dateTaken'];
$photographer = $_POST['photographer'];
$place = $_POST['place'];
$published = $_POST['published'];
$u = getLoggedInUserId();

$thisDir =  __DIR__;
$to = strrpos($thisDir, DIRECTORY_SEPARATOR) + 1;
$basePath = substr($thisDir,0, $to) . "v2images" . DIRECTORY_SEPARATOR;
$extension = '.jpg';

if ($_POST['mode'] === 'edit'){

    $bildId = $_POST['currentId'];
    updateImageData($pdo, $datum, $photographer, $place, $published, $bildId);
    removeKeywordsAndTaxaForImage($pdo, $bildId);

    // writes the image - minipic.
    if (isset($_POST['imgSmallData'])){

        dbLog('writing image data');

        $data = deCodePostImg($_POST['imgSmallData']);
        $target_dir = $basePath . "minipics" . DIRECTORY_SEPARATOR;
        $target_file = $target_dir . "minipic-" . $bildId . $extension;

        dbLog($target_file);

        file_put_contents($target_file, $data);
    }

    // writes the image - maxipic.
    if (isset($_POST['imgData'])){
        $data = deCodePostImg($_POST['imgData']);
        $target_dir = $basePath . "maxipics" . DIRECTORY_SEPARATOR;
        $target_file = $target_dir . "maxipic-" . $bildId . $extension;

        dbLog($target_file);

        $x = file_put_contents($target_file, $data);

        dblog($x);


    }

    // rewrite taxa and keyword(s)
    $aKeywords = explode(',', $_POST['keywordIds']);
    foreach ($aKeywords as $keywordId) {
        writePicKeyword($pdo, $bildId, $keywordId);
    }

    $aTaxa = explode(',', $_POST['taxaIds']);
    foreach ($aTaxa as $taxaId) {
        writePicTaxa($pdo, $bildId, $taxaId);
    }

    // return the id deleted - same handling for all cases
    $data = array();
    $record['maxid'] = $bildId;
    array_push($data, $record);

    $jsonData = json_encode($data);
    echo($jsonData);

}

dbLog($_POST['mode']);


if ($_POST['mode'] === 'add'){

    $keywords = $_POST['keywordIds'];
    $taxa = $_POST['taxaIds'];

    // writes image metadata, including keywords and taxa
    $bildId = writeImageData($pdo, $datum, $photographer, $place, $published, $keywords, $taxa, $u);

    // writes the image - minipic.
    $data = deCodePostImg($_POST['imgSmallData']);
    $target_dir = $basePath . "minipics" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . "minipic-" . $bildId . $extension;
    file_put_contents($target_file, $data);

    // writes the image - maxipic.
    $data = deCodePostImg($_POST['imgData']);
    $target_dir = $basePath . "maxipics" . DIRECTORY_SEPARATOR;
    $target_file = $target_dir . "maxipic-" . $bildId . $extension;
    file_put_contents($target_file, $data);

    // get the id written
    $data = getImageId($pdo, $photographer);
    $jsonData = json_encode($data);
    echo($jsonData);

}


if ($_POST['mode'] === 'delete'){

    $bildId = $_POST['currentId'];
    removeKeywordsAndTaxaForImage($pdo, $bildId);
    removeImageRecord($pdo, $bildId);

    $file = '/v2bilder/minipics/minipic-' . $bildId . $extension;
    removeFile($file);

    $file = '/v2bilder/maxipics/maxipic-' . $bildId . $extension;
    removeFile($file);

    // return the id deleted - same handling for all cases
    $data = array();
    $record['maxid'] = $bildId;
    array_push($data, $record);

    $jsonData = json_encode($data);
    echo($jsonData);

}


function deCodePostImg($imgAsString){

    $img = $imgAsString;
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    return base64_decode($img);

}

