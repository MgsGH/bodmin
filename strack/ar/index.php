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
$pageMetaData->setAdditionalJavaScriptFiles('ar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

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
$sectionMenu->setArSelected();

$startYear = 1973;
$defaultYear = getCurrentYear()-1;
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectYear;
$dropDownYears = getDropDownYears($startYear);

$data = getNabbenYearData($pdo, $selectYear, $language );
$averagesPerYearData = getNabbenArligaMedeltal($pdo);

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

?>

    <div class="basePage">

        <?php echo getBannerHTML('../nabben-small.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">
            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav">
                <form name="visavad" method="GET">
                    <input type="hidden" id="lang" name="lang" value="<?= $language ?>">
                    <div class="pt-2">
                        <h5><?php echo $texts->getTxt('ar-valj-ar') ?></h5>
                    </div>

                    <select name="year" class="form-select js-example-basic-single">
                        <?php
                        foreach ($dropDownYears as $year){
                            $txt = $year;
                            echo getDropDownOption($txt, $year, $selectYear);
                        };
                        ?>
                    </select>

                    <div class="pt-3 pb-4">
                    <button type="submit" class="btn btn-primary"><?php echo $texts->getTxt('ar-knapp') ?></button>
                    </div>
                </form>

                <div>
                    <p><?php echo $texts->getTxt('intro-i') ?></p>
                    <p><?php echo $texts->getTxt('ar-intro-text-2') ?></p>
                    <p><?php echo $texts->getTxt('ar-intro-text-3') ?></p>
                </div>
            </div>

            <div class="std">
                <h2><?php echo $texts->getTxt('header-ar') . ', ' . $selectYear ?> </h2>
                <br/>
                <?php writeStrackYearTable($texts, $data) ?>

            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());