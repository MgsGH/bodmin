<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/aahelpers/common-functions.php";
include_once $path . "/aahelpers/db.php";

include_once $path . "/strack/StrackHeaderTexter.php";
include_once $path . "/strack/StrackTexter.php";
include_once $path . "/strack/StrackMenu.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/strack/strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('miljo-overvakning.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2022-09-01';
$updatedBy = '';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');

$texts = new StrackTexter($language);

$headerTexts = new StrackTexter($language);
$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

$sectionMenu = new StrackMenu($language);
$sectionMenu->setMiljoOvervakningSelected();

?>

    <div class="basePage">

        <?= getBannerHTML('../nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">
                <h3><?= $texts->getTxt('header-miljo-overvakning') ?></h3>
                <p> <?= $texts->getTxt('mo-intro-1') ?> </p>
                <p> <?= $texts->getTxt('mo-intro-2') ?> </p>
                <p> <?= $texts->getTxt('mo-intro-3') ?> </p>

                <?php // echo getNavigationCalendarTableAsHTML($language, $eventDates, $year, $month, $selectedRingingDate); ?>
                <div>
                    <?php //echo $texts->getTxt('info') ?>
                </div>
            </div>

            <div class="std">
                <h2><?php //echo $texts->getTxt('dag-title') . $selectedRingingDate ?> </h2>
                <?php //writeRingingTablesSection($connection, $ringingLocationsThisDate, $selectedRingingDate, $texts, $language ) ?>

            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());