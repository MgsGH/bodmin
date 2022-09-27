<?php
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";

include_once "LokalerMenu.php";
include_once "LokalerTexter.php";
include_once "LokalerHeaderTexter.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('lokalerHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setLeafLet(true);

//footer info
$introText = ' ';
$updatedDate = '2022-04-17';
$updatedBy = ' ';

$language = getRequestValueWithDefault('lang', 'sv');
$texts = new LokalerTexter($language);
$headerTexts = new LokalerHeaderTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setLokalerSelected();

$sectionMenu = new LokalerMenu($language);
$sectionMenu->setLokalerSelected();

echo getHtmlHead('', $pageMetaData, $language);

?>

    <div class="basePage">

        <?= getBannerHTML('fbowide100h.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">
                <h2><span id="headerOverView">Översikt</span></h2>
                <p><span id="introOverView">Klicka i kartan eller använd menyn till vänster.</span></p>
                <div id="dataMap">
                    <div id="rmap" style="height: 600px"></div>
                </div>
            </div>


        </div>


        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

