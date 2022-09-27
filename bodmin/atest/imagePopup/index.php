<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/PageMetaData.php';
include_once $path . '/aahelpers/common-functions.php';


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/aahelpers/PhotoPopUp.js');
$pageMetaData->setAdditionalJavaScriptFiles('imagePopUpTest.js');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setSelect2(true);
$pageMetaData->setCropper(true);

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
                <input type="text" maxlength="5" id="testId" value="0">
                <button id="newPhoto" class="btn btn-outline-success">New photo - test</button>
                <button id="editPhoto" class="btn btn-outline-primary">Edit photo - test</button>
                <button id="deletePhoto" class="btn btn-outline-danger">Delete photo - test</button>
            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>


<?php
require $path . "/aahelpers/popUpImage.php";
?>



<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
