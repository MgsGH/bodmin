<?php

include_once '../../aahelpers/db.php';
include_once '../../aahelpers/common-functions.php';

$pdo = getDataPDO();

$datum = $_POST['dateTaken'];
$photographer = $_POST['photographer'];
$place = $_POST['place'];
$published = $_POST['published'];
$u = getLoggedInUserId();

dblog('Logged in user ' .  $u);

foreach ($_POST as $item => $value){
    dbLog($item . ': ' . $value);
}

logSessionData();


if ($_POST['mode'] === 'edit'){

    $bildId = $_POST['currentId'];
    updateImageData($pdo, $datum, $photographer, $place, $published, $bildId);
    removeKeywordsAndTaxaForImage($pdo, $bildId);

    // rewrite taxa and keyword(s)
    $aKeywords = explode(',', $_POST['keywordIds']);
    foreach ($aKeywords as $keywordId) {
        writePicKeyword($pdo, $bildId, $keywordId);
    }

    $aTaxa = explode(',', $_POST['taxaIds']);
    foreach ($aTaxa as $taxaId) {
        writePicTaxa($pdo, $bildId, $taxaId);
    }

}


if ($_POST['mode'] === 'add'){

    $extension = '.jpg';
    $keywords = $_POST['keywordIds'];
    $taxa = $_POST['taxaIds'];

    // writes image meta data, including keywords and taxa
    $bildId = writeImageData($pdo, $datum, $photographer, $place, $published, $keywords, $taxa, $u);

    // writes the image - minipic.
    $data = deCodePostImg($_POST['imgSmallData']);
    $target_dir = "/bilder/minipics/";
    $target_file = $target_dir . "minipic-" . $bildId . $extension;
    file_put_contents($target_file, $data);

    // writes the image - maxipic.
    $data = deCodePostImg($_POST['imgData']);
    $target_dir = "/bilder/maxipics/";
    $target_file = $target_dir . "maxipic-" . $bildId . $extension;
    file_put_contents($target_file, $data);

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

/*
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
*/

//error_log('Antal arter i denna postning: ' . sizeof($_POST['taxaIds']) . PHP_EOL, 3, "my-errors.log");
