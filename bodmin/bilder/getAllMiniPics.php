<?php

include '../../aahelpers/db.php';
include 'functions.php';

class ImageData {

    public $photographer = "";
    public $id = "0";
    public $place = "";
    public $published = "";
    public $uploaded = "";
    public $captured = "";
    public $arter = "";
    public $keywords = "";

}

$pdo = getDataPDO();
$data = getAllMiniPics($pdo);


$allImages = [];
foreach ($data as $image){
    $language = $_GET['lang'];
    $imageData = new ImageData();
    $imageData->id = $image['IMAGE_ID'];
    $imageData->photographer = $image['FULLNAME'];
    $imageData->place = $image['PLATS'];
    $imageData->published = $image['PUBLISHED'];
    $imageData->captured = $image['DATUM'];
    $imageData->uploaded = $image['CREATED_AT'];
    $imageData->arter = getTaxaNamesForPhoto($pdo, $imageData->id, $language);
    $imageData->keywords = getKeywordTextsForImage($pdo, $imageData->id, $language);
    array_push($allImages, $imageData);

}
echo json_encode($allImages);

