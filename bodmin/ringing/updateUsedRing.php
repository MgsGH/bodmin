<?php

session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();
$ringNoLocationsRecId = $_POST['ringNoLocationsId'];
$nextRingNo = $_POST['nextRingNo'];

//logPostData();
//logSessionData();

updateUsedRingNo($pdo, $ringNoLocationsRecId, $nextRingNo);




