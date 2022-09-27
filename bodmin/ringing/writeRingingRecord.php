<?php
session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();

// mode
$ongoing_day_id = $_POST['ongoing_day_id'];
$hour = $_POST['hour'];
$systematic = $_POST['systematic'];
$trap = $_POST['trap'];
$extra = $_POST['extra'];

$taxon = $_POST['taxon'];
$ring = $_POST['ring'];
$age = $_POST['age'];
$sex = $_POST['sex'];


$user = $_SESSION['userId'];


    //                               1                2          3      4        5       6     7        8     9     10
$status = writeRingingRecord($pdo, $ongoing_day_id, $hour, $systematic, $trap, $extra, $taxon, $ring, $age, $sex, $user);


echo($status);



