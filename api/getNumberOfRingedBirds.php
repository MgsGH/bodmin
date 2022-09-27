<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$taxon = $_GET['taxon'];

// Detta skript tar ut totalt antal märkta fåglar av en viss *art*
// FÖRE 1980 - I DESSA DATA FINNS INGA RASER ANGIVNA
$ringedPre80 = getRingedPre80($pdo, $taxon);


// FR.O.M. 1980 - Följande raser har särskiljts. Dessa underarter ingår i dagssummorna för respektive "moderart"
// men ligger separat (också) i en egen tabell - rasdagsum
$subSpecies = 'CAALP, CASCH, TTTOT, TTROB, PCABI, PCCOL, PCTRI, ACCAU, ACEUR, NCCAR, NCMAC, CFCAB, CFMEA';


$taxonIsSubSpecies = strpos($subSpecies, $taxon);
if ($taxonIsSubSpecies) {
    $ringedPost79 = getRingedSubSpeciesPost79($pdo, $taxon);
} else {
    $ringedPost79 = getRingedSpeciesPost79($pdo, $taxon);
}

$totalRinged = $ringedPre80 + $ringedPost79;

$data = array();
$data[] = $totalRinged;
echo json_encode($data);