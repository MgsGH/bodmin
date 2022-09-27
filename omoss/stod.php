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
$updatedDate = '2021-11-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new OmStationenTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setStodSelected();

?>
    <?=  getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language); ?>
    <div class="basePage">

        <?=  getBannerHTML( 'omossvinjett.png'); ?>
        <?=  $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">
                <h2><?= $texts->getTxt('stod-header') ?></h2>
                <p><?= $texts->getTxt('stod-header-text') ?></p>
                <h3><?= $texts->getTxt('stod-typer') ?></h3>
                <ul>
                    <li><?= $texts->getTxt('stod-li-1') ?> - <a href="bidrag.php"><?= $texts->getTxt('stod-li-1-linktext') ?></a></li>
                    <li><?= $texts->getTxt('stod-li-2') ?> - <a href="hyllningsgava.php"><?= $texts->getTxt('stod-li-2-linktext') ?></a></li>
                    <li><?= $texts->getTxt('stod-li-3') ?> - <a href="minnesgava.php"><?= $texts->getTxt('stod-li-3-linktext') ?></a></li>
                    <li><?= $texts->getTxt('stod-li-4') ?> - <a href="julgava-empty.php"><?= $texts->getTxt('stod-li-4-linktext') ?></a></li>
                    <li><?= $texts->getTxt('stod-li-5') ?> - <a href="arvsgava.php"><?= $texts->getTxt('stod-li-5-linktext') ?></a></li>
                </ul>

                <h3><?= $texts->getTxt('stod-reach') ?></h3>
                <p><?= $texts->getTxt('stod-90-1') ?></p>
                <div class="mt-3 mb-3"><img src="https://www.insamlingskontroll.se/wp-content/uploads/2021/10/insamlingskontroll_logga.svg" width="300"></div>
                <p class="mt-2"><?= $texts->getTxt('stod-90-2') ?></p>
                <p><?= $texts->getTxt('stod-90-3') ?></p>
                <p><strong><?= $texts->getTxt('stod-90-nummer') ?></strong></p>
                <p><?= $texts->getTxt('stod-90-huvudman') ?>. </p>
            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

printf($pageMetaData->getJavaScriptSection());