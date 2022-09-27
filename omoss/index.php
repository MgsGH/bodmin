<?php
include_once 'OmStationenTexter.php';
include_once 'OmOssMenu.php';
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
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
$sectionMenu->setVerksamhetSelected();

?>

    <?=  getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language); ?>
    <div class="basePage">
        <?=  getBannerHTML( 'omossvinjett.png'); ?>
        <?=  $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="d-flex mt-2">

            <div>
                <?=  $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">
                <h2><?=  $texts->getTxt('verksamhet-header') ?></h2>
                <div>
                    <h3><?= $texts->getTxt('verksamhet-forskning') ?></h3>
                    <p><?= $texts->getTxt('verksamhet-intro') ?> </p>
                </div>
                <div class="d-flex">
                    <div class="std-right">
                        <h4><?=  $texts->getTxt('verksamhet-sub-header-mon') ?></h4>
                        <img src="https://www.falsterbofagelstation.se/stodoss/bilder/phcol_stskv_JL.jpg" style="width:249px;height:122px;" alt="Stöd oss logga">
                        <p><?=  $texts->getTxt('verksamhet-mon-content-1') ?></p>
                        <p><?=  $texts->getTxt('verksamhet-mon-content-2') ?></p>
                    </div>
                    <div class="std">
                        <h4><?=  $texts->getTxt('verksamhet-sub-header-mon-loc') ?></h4>
                        <img src="https://www.falsterbofagelstation.se/stodoss/bilder/recavo9838B_pgb_300.jpg" style="width:249px;height:122px;">
                        <p><?=  $texts->getTxt('verksamhet-mon-loc-content') ?></p>
                    </div>
                    <div class="std">
                        <h4><?=  $texts->getTxt('verksamhet-sub-header-edu') ?></h4>
                        <img src="https://www.falsterbofagelstation.se/stodoss/bilder/gw70_guidn_bm_300.jpg" style="width:249px;height:122px;">
                        <p><?=  $texts->getTxt('verksamhet-edu-content') ?></p>
                    </div>
                </div>

                <div class="center">
                    <h3><a href="stod.php"><?=  $texts->getTxt('verksamhet-stod-oss') ?></a></h3>
                    <p><?=  $texts->getTxt('verksamhet-stod-alla-bidrag') ?></p>
                    <p><a href="stod.php"><?=  $texts->getTxt('verksamhet-stod-las-mer') ?></a></p>
                </div>
                
            </div>

        </div>

        <?=  getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());