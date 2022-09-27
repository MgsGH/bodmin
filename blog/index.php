<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/aahelpers/common-functions.php";
include_once $path . "/aahelpers/db.php";



// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setAdditionalJavaScriptFiles('blog.js');
$pageMetaData->setAdditionalJavaScriptFiles('/aahelpers/blog-common.js');

//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');

$pageMenu = New TopMenu($language);
$pageMenu->setDagBokSelected();

?>

<?= getHtmlHead('', $pageMetaData, $language); ?>

<div class='basePage'>

    <?= getBannerHTML('Dagbok90.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="langAsNo" class="mg-hide-element"><?= getLang($language) ?></span>

    <div class="d-flex justify-content-between mt-2">
        <div class="std cal-nav-wide">
            <div id="blogCalendar" class="pt-2"></div>
            <div class="center-child">
                <p class="middle">
                    <small id="selectPanelSelect"></small><br/>
                </p>
                <p class="middle">
                    <strong><small id="selectPanelSignaturesOne"></small></strong><br>
                    <small id="selectPanelSignaturesTwo"></small>
                </p>
            </div>
        </div>
        <div class="std">

            <div id="oldPage" class="mg-hide-element">
                <br/>
                <div class="d-flex justify-content-center">
                    <div class="btn-group text-center" role="group" aria-label="Basic outlined example">
                        <button id="btnBackTop" type="button" class="btn btn-primary btn-sm"><<</button>
                        <button type="button" class="btn btn-outline-primary disabled mg-noBorder btn-sm">Bläddra</button>
                        <button id="btnNextTop" type="button" class="btn btn-primary btn-sm">>></button>
                    </div>
                </div>
                <div class="d-flex justify-content-center"><small id="browseTip"></small></div>
                <iframe id="pdfIframe" class="pt-2" src="" width="100%" height="1220px"></iframe>
            </div>

            <div id="theMostRecentBlogEntry" class="blogDay pb-2 mb-2">
                Content here!
            </div>

            <div class="d-flex justify-content-center mt-5">
                <div class="btn-group text-center" role="group" aria-label="Basic outlined example">
                    <button id="btnBackBottom" type="button" class="btn btn-primary btn-sm"><<</button>
                    <button type="button" class="btn btn-outline-primary disabled mg-noBorder btn-sm">&nbsp;&nbsp;Bläddra&nbsp;&nbsp;</button>
                    <button id="btnNextBottom" type="button" class="btn btn-primary btn-sm" disabled>>></button>
                </div>
            </div>
        </div>

    </div>
    <?=  getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());


