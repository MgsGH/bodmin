<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();
logSessionData();

if ($_POST['mode'] === 'edit'){

    $id = $_POST['taxa_id'];
    $snr = $_POST['snr'];
    $shortName = $_POST['shortName'];
    $scientificName = $_POST['scientificName'];
    $deciGrams = $_POST['deciGrams'];
    updateTaxa($pdo, $id, $snr, $shortName, $scientificName, $deciGrams);
    updateSNR($pdo);
}


if ($_POST['mode'] === 'add'){

    $snr = $_POST['snr'];
    $shortName = $_POST['shortName'];
    $scientificName = $_POST['scientificName'];
    $deciGrams = $_POST['deciGrams'];
    writeTaxa($pdo, $snr, $shortName, $scientificName, $deciGrams);
    updateSNR($pdo);
}


if ($_POST['mode'] === 'delete'){
    $taxa_id = $_POST['taxa_id'];
    deleteTaxaTranslations($pdo, $taxa_id);
    deleteTaxa($pdo, $taxa_id);
}


function updateSNR($pdo){

    $data = getAllBaseTaxa($pdo);
    $snr = 10;
    foreach ($data as $taxa){
        $id = $taxa['ID'];
        updateTaxaSnr($pdo, $id, $snr);
        $snr = $snr + 10;
    }

}

