<?php
include_once 'OmStationenTexter.php';
include_once 'OmOssMenu.php';
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/common-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('headerOmOss.js?dummy=' . $t);

//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new OmStationenTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setJulgavaSelected();

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
?>


    <div class="basePage">

        <?=  getBannerHTML( 'omossvinjett.png'); ?>
        <?=  $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>


            <div class="std">
                <h1><?php echo $texts->getTxt('julgava-header') ?></h1>
            </div>
        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());