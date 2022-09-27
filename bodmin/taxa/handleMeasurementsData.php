<?php

session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();
$taxa_id = $_POST['taxa_id'];
deleteTaxaMeasurementConfiguration($pdo, $taxa_id);

logPostData();
logg('');

$noOfRecords = (sizeof($_POST)-1)/6;
$keys = array_keys( $_POST );
$i = 0;
$r = 0;
while($i < ($noOfRecords)) {

    $f = 1;

    while ($f <= 6) {

        $keyIndex = $r + $f;
        $postVar = $keys[$keyIndex];

        switch ($f) {
            case 1:
                $measurementType = $_POST[$postVar];
                break;
            case 2:
                $sex = $_POST[$postVar];
                break;
            case 3:
                $age = $_POST[$postVar];
                break;
            case 4:
                $month = $_POST[$postVar];
                break;
            case 5:
                $min = $_POST[$postVar];
                break;
            case 6:
                $max = $_POST[$postVar];
                break;
        }
        $f++;
    }

    writeTaxaMeasurementConfiguration($pdo, $taxa_id, $measurementType, $sex, $age, $month, $min, $max);

    $r = $r + 6;
    $i++;

}


/*

Example of two records coming via the post.
Note that a complete sequence of the field index as slct-age-1, slct-age-2 etc. below, cannot be expected.

taxa_id: 4

slct-measurements-2: 1
slct-age-2: 0
slct-sex-2: 0
slct-month-2: 1,2,3,4,5,6,7,8,9,10,11,12
#id-min-2: 10
#id-max-2: 20

slct-measurements-3: 2
slct-age-3: 0
slct-sex-3: 0
slct-month-3: 1,2,3,4,5,6,7,8,9,10,11,12
#id-min-3: 20
#id-max-3: 30


*/

// post juvenile moult
// moult -> wing moult
