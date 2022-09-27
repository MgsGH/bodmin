<?php


include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$taxon = $_GET['taxon'];
$language = $_GET['language'];

$data = getArtFyndData( $pdo, $taxon, $language );

echo json_encode($data);
