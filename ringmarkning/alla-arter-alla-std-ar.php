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
$pageMetaData->setAdditionalJavaScriptFiles('alla-arter-alla-std-ar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

$pdo = getDataPDO();
$language = getRequestLanguage();
$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

//footer info
$introText = ' ';
$updatedDate = '2021-11-29';
$updatedBy = ' ';

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setAllaArterAllaStdAr();

echo getHtmlHead('', $pageMetaData, $language);
?>

    <div class="basePage">

        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav">
                <p><?php echo $texts->getTxt('asa-intro-text-1') ?></p>
            </div>

            <div class="std">
                <h2><?php echo $texts->getTxt('asa-header') ?></h2>
                <?php
                    writePost79AllYearsTable($pdo, $language, $texts);
                ?>
            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());