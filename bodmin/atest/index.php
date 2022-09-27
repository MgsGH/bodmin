<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/PageMetaData.php';
include_once $path . '/aahelpers/common-functions.php';


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('atest.js');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);

//footer info
$introText = ' ';
$updatedDate = '2021-12-21';
$updatedBy = ' ';

echo getHtmlHead('anka', $pageMetaData, '2');

?>
    <div class="basePage">

        <?= getBannerHTML('/bilder/noheader.jpg'); ?>
        <span id="lang" class="mg-hide-element">2</span>
        <hr>

        <div class="d-flex">

            <div class="std">
                <h1>Test section</h1>
                <p><a href="imagePopup/index.php">Editing photo data - including update the DB</a></p>
                <p><a href="paths/index.php">Server variables and paths</a></p>
            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>

    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
