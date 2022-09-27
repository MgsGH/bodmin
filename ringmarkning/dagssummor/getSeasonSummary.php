<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

$scheme = $_GET['P'];
$date = $_GET['D'];

// -- taxa ----------------------------------------
$taxa = array();
$noOfTaxaToTodayThisYear = getNoOfTaxaToTodayThisYear( $pdo, $scheme, $date );
$taxa['totalToToday'] = $noOfTaxaToTodayThisYear[0]['NOOF_TAXA'];

$averageNoOfTaxaToToday = getAverageNoOfTaxaToToday( $pdo, $scheme, $date );
$taxa['averageToToday'] = $averageNoOfTaxaToToday[0]['AVERAGE'];


$maxNoOfTaxaToToday = getMaxNoOfTaxaToToday($pdo, $scheme, $date );
$taxa['maxToToday'] = $maxNoOfTaxaToToday[0]['MAX'];

$maxNoOfTaxaForThisScheme = getMaxNoOfTaxaForThisScheme($pdo, $scheme );
$taxa['allTimeMax'] = $maxNoOfTaxaForThisScheme[0]['MAX'];


// -- individuals ---------------------------------
$individuals = array();
$noOfBirdsToTodayThisYear = getNoOfBirdsToTodayThisYear( $pdo, $scheme, $date );
$individuals['totalToToday'] = $noOfBirdsToTodayThisYear[0]['NOOF'];

$averageNoOfBirdsToToday = getAverageNoOfBirdsToToday($pdo, $scheme, $date );
$individuals['averageToToday'] = $averageNoOfBirdsToToday[0]['AVERAGE'];

$maxNoOfBirdsToToday = getMaxNoOfBirdsToToday($pdo, $scheme, $date );
$individuals['maxToToday'] = $maxNoOfBirdsToToday[0]['MAX'];

$maxNoOfBirdsForThisScheme = getMaxNoOfBirdsForThisScheme($pdo, $scheme, $date );
$individuals['allTimeMax'] = $maxNoOfBirdsForThisScheme[0]['MAX'];

$allData = array();
$allData['taxa'] = $taxa;
$allData['individuals'] = $individuals;

echo json_encode($allData, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG);

