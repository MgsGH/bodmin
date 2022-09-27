<?php
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
$pageMetaData->setAdditionalJavaScriptFiles('oversikt.js');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);


//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 4;
$module = 3;
$errorPage = 'login\index.php';
$language = getRequestLanguage();

$pdo = getDataPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $module, $pdo)) {
    header( "location: https://falsterbofagelstation.se/bodmin/login");
    exit;
}

echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($module);
echo $appMenu->getAsHTML();


?>
    <!-- main page -->
    <div class="container-fluid mg-white-smoke">
        <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>
        <div class="d-flex">

            <div class="mg-sidenav-news std">
                <h2 id="hdrMain">Guidningar</h2>
                <h3 id="hdrSubMain">Översikt</h3>
                <div id="datepicker" class="pb-3">
                </div>
                <div class="pb-2">
                </div>
                <hr>
                <small id="selectInfo"></small>
                <br/>


                <br/>
                <div id="infoLabel" style="background-color: aliceblue" class="mg-text-center">
                    <small></small>
                </div>

            </div>

            <div class="std">
                <br/>
                <h6>Denna sektion kommer att innehålla olika typer av information om våra guidningar.</h6>
                <p>Information om informationen, helt enkelt. Detta är delvis sådan information vi visar på sajten för andra typer av data vi har, till exempel ringmärkningsdata. Ett exempel ät hur många fåglar har vi fångat per dag och säsong. Här kommer vi att sammanställa samma typ av data, fast för guidningarna.</p>
                <p>Eftersom jag antar att denna information inte är behövs *nu* kan vi fylla på här, steg för steg, senare.</p>


            </div>
        </div>

    </div>



<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

/*
 * SELECT
    `fbo_ver_1`.`besokstider`.`Datum` AS `DATE`,
    `fbo_ver_1`.`besokstider`.`Tid` AS `TIME`,
    `fbo_ver_1`.`guidebokning`.`Grupp` AS `PARTY`,
    `fbo_ver_1`.`besokstider`.`G_antal` AS `PARTICIPANTS`
FROM
    `fbo_ver_1`.`besokstider`
JOIN `fbo_ver_1`.`guidebokning` WHERE
    `fbo_ver_1`.`besokstider`.`G_ID` = `fbo_ver_1`.`guidebokning`.`G_ID`
 */
