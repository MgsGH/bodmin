<?php

include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";
include_once "../aahelpers/navigationCalendar.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";
include_once "ringmarkning-functions.php";

// decides linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootStrapFyra(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2022-03-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');
$month = getRequestValueWithDefault('month', getCurrentMonth());
$year = getRequestValueWithDefault('year', getCurrentYear());
$day = getRequestValueWithDefault('dag', getCurrentDayNo());
$eventDates = getMarkDagar($pdo);

$selectedEventDate = $year . "-" . $month . "-" . $day;

$texts = new RingTexter($language);

// check if year, month, and day is set, otherwise pick up most recent ringing date
$selectedRingingDate = getRingingDate($pdo);

$ringingLocationsThisDate = getRingingLocationsThisDate($pdo, $selectedRingingDate);

$headerTexts = new RingTexter($language);
$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setSenasteSelected();
echo getHtmlHead('', $pageMetaData, $language);
?>

    <div class="basePage">
        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
        <div class="d-flex mt-2">

            <?php echo $sectionMenu->getHTML(); ?>

            <div class="std cal-nav pt-2">
                <h5><?php echo $texts->getTxt('dag-cal-title') ?></h5>
                <?= getNavigationCalendarTableAsHTML($language, $eventDates, $year, $month, $selectedEventDate); ?>
            </div>

            <div class="std">
                <h2><?php echo $texts->getTxt('dags-summa-rubrik') ?> </h2>
                <h3><?php echo $texts->getTxt('dag-title') . $selectedRingingDate ?> </h3>
                <?php writeRingingTablesSection($pdo, $ringingLocationsThisDate, $selectedRingingDate, $texts, $language ) ?>
            </div>
        </div>
        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());