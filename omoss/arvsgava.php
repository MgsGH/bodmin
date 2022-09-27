<?php

include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/PageMetaData.php";
include_once 'OmStationenTexter.php';
include_once 'OmOssMenu.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
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
$sectionMenu->setArvSelected();
echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
?>

    <div class="basePage">

        <?=  getBannerHTML( 'omossvinjett.png'); ?>
        <?=  $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std div-max-100-pct">

                <div>
                    <h2><?= $texts->getTxt('arvsgava-header') ?></h2>

                </div>

                <div class="div600">
                    <p><?= $texts->getTxt('arvsgava-para-1') ?></p>

                    <p><?= $texts->getTxt('arvsgava-para-2') ?></p>
                    <p><?= $texts->getTxt('arvsgava-para-3') ?></p>

                    <p>
                    <p><span id="mottagare"><?= $texts->getTxt('arvsgava-data') ?></span>:
                        <ul>
                        <li><span id="mottagare"><?= $texts->getTxt('arvsgava-gåvomottagare') ?></span>: Falsterbo Fågelstation.</li>
                        <li><span id="organisationsnummer"><?= $texts->getTxt('arvsgava-organisationsnummer') ?></span>: 845000-8399, Skånes Ornitologiska Förening.</li>
                        <li><span id="bankgiro"><?= $texts->getTxt('arvsgava-bankgiro') ?>: 900-3013. Plusgiro: 900301-3.</li>
                        <li><span id="betalningsmottagare"><?= $texts->getTxt('arvsgava-betalningsmottagare') ?>: Skånes Ornitologiska Förening.</li>
                        </ul>
                    <br/>
                    <strong id="contactpersons"><?= $texts->getTxt('arvsgava-contact') ?>:</strong><br/>
                    Karin Persson 040-473703<br/>
                    Björn Malmhagen 0703-339499<br/>
                </div>

            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());