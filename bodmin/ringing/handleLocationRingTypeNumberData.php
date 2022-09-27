<?php

session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

//logPostData();

$location_id = $_POST['location_id'];
deleteRingTypeLocationRingNo($pdo, $location_id);

// Two fields for each record
$noOfRecords = (sizeof($_POST)-1)/2;
$keys = array_keys( $_POST );

$record = 1;
$recPointer = 0;
while($record <= ($noOfRecords)) {

    $postVar = $keys[$record+$recPointer];
    $ring_type_id = $_POST[$postVar];
    $postVar = $keys[$record+$recPointer+1];
    $ring_no = $_POST[$postVar];

    writeRingTypeLocationRing($pdo, $location_id, $ring_type_id, $ring_no);

    $recPointer = $recPointer + 1;
    $record++;

}



