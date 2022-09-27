<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/common-functions.php';

$homePageData = array();

$lang = $_GET['lang'];
$pdo = getDataPDO();

// Main structure - first piece
// [0] - Today's weather -      $homePageData['weatherData']
// [1] - Recent images -        $homePageData['picData']
// [2] - First blog entry -     $homePageData['firstBlogEntry']
// [3] - Featured news -        $homePageData['featuredNews']


$homePageData['weatherData'] = getMostRecentWeatherReading($pdo, $lang);
$homePageData['picData'] = getMostRecentPics($pdo, $lang);


$tmp = getMostRecentNewsText($pdo, $lang);
$date = $tmp[0]["DATE"];
$homePageData['firstBlogEntry'] = getBlogDayData($pdo, $lang, $date);


$blogEntries = array();
$featuredNewsDays = getFeaturedNewsTexts($pdo, $lang);
foreach ($featuredNewsDays as $day){

    $date = $day["DATE"];
    $blogEntries[] = getBlogDayData($pdo, $lang, $date);

}
$homePageData['featuredNews'] = $blogEntries;


echo  json_encode($homePageData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);

