<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . '/aahelpers/common-functions.php';
include_once $path . "/sales/SalesMenu.php";
include_once $path . "/sales/data/db.php";

$pdo = getSalesPDO();

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');

$pageMetaData->setAdditionalJavaScriptFiles('dekaler.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);


$sectionMenu = new salesMenu('sv');
$sectionMenu->setDekalerSelected();
$language = 1;

echo getHtmlHead('', $pageMetaData, $language);
?>
<div class="basePage">

    <div class="container-fluid" id="pageHeader">

    </div>
    <div class="d-flex mt-2">

        <div class="std cal-nav pt-2">
            <?= $sectionMenu->getHTML(); ?>
        </div>

        <div class="std">
            <div id="intro">
                <h2>Dekaler</h2>
                <h5></h5>
                <div id="introText">

                </div>
                <div class="mb-2">
                   <!-- Klicka på artikeln nedan för att se mer information (och beställa). -->
                </div>
            </div>

            <div id="itemList">

            </div>
            <div class="mt-5">
                <h3 class="text-center">Tillfälligt stängt. Återöppnar inom kort</h3>
            </div>

        </div>
    </div>

</div>


</html>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());


