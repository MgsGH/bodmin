<?php

session_start();

include_once '../aahelpers/db.php';
include_once '../aahelpers/functions.php';

$pdo = getPDO();

logPostData();

$user = $_SESSION['userId'];
$id = $_POST['id'];

$hour = $_POST['hour'];
$systematic = $_POST['systematic'];
$trap = $_POST['trap'];
$extra = $_POST['extra'];
//
$taxon = $_POST['taxon'];
$ring = $_POST['ring'];
$age = $_POST['age'];
$sex = $_POST['sex'];
$wing = $_POST['wing'];

$fat = $_POST['fat'];
$weight = $_POST['weight'];
$pullMoult = $_POST['pullMoult'];
$secMoult = $_POST['secMoult'];
$priMoult = $_POST['priMoult'];
$user = $_SESSION['userId'];


   //                      1    2          3         4        5       6     7      8     9     10
updateRingingRecord($pdo, $id, $hour, $systematic, $trap, $extra, $taxon, $ring, $age, $sex,  $user);

