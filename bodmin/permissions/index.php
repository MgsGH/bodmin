<?php
session_start();

include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 11;
$errorPage = 'login\index.php';

$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: http://anka.localhost/login/index-empty.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(10);
echo getHTMLHeader();
echo $appMenu->getAsHTML();

?>

    <div class="container">
        <br/>
        <h1 id="hdrMain"></h1>
        <p></p>
    </div>

<?= getHTMLEnd();
