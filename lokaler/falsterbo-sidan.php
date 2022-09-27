<?php
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";

include_once "LokalerMenu.php";
include_once "LokalerTexter.php";
include_once "LokalerHeaderTexter.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('lokalerHeader.js?dummy=' . $t);
$pageMetaData->setAdditionalJavaScriptFiles('falsterbosidan.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new LokalerTexter($language);
$headerTexts = new LokalerHeaderTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setLokalerSelected();

$sectionMenu = new LokalerMenu($language);
$sectionMenu->setFalsterboSidanSelected();
echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

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

                <h2><?= $texts->getTxt('fbo-sidan-header') ?></h2>

                <p><?= $texts->getTxt('fbo-sidan-1') ?></p>

                <h3><?= $texts->getTxt('vag-beskrivningar') ?></h3>
                <p><?= $texts->getTxt('fbo-sidan-2') ?></p>
                <p><?= $texts->getTxt('fbo-sidan-3') ?></p>
            </div>

            <div class="std mr-3">
                <div class="mb-3">
                    <img src="/bilder/nabben-syd.jpg" class="shadow" alt="vy över nabben mot söder">
                </div>
                <div class="mt-3">
                    <p><img src="/bilder/karta1_ettlager_sve.jpg" class="shadow" alt="karta"></p>
                </div>

             </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

