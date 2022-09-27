<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/functions.php';

$pdo = getDataPDO();


if ($_POST['mode'] === 'edit'){
    $fname = $_POST['fname'];
    $ename = $_POST['ename'];
    $refname = $_POST['refname'];
    $websajt = $_POST['websajt'];
    $passed = $_POST['passed'];
    $webtext = $_POST['webtext'];
    $signature = $_POST['signature'];
    $loggedInUser = $_SESSION['userId'];
    $id = $_POST['id'];
    updatePerson($pdo, $id, $fname, $ename, $refname, $websajt, $passed, $webtext, $loggedInUser, $signature);
}


if ($_POST['mode'] === 'add'){
    $fname = $_POST['fname'];
    $ename = $_POST['ename'];
    $refname = $_POST['refname'];
    $websajt = $_POST['websajt'];
    $passed = $_POST['passed'];
    $webtext = $_POST['webtext'];
    $signature = $_POST['signature'];
    $loggedInUser = $_SESSION['userId'];
    $id = 0;
    writePerson($pdo, $id, $fname, $ename, $refname, $websajt, $passed, $webtext, $loggedInUser, $signature);
}


if ($_POST['mode'] === 'delete'){
    $id = $_POST['id'];
    deleteEmailForPersonId($pdo, $id);
    deletePerson($pdo, $id);
}


