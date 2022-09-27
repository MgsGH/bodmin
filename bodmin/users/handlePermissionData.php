<?php


$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';

$pdo = getDataPDO();
$userId = $_POST['userId'];
$permissions = $_POST['permissions'];

dbLog('Handle permissions');
logDataToBePosted();

// Delete the ones we have - if any
deleteTheUsersModulePermisions($pdo, $userId);

foreach($permissions as $permissionSetting){

    dbLog( $permissionSetting[0] . '  ' . $permissionSetting[1] );
    writeUserModulePermissionToDB($pdo, $userId, $permissionSetting[0], $permissionSetting[1]);
}





