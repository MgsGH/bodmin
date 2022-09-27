<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();
$ringingRecId = $_POST['ringing_record_id'];
logg('');
logPostData();


deleteMeasurements($pdo, $ringingRecId);


foreach ($_POST as $item => $value){

    if ($item !== 'ringing_record_id'){
        $user = $_SESSION['userId'];
        $measurementId = substr($item, 14);

        logg($measurementId);

        writeMeasurementData($pdo, $ringingRecId, $measurementId, $value, $user);
    }

}

/*
   taxa_id: 2
   measurementId-5: EnNyKod
   012345678990123

 */




