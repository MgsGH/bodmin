<?php
session_start();
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";
include_once "ringmarkning-functions.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('alla-arter-alla-ar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-12';
$updatedBy = ' ';

$pdo = getDataPDO();
$languageISO = getRequestValueWithDefault('lang', 'sv');

$texts = new RingTexter($languageISO);
$pageMenu = New TopMenu($languageISO);
$pageMenu->setMarkningSelected();

echo getHtmlHead('', $pageMetaData, $languageISO);

$sectionMenu = new RingmarkningMenu($languageISO);
$sectionMenu->setAllaArterAllaArSelected();

?>

    <div class="basePage">

        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($languageISO) ?></span>


        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav">
                <h5 class="pt-2"><?php echo $texts->getTxt('alla-arter-alla-ar-intro-hdr') ?> </h5>
                <p> <?php echo $texts->getTxt('alla-arter-alla-ar-intro-i') ?> </p>
                <p> <?php echo $texts->getTxt('alla-arter-alla-ar-intro-ii') ?> </p>

            </div>

            <div class="std">
                <h2><?php echo $texts->getTxt('alla-arter-alla-ar-main-header') ?> </h2>


                <?php writeAllSpeciesAllYearsTable($pdo, $texts, $languageISO) ?>

            </div>

        </div>
        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());