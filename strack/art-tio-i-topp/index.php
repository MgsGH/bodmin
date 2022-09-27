<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . "/strack/StrackHeaderTexter.php";
include_once $path . "/strack/StrackTexter.php";
include_once $path . "/strack/StrackMenu.php";
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/common-functions.php";
include_once $path . "/aahelpers/db.php";
include_once $path . "/strack/strack-functions.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/strack/strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('art-tio-i-topp.js');
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

$arterData = getStracktaArter($pdo, $language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

$texts = new StrackTexter($language);
$headerTexts = new StrackTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$dagSummor = getMax10DagSumStrack($pdo, $selectedArt);
$arSummor = getMax10ArSumStrack($pdo, $selectedArt);
$artNamn = getSpeciesNames($pdo, $selectedArt, $language);

$commonSpeciesName = $artNamn[0]['NAMN'];
$ScientificSpeciesName = $artNamn[0]['LATNAMN'];

$sectionMenu = new StrackMenu($language);
$sectionMenu->setTioIToppSelected();

?>
    <?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
    <div class="basePage">

        <?= getBannerHTML('../nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav-wide">

                <div class="pt-2">
                    <p><?= $texts->getTxt('intro-i') ?></p>
                    <p><?= $texts->getTxt('intro-ii') ?></p>
                </div>
            </div>

            <div class="std">
                <div>
                    <h3><?= $texts->getTxt('tio-i-topp-header') ?></h3>
                </div>
                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET">
                        <input type="hidden" id="lang" name="lang" value="<?= $language ?>">
                        <div>
                            <span><?= $texts->getTxt('tio-i-topp-valj-art') ?></span>
                            <select name="art" id="art" class="form-select js-example-basic-single">
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
                    <?php writeDataTables($texts, $dagSummor, $arSummor) ?>
                </div>

            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());