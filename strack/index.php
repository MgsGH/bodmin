<?php
include_once "StrackHeaderTexter.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "StrackTexter.php";
include_once "StrackMenu.php";
include_once "../aahelpers/common-functions.php";
include_once '../aahelpers/navigationCalendar.php';
include_once "../aahelpers/db.php";
include_once "strack-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJquery(true);

//footer info
$introText = ' ';
$updatedDate = '2021-03-14';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');
$data = getMostRecentMigrationMonitoringDateData($pdo);
$maxDate = $data[0]['MAXDATUM'];


// 2012-12-01
// 0123456789
$defaultMonth = substr($maxDate, 5, 2);
$defaultYear = substr($maxDate, 0, 4);
$defaultDay = substr($maxDate, 8, 2);


$year = getRequestValueWithDefault('year', $defaultYear);
$month = getRequestValueWithDefault('month', $defaultMonth);
$day = getRequestValueWithDefault('dag', $defaultDay);

$eventDates = getStrackRakningsDagar($pdo, $year, $month);

$selectedEventDate = $year . "-" . $month . "-" . $day;


$texts = new StrackTexter($language);
$headerTexts = new StrackTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$data = getStrackData($pdo, $selectedEventDate, $language );

$sectionMenu = new StrackMenu($language);
$sectionMenu->setSenasteSelected();

?>
    <?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
    <div class="basePage">

        <?= getBannerHTML('nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">
            <div class="mg-blue">
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav pt-2">
                <h5><?= $texts->getTxt('dag-cal-title') ?></h5>
                <?= getNavigationCalendarTableAsHTML($language, $eventDates, $year, $month, $selectedEventDate); ?>
                <br/>
                <p><?= $texts->getTxt('intro-i') ?></p>
                <p><?= $texts->getTxt('intro-ii') ?></p>
                <hr>
                <div>
                    <br/>
                    <p><?= $texts->getTxt('info') ?></p>
                    <br/>
                    <br/>
                </div>
            </div>

            <div class="std">
                <h2><?= $texts->getTxt('page-header') ?> </h2>
                <h3><?= $texts->getTxt('page-sub-header') . $selectedEventDate ?> </h3>
                <?php writeDayTable($data, $texts) ?>
            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());