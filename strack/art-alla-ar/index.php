<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/common-functions.php";
include_once $path . "/aahelpers/db.php";

include_once $path . "/strack/strack-functions.php";
include_once $path . "/strack/StrackHeaderTexter.php";
include_once $path . "/strack/StrackTexter.php";
include_once $path . "/strack/StrackMenu.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/strack/strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('art-alla-ar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2022-09-01';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');

$texts = new StrackTexter($language);
$headerTexts = new StrackTexter($language);

$arterData = getStracktaArter($pdo, $language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

$photoData = getVinjettBildsFotograf($pdo, $selectedArt);
$photographer = $photoData[0]['FOTO'];
$vinjettBildsHTML = getVinjettBildHTMLSection($pdo, $selectedArt, $photographer);

$artNamn = getSpeciesNames($pdo, $selectedArt, $language);
$commonSpeciesName = $artNamn[0]['NAMN'];
$scientificSpeciesName = $artNamn[0]['LATNAMN'];

$data = getNabbenArsSumma($pdo, $selectedArt, $language);

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$sectionMenu = new StrackMenu($language);
$sectionMenu->setArtAllaArSelected();

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
?>

    <div class="basePage">

        <?= getBannerHTML('../nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav">
                <div class="pt-2">
                    <?= $texts->getTxt('intro-i') ?>
                </div>
            </div>

            <div class="std">
                <div>
                    <h2><?= $texts->getTxt('alla-ar-header') ?></h2>
                </div>
                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET">
                        <input type="hidden" id="lang" name="lang" value="<?= $language ?>">
                        <div>
                            <span><?= $texts->getTxt('tio-i-topp-valj-art') ?></span>
                            <select name="art" class="form-select js-example-basic-single">
                                <?php
                                foreach ($arterData as $art){
                                    $txt = $art['NAMN'];
                                    echo getDropDownOption($txt, $art['art'], $selectedArt);
                                };
                                ?>
                            </select>
                        </div>

                        <div class="pt-3">
                            <button class="btn btn-primary" type="submit">
                                <?= $texts->getTxt('visa-data-knapp') ?>
                            </button>
                            <br/><br/>
                        </div>
                    </form>
                </div>

                <div class="pt-2">
                    <?php writeStrackSummarySection($pdo, $texts, $selectedArt, $data, $vinjettBildsHTML) ?>
                    <?php writeYearsTableForSpecies($texts, $data) ?>
                </div>
            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());