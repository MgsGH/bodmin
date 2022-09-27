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
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('art-ar-sasong.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestLanguage();


$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setArtArSasongSelected();

$arterData = getRingmarktaArter($pdo, $language);
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
$_SESSION['art'] = $selectedArt;

$startYear = 1947;
$defaultYear = getCurrentYear()-1;
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectYear;
$dropDownRingingYears = getDropDownYears($startYear);

$selectSeason = getSessionThenRequestLastDefaultValue('sasong', 'FA');
$_SESSION['sasong'] = $selectSeason;

$ar = getCurrentYear() - 1;
$headerText = $texts->getTxt('aas-header') ;


$ringingMonths = getRingingMonths($pdo, $selectYear, $selectSeason, $selectedArt);
$ringingDailyTotals = getRingingDailyTotals($pdo, $selectYear, $selectSeason, $selectedArt);

$artNamnData = getArtNamnAlfaKod($pdo, $selectedArt, $language);
$artNamn = $artNamnData[0]["NAME"];

$lokalData = getLokalNamn($pdo, $selectSeason, $language);
$lokalNamn = $lokalData[0]["TEXT"];

?>
    <?= getHtmlHead('', $pageMetaData, $language) ?>
    <div class="basePage">

        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
        <span id="sasong" class="mg-hide-element"><?= $selectSeason ?></span>
        <div class="d-flex mt-2">
            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="container-fluid">

                <h2><?= $texts->getTxt('aas-main-header') ?></h2>
                <div class="control-panel pt-3 px-3 py-0">
                    <form name="visavad" method="GET" class="row gx-3 gy-2 align-items-center">
                        <input type="hidden" id="lang" name="lang" value="<?php echo $language ?>">
                        <div class="col-sm-6">
                            <label for="art" class="Xvisually-hidden"><?= $texts->getTxt('aas-valj-art') ?></label>
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
                            <label for="year" class="Xvisually-hidden"><?= $texts->getTxt('aas-valj-ar') ?></label>
                            <select name="year" id="year" class="form-select js-example-basic-single">
                                <?php
                                foreach ($dropDownRingingYears as $year){
                                    $txt = $year;
                                    echo getDropDownOption($txt, $year, $selectYear);
                                }
                                ?>
                            </select>
                        </div>

                        <div class="btn-group" role="group" aria-label="Select season" id="sasonGroup">

                            <input type="radio" class="btn-check" name="sasong" id="btnradio-FA" value="FA" autocomplete="off">
                            <label id="lbl-FA" class="btn btn-outline-primary" for="btnradio-FA"><?= $texts->getTxt('FA') ?></label>

                            <input type="radio" class="btn-check" name="sasong" id="btnradio-FB" value="FB" autocomplete="off">
                            <label id="lbl-FB" class="btn btn-outline-primary" for="btnradio-FB"><?= $texts->getTxt('FB') ?></label>

                            <input type="radio" class="btn-check" name="sasong" id="btnradio-FC" value="FC" autocomplete="off">
                            <label id="lbl-FC" class="btn btn-outline-primary" for="btnradio-FC"><?= $texts->getTxt('FC') ?></label>

                            <input type="radio" class="btn-check" name="sasong" id="btnradio-OV" value="ÖV" autocomplete="off">
                            <label id="lbl-OV" class="btn btn-outline-primary" for="btnradio-OV"><?= $texts->getTxt('ÖV') ?></label>

                            <input type="radio" class="btn-check" name="sasong" id="btnradio-PU" value="PU" autocomplete="off">
                            <label id="lbl-PU" class="btn btn-outline-primary" for="btnradio-PU"><?= $texts->getTxt('PU') ?></label>

                        </div>
                        <br/>
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

                <h3><?= $artNamn . ', ' . $_SESSION['last-selected'] . ', ' . $lokalNamn ?></h3>

                <p><?= $texts->getTxt('aas-intro-i') . ' ' . mb_strtolower($artNamn) . ' ' . $texts->getTxt('aas-intro-ii') ?></p>
                <div class="d-flex">
                <?php
                foreach ($ringingMonths as $ringingManad){

                    echo ('<div class="dagsum-table">');

                    $thisMonth = $ringingManad['MONTH'];
                    if (strlen($thisMonth) < 2) {
                        $thisMonth = '0' . $thisMonth;
                    }

                    $startDate = $selectYear . '-' . $thisMonth . '-01' ;

                    writeDaysInMonthAsTable($startDate, $texts, $ringingDailyTotals);
                    echo ('</div>');
                }

                ?>
                </div>

                <br/>
                <br/>
            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

