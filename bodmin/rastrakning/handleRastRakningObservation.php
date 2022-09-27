<?php

include_once '../aahelpers/db.php';

$pdo = getPDO();
$mo = $_POST['mo'];
$ml = $_POST['ml'];
$observator = $_POST['observator'];
$datum = $_POST['datum'];
$updater = $_POST['updater'];
// alla arter: record id, taxa, antal
$artdata = $_POST['records'];

error_log('Antal arter i denna postning: ' . sizeof($artdata) . PHP_EOL, 3, "my-errors.log");

foreach ($artdata as $aRecord){

    // three cases here
    // 1. Record-id and antal -> update observation.
    if (($aRecord["recid"] !== '0') && ($aRecord["recantal"] !== '0')){
        updateRRObservation($pdo, $aRecord["recid"], $aRecord["recantal"], $observator, $datum, $updater);
        error_log('Uppdaterat med dessa data (reoord id): ' . $aRecord["recid"] . ' och antal: ' . $aRecord["recantal"] . PHP_EOL, 3, "my-errors.log");
    }

    // 2. Record-id and antal = 0 -> delete observation.
    if (($aRecord["recid"] !== '0') && (($aRecord["recantal"] === '0') || $aRecord["recantal"] === '')) {
        deleteRRObservation($pdo, $aRecord["recid"]);
        error_log('Tagit BORT med dessa data (taxa id: : ' . $aRecord["recid"] . PHP_EOL, 3, "my-errors.log");
    }

    // 3. No record-id but antal -> new observation, write it.
    if ($aRecord["recid"] === '0') {
        writeRRObservation($pdo, $mo, $ml, $aRecord["taxa"], $aRecord["recantal"], $observator, $datum, $updater);
        error_log('LAGT TILL med dessa data (taxa): ' . $aRecord["taxa"] .' och antal:' . $aRecord["recantal"] . PHP_EOL, 3, "my-errors.log");
    }

}









