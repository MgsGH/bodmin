<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();

$logged_in_user = $_POST['logged_in_user'];
$table_id = $_POST['table_id'];
$pwd = $_POST['pwd'];
$user_name = $_POST['user_name'];
$person_id = $_POST['person_id'];
$language = $_POST['language'];
$activated = $_POST['activated'];

logDataToBePosted();

if ($_POST['mode'] === 'edit'){
    updateUser($pdo, $table_id, $user_name, $person_id, $language, $activated);
}


if ($_POST['mode'] === 'add'){

    $writtenId = writeUser($pdo, $table_id, $user_name, $pwd, $person_id, $language, $activated, $logged_in_user);

    $record['ID'] = $writtenId;
    $jsonData = json_encode($record);
    echo($jsonData);

}


if ($_POST['mode'] === 'delete'){

    deleteTheUsersModulePermisions($pdo, $table_id);
    deleteUser($pdo, $table_id);

}



if ($_POST['mode'] === 'pwd-reset') {
    updatePassWord($pdo, $pwd, $table_id);
}



