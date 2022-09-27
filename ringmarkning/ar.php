<?php
session_start();
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";

include_once "ringmarkning-functions.php";
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ar.js');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);


//footer info
$introText = ' ';
$updatedDate = '2021-07-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestLanguage();

$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();
$startYear = 1947;
$defaultYear = getCurrentYear()-1;
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectYear;
$dropDownRingingYears = getDropDownYears($startYear);

echo getHtmlHead('', $pageMetaData, $language);

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setArSelected();
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
                <form name="visavad" method="GET">
                    <input type="hidden" id="lang" name="lang" value="<?php echo $language ?>">
                    <div class="pt-2">
                    <h4><?php echo $texts->getTxt('select-year-text') ?></h4>
                    </div>
                    <select name="year" class="form-select">
                        <?php
                        echo getDropDownOption($texts->getTxt('alla-ar'), 'alla', $selectYear);
                        foreach ($dropDownRingingYears as $year){
                            $txt = $year;
                            echo getDropDownOption($txt, $year, $selectYear);
                        };
                        ?>
                    </select>
                    <br/>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $texts->getTxt('visa-ar-knapp') ?>
                        </button>
                    </div>
                    <br/>
                </form>
                <div class="pt-2">
                    <p><?php echo $texts->getTxt('ar-intro-text-1') ?></p>
                    <p><?php echo $texts->getTxt('ar-intro-text-2') ?></p>
                    <p><?php echo $texts->getTxt('ar-intro-text-3') ?></p>
                </div>
            </div>

            <div class="std">
                <h2><?php echo $texts->getTxt('ar-page-header'). $selectYear ?></h2>
                <?php
                    writeYearTable($pdo, $selectYear, $texts, $language);
                ?>
            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());