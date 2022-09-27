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
$pageMetaData->setAdditionalJavaScriptFiles('art-alla-ar.js');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);


//footer info
$introText = ' ';
$updatedDate = '2019-11-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestLanguage();

$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$arterData = getRingmarktaArter($pdo, $language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

$photoData = getVinjettBildsFotograf($pdo, $selectedArt);
$photographer = $photoData[0]['FOTO'];
$vinjettBildsHTML = getVinjettBildHTMLSection($pdo, $selectedArt, $photographer);

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setArtAllaArSelected();

$tableDataAsArray = getPost79YearDataForOneSpecies($pdo, $selectedArt, $language );
$summor = getSummorFor($tableDataAsArray);
$nyaTidenTot = $summor[5];

// old PRE -80 TABLE
$v47to59 = getPre80YearTotalsForOneSpecies($pdo, $selectedArt, '1946', '1960');
$v60to69 = getPre80YearTotalsForOneSpecies($pdo, $selectedArt, '1959', '1970');
$v70to79 = getPre80YearTotalsForOneSpecies($pdo, $selectedArt, '1969', '1980');
$pre80tot = getSummaFor($v47to59);
$pre80tot = $pre80tot + getSummaFor($v60to69);
$pre80tot = $pre80tot + getSummaFor($v70to79);


$headerText = getCurrentYear() . ' ' . $texts->getTxt('art-alla-ar-header-80+2');

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

            <div class="std cal-nav">
                <div class="pt-2">
                    <p><?php echo $texts->getTxt('art-alla-ar-intro-iii') ?></p>
                    <p><?php echo $texts->getTxt('art-alla-ar-intro-iv') ?></p>
                    <p><?php echo $texts->getTxt('art-alla-ar-intro-v') ?></p>
                </div>
            </div>

            <div class="std">
                <h2><?= $texts->getTxt('art-alla-ar-summary-main-header') ?></h2>
                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET">
                        <input type="hidden" id="lang" name="lang" value="<?php echo $language ?>">
                        <span><?php echo $texts->getTxt('valj-art') ?></span>
                        <select id="slctTaxon" name="art" class="form-select js-example-basic-single">
                            <?php
                            foreach ($arterData as $art){
                                $txt = $art['NAMN'];
                                echo getDropDownOption($txt, $art['art'], $selectedArt);
                            };
                            ?>
                        </select>
                        <div class="pt-3">
                            <button type="submit" class="btn btn-primary">
                                <?php echo $texts->getTxt('visa-data-knapp') ?>
                            </button>
                        </div>
                        <br/>
                </form>
                </div>
                <div class="pt-4">
                    <h3><?= $texts->getTxt('art-alla-ar-summary-header') ?></h3>
                    <?php writeSummarySection($pdo, $texts, $selectedArt, $nyaTidenTot, $pre80tot, $vinjettBildsHTML ) ?></>
                    <h3><?php echo $headerText ?></h3>
                    <?php writeOneSpeciesStandardYearsTable($tableDataAsArray, $summor, $texts, $selectedArt, $language); ?>
                    <br/>
                    <h2><?php echo $texts->getTxt('art-alla-ar-header-tidigare') ?></h2>
                    <p><?php echo $texts->getTxt('art-alla-ar-disclaimer-i') ?></p>
                    <p><?php echo $texts->getTxt('art-alla-ar-disclaimer-ii') ?></p>
                    <?php writeOneSpeciesOldYearsTable($v47to59, $v60to69, $v70to79, $texts); ?>
                    <br/><br/><br/><br/>
                </div>
            </div>
        </div>
        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

