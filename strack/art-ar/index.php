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
include_once $path . "/strack/StrackTexter.php";
include_once $path . "/strack/StrackMenu.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/strack/strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('art-ar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2022-09-01';
$updatedBy = ' ';

$pdo = getDataPDO();
$languageISO2 = getRequestLanguage();

$texts = new StrackTexter($languageISO2);

$pageMenu = New TopMenu($languageISO2);
$pageMenu->setStrackSelected();


$sectionMenu = new StrackMenu($languageISO2);
$sectionMenu->setArArtSelected();

$arterData = getStracktaArter($pdo, $languageISO2);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

$startYear = 1973;
$defaultYear = getCurrentYear();
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectYear;
$dropDownRingingYears = getDropDownYears($startYear);


$ar = getCurrentYear() - 1;
$headerText = $texts->getTxt('aas-header') ;

$strackMonths = getStrackMonths($pdo, $selectYear, $selectedArt);
$strackDailyTotals = getNabbenDailyTotals($pdo, $selectYear, $selectedArt);



$artNamnData = getArtNamnAlfaKod($pdo, $selectedArt, $languageISO2);
$artNamn = $artNamnData[0]["NAME"];


?>
    <?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $languageISO2) ?>
    <div class="basePage">

        <?= getBannerHTML('../nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($languageISO2) ?></span>

        <div class="d-flex mt-2">
            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="container-fluid">

                <h2><?= $texts->getTxt('aa-main-header') ?></h2>

                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET" class="row gx-3 gy-2 align-items-center">
                        <input type="hidden" id="lang" name="lang" value="<?= $languageISO2 ?>">
                        <div class="col-sm-6">
                            <label for="art"><?= $texts->getTxt('valj-art') ?></label>
                            <select name="art" id="art" class="form-select js-example-basic-single">
                                <?php
                                foreach ($arterData as $art){
                                    $txt = $art['NAMN'];
                                    echo getDropDownOption($txt, $art['art'], $selectedArt);
                                };
                                ?>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="year"><?= $texts->getTxt('ar-valj-ar') ?></label>
                            <select name="year" id="year" class="form-select js-example-basic-single">
                                <?php
                                foreach ($dropDownRingingYears as $year){
                                    $txt = $year;
                                    echo getDropDownOption($txt, $year, $selectYear);
                                }
                                ?>
                            </select>
                        </div>

                        <br/>
                        <div class="pb-2 pl-2">
                            <button type="submit" class="btn btn-primary">
                                <?= $texts->getTxt('visa-data-knapp') ?>
                            </button>
                        </div>
                        <br/>

                    </form>
                </div>



            <br/>

            <h3><?= $artNamn . ', ' . $_SESSION['last-selected']  ?></h3>

            <p><?= $texts->getTxt('aas-intro-i') . ' ' . mb_strtolower($artNamn) . ' ' . $texts->getTxt('aas-intro-ii') ?></p>
            <div class="d-flex">
                <?php

                foreach ($strackMonths as $strackManad){

                    echo ('<div class="dagsum-table">');

                    $thisMonth = $strackManad['MONTH'];
                    if (strlen($thisMonth) < 2) {
                        $thisMonth = '0' . $thisMonth;
                    }

                    $startDate = $selectYear . '-' . $thisMonth . '-01' ;

                    writeMonthTable($startDate, $texts, $strackDailyTotals, $languageISO2);
                    echo ('</div>');
                }

                ?>
            </div>
            <div/>
            <br/>
            <br/>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

