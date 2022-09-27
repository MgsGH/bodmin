<?php
include_once "LokalerMenu.php";
include_once "LokalerTexter.php";
include_once "LokalerHeaderTexter.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('lokalerHeader.js?dummy=' . $t);
$pageMetaData->setAdditionalJavaScriptFiles('loadHeaderTexts.js');
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
$sectionMenu->setFlommenSelected();
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
                <h2><?= $texts->getTxt('flommen-header') ?></h2>
                <p><?= $texts->getTxt('flommen-1') ?></p>
                <p><?= $texts->getTxt('flommen-2') ?></p>
                <p><?= $texts->getTxt('flommen-3') ?></p>
                <p><?= $texts->getTxt('flommen-4') ?></p>
            </div>

            <div class="std mr-3">
                <br>
                <img src="/bilder/flommenvass2.jpg" class="shadow" alt="Bild på vass i flommen">
            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

