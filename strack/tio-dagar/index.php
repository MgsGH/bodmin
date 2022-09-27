<?php
session_start();

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
$pageMetaData->setAdditionalJavaScriptFiles('tio-dagar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');


$texts = new StrackTexter($language);
$headerTexts = new StrackTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$sectionMenu = new StrackMenu($language);
$sectionMenu->setTioDagarSelected();

$startYear = 1973;
$defaultYear = getCurrentYear()-1;
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectYear;
$dropDownYears = getDropDownYears($startYear);

$defaultPeriod = 1; // aug-1
$dropDownPerioder = getNabbenTioDagasPerioder($pdo, $language);
$selectPeriod = getSessionThenRequestLastDefaultValue('period', $defaultPeriod);
$periodInfo = getNabbenTioDagasPeriod($pdo, $selectPeriod);
$periodData = getNabbenTioPeriod($pdo, $selectYear, $language, $periodInfo);


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

            <div class="std cal-nav">
                <form name="visavad" method="GET">
                    <input type="hidden" id="lang" name="lang" value="<?= $language ?>">
                    <div class="pt-2">
                        <h5><?= $texts->getTxt('tio-dagar-ar') ?></h5>
                    </div>

                    <select name="year" class="form-select">
                        <?php
                        foreach ($dropDownYears as $year){
                            $txt = $year;
                            echo getDropDownOption($txt, $year, $selectYear);
                        };
                        ?>
                    </select>
                    <div class="pt-2">
                        <select name="period" class="form-select">
                            <?php
                            foreach ($dropDownPerioder as $period){
                                $txt = $period['PERIOD'];
                                echo getDropDownOption($period['PERIOD'], $period['ID'], $selectPeriod);
                            };
                            ?>
                        </select>
                    </div>
                    <br/>
                    <div>
                        <button type="submit" class="btn btn-primary"><?= $texts->getTxt('tio-dagar-knapp') ?></button>
                    </div>

                </form>

                <div class="pt-2">
                    <p><?= $texts->getTxt('intro-i') ?></p>
                    <p><?= $texts->getTxt('intro-ii') ?></p>
                </div>
            </div>

            <div class="std">
                <h2><?= $texts->getTxt('header-tio-dagar') ?> </h2>
                <?php writeNabbenTioDagarTable($texts, $periodInfo, $periodData) ?>
            </div>

        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());