<?php

include_once '../aahelpers/db.php';

$pdo = getDataPDO();
$taxon = $_GET['taxon'];

// Some species are entered as sub-species (with their own code) when ringed. Recovery information contains this sub-species information.
// Asking for one of those split-species should give ALL recoveries, no matter what the sub-species.
// In the recovery table all taxa have the "code" and also a systematic number. The systematic number is the same for all sub-
// species across their codes.
// So, if a request taxon is a "split-species" use the systematic number, otherwise use the taxon-code.


dbLog('Row 15, getRecoveries, Taxon ' . $taxon);

$splitSpecies = 'KÄSNÄ, RÖBEN, PHCOL, STMES, NÖKRÅ, CAFLA';

if ( strpos($splitSpecies, $taxon ) === false ) {
    $data = getRecoveriesByTaxonCode( $pdo, $taxon );
} else {
    // taxon is a split-species, get the snr and use this for retrieving the data
    $snr = getSnrByTaxonCode($pdo, $taxon );
    $data = getRecoveriesByTaxonSNR( $pdo, $snr );
}

echo json_encode($data);