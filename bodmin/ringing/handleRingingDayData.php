<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();
$mode = $_POST['mode'];
$date = $_POST['date'];
$location = $_POST['location'];
$user = $_SESSION['userId'];
//logPostData();
//logSessionData();

$id = 0;

if ($mode === 'ongoing'){

    $status = 1;
    writeRingingDateLocation($pdo, $date, $location, $status, $user);
    $id = ringingDateLocationAlreadyEntered($pdo, $date, $location);

}


if ($mode === 'done'){
    $status = 2;
    updateRingingDateLocation($pdo, $date, $location, $status, $user);
}

echo($id);







