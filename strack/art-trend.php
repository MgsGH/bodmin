<?php
session_start();
include_once "StrackHeaderTexter.php";
include_once "StrackTexter.php";
include_once "StrackMenu.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";
include_once "strack-functions.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('art-trend.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-18';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');

$texts = new StrackTexter($language);
$headerTexts = new StrackTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$arterData = getStracktaOchFoljdaArter($pdo,$language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

$data = getTenYearStrackAverages($pdo, $selectedArt);
$metadata = getNabbenStatMetaData($pdo, $selectedArt, $language);

loadChartDataAndStoreInSession($pdo, $selectedArt);

$sectionMenu = new StrackMenu($language);
$sectionMenu->setArtTrendSelected();

?>

    <?php echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
    <div class="basePage">

        <?= getBannerHTML('nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>
            <div class="std cal-nav">
                <form name="visavad" method="GET">

                    <div class="pt-2">
                        <h5><?php echo $texts->getTxt('valj-art') ?></h5>
                    </div>

                    <select name="art" class="form-select js-example-basic-single">
                        <?php
                        foreach ($arterData as $art){
                            $txt = $art['NAMN'];
                            echo getDropDownOption($txt, $art['art'], $selectedArt);
                        };
                        ?>
                    </select>

                    <div class="pt-3">
                        <button type="submit" class="btn btn-primary"><?php echo $texts->getTxt('show-data') ?></button>
                    </div>

                </form>
                <div class="pt-2">
                    <p><?php echo $texts->getTxt('strack-trend-intro-i') ?></p>
                    <p><?php writeArtTrendChartForklaring($texts) ?></p>
                    <p><?php writeSignificanceLegend($texts); ?></p>
                    <p><?php //echo $texts->getTxt('art-alla-ar-intro-iv') ?></p>
                    <p><?php //echo $texts->getTxt('art-alla-ar-intro-v') ?></p>

                </div>


                <br/>
            </div>

            <div class="std">
                <h2><?php  echo $texts->getTxt('mo-pop-trender-hdr') ?></h2>
                <h3><?php echo $_SESSION['last-selected'] ?></h3>
                <div class="flex">
                    <div><img src="strack-chart.php?art=<?php echo ($selectedArt) ?>"></div>
                    <div class="std">
                        <br/><br/><?php writeTenYearAverageTable($data, $texts) ?>
                    </div>
                </div>
                <p><?php writeMetaDataInfo($metadata, $texts) ?> </p>
                <p class="info"></p>
            </div>
        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
