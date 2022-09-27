<?php
session_start();

include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";

include_once "ringmarkning-functions.php";
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";

// decides linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('vecka.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootStrapFyra(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2019-11-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new RingTexter($language);
$pdo = getDataPDO();

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setVeckanSelected();


?>

    <?php echo getHtmlHead('', $pageMetaData, $language) ?>
    <div class="basePage">
        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">
                <h1 id="pageHeader">Senaste sju dagarna</h1>
                <div id="dataArea">

                </div>
            </div>
        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());