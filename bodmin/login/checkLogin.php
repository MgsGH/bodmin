<?php
session_start();

include_once '../../aahelpers/db.php';

$pdo = getDataPDO();
$userName = $_POST['username'];
$pwd = $_POST['pwd'];


if (!userNameExists($pdo,  $userName)){
    $ok = false;
    $error = "username";
} else {
    $ok = passWordCorrectForUser($pdo, $userName, $pwd);
    if (!$ok){
        $error = "password";
    }
}

if ($ok){
    $result = array('status' => 'ok');
} else {
    $result = array('status' => $error);
}


echo json_encode($result);


