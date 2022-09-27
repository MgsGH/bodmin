<?php
session_start();

session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/common-functions.php';
include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/AppMenu.php';
include_once $path . "/aahelpers/PageMetaData.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('this-page.js?dummy=');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setSelect2(true);


//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$module = 12;
$errorPage = 'login\index.php';

$language = getRequestLanguage();
$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: http://anka.localhost/login/index-empty.php");
    exit;
}

echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($module);
echo $appMenu->getAsHTML();



?>

    <div class="container">
        <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>
        <br/>
        <h1 id="hdrMain"></h1>
        <p></p>
    </div>


<?= getHTMLEnd();
