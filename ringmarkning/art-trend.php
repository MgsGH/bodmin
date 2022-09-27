<?php
session_start();
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";
include_once "ringmarkning-functions.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('art-trend.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2021-11-29';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestLanguage();


$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$arterData = getMonitoredRingingSpecies($pdo, $language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

// fyren vår och höst, samt flommen
$dataFA = getTenYearRingingAverages($pdo, 'FA', $selectedArt);
$metaDataFA = getRingmarkningArtTrendMetaData($pdo, $selectedArt, 'FA', $language);

$dataFB = getTenYearRingingAverages($pdo, 'FB', $selectedArt);
$metaDataFB = getRingmarkningArtTrendMetaData($pdo, $selectedArt, 'FB', $language);

$dataFC = getTenYearRingingAverages($pdo, 'FC', $selectedArt);
$metaDataFC = getRingmarkningArtTrendMetaData($pdo, $selectedArt, 'FC', $language);

loadChartDataAndStoreInSession($pdo, $selectedArt);

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setArtTrendSelected();
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

                <p><?php //echo $texts->getTxt('art-alla-ar-intro-iii') ?></p>
                <?php writeSignificanceLegend($texts) ?>
                <br/>
                <?php writeArtTrendChartForklaring($texts) ?>

            </div>


            <div class="std">
                <div>
                    <h2><?= $texts->getTxt('artTrend') ?></h2>
                </div>

                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET">
                        <input type="hidden" id="lang" name="lang" value="<?= $language ?>">
                        <div class="Xmg-yellow d-flex">
                        <div class="mgpt-2 pr-2">
                        <span><?= $texts->getTxt('valj-art') ?></span>
                        </div>
                        <div>
                            <select name="art" class="form-select js-example-basic-single">
                                <?php
                                foreach ($arterData as $art){
                                    $txt = $art['NAMN'];
                                    echo getDropDownOption($txt, $art['art'], $selectedArt);
                                };
                                ?>
                            </select>
                        </div>
                        </div>
                        <div class="pt-2">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $texts->getTxt('visa-data-knapp') ?>
                        </button>
                        </div>
                        <br/>
                    </form>
                </div>
                <div class="pt-4">
                    <h3><?php echo $texts->getTxt('FA') ?></h3>
                    <?php writeLocationInfoSection($dataFA, $metaDataFA, $texts, 'FA') ?>
                    <h3><?php echo $texts->getTxt('FB') ?></h3>
                    <?php writeLocationInfoSection($dataFB, $metaDataFB, $texts, 'FB') ?>
                    <h3><?php echo $texts->getTxt('FC') ?></h3>
                    <?php writeLocationInfoSection($dataFC, $metaDataFC, $texts, 'FC') ?>
                </div>
            </div>
        </div>
        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
