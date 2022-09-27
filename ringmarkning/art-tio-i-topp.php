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
$pageMetaData->setAdditionalJavaScriptFiles('art-tio-i-topp.js');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
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

$arterData = getRingmarktaArter($pdo,$language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$photoData = getVinjettBildsFotograf($pdo, $selectedArt);
$photographer = $photoData[0]['FOTO'];
$vinjettBildsHTML = getVinjettBildHTMLSection($pdo, $selectedArt, $photographer);

$_SESSION['art'] = $selectedArt;

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setTioIToppSelected();
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
                <p class="pt-2"><?php echo $texts->getTxt('art-tio-i-topp-intro-text-1') ?></p>
            </div>


            <div class="std">
                <h2><?= $texts->getTxt('art-tio-i-topp-header') ?></h2>
                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET">
                        <input type="hidden" id="lang" name="lang" value="<?php echo $language ?>">
                        <div>
                        <label for="taxon"><?php echo $texts->getTxt('art-tio-i-topp-art') ?></label>
                        <select name="art" class="js-example-basic-single" id="taxon">
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
                                <?php echo $texts->getTxt('art-tio-i-topp-visa-knapp') ?>
                            </button>
                            <br/><br/>
                        </div>
                     </form>
                </div>
                <div class="pt-4">

                    <h3><?php echo $texts->getTxt('art-tio-i-topp-dagsum') ?></h3>
                    <?php writeDagsTabell($pdo, $language, $texts, $selectedArt); ?>
                    <br/>

                    <h3><?php echo $texts->getTxt('art-tio-i-topp-sassum') ?></h3>
                    <?php writeSeasonsTabell($pdo, $texts, $selectedArt); ?>
                    <br/>

                    <h3><?php echo $texts->getTxt('art-tio-i-topp-arsum') ?></h3>
                    <?php writeYearSection($pdo, $texts, $selectedArt, $vinjettBildsHTML) ?></>
                    <br/>
                </div>
            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

