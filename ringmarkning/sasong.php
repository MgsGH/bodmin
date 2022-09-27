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
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('sasong.js');

//footer info
$introText = ' ';
$updatedDate = '2021-07-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestLanguage();


$texts = new RingTexter($language);


$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$startYear = 1980;
$defaultYear = getCurrentYear()-1;
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectYear;
$dropDownYears = getDropDownYears($startYear);

$selectSeason = getSessionThenRequestLastDefaultValue('sasong', 'FA');
$_SESSION['sason'] = $selectSeason;

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setSasongSelected();
$radioGroupName = "sason";

?>

    <?php echo getHtmlHead('', $pageMetaData, $language) ?>
    <div class="basePage">
        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
        <span id="sasong" class="mg-hide-element"><?= $selectSeason ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav">
                <div class="pt-2">
                    <h5><?php echo $texts->getTxt('sasong-valj-header') ?></h5>
                </div>

                <form name="visavad" method="GET">
                    <input type="hidden" id="lang" name="lang" value="<?php echo $language ?>">
                    <br/>
                    <strong><?php echo $texts->getTxt('select-year-text') ?></strong>
                    <br/>
                    <select name="year" class="form-select">
                        <?php
                        foreach ($dropDownYears as $year){
                            $txt = $year;
                            echo getDropDownOption($txt, $year, $selectYear);
                        };
                        ?>
                    </select>
                    <div class="pt-2">
                        <strong><?php echo $texts->getTxt('select-season-text') ?></strong>
                    </div>
                    <div class="btn-group-vertical" role="group" aria-label="Select season">
                        <input type="radio" class="btn-check" name="sasong" id="btnradio-FA" value="FA" autocomplete="off">
                        <label id="lbl-FA" class="btn btn-outline-primary" for="btnradio-FA"><?php echo $texts->getTxt('FA') ?></label>

                        <input type="radio" class="btn-check" name="sasong" id="btnradio-FB" value="FB" autocomplete="off">
                        <label id="lbl-FB" class="btn btn-outline-primary" for="btnradio-FB"><?php echo $texts->getTxt('FB') ?></label>

                        <input type="radio" class="btn-check" name="sasong" id="btnradio-FC" value="FC" autocomplete="off">
                        <label id="lbl-FC" class="btn btn-outline-primary" for="btnradio-FC"><?php echo $texts->getTxt('FC') ?></label>

                        <input type="radio" class="btn-check" name="sasong" id="btnradio-OV" value="OV" autocomplete="off">
                        <label id="lbl-OV" class="btn btn-outline-primary" for="btnradio-OV"><?php echo $texts->getTxt('ÖV') ?></label>

                        <input type="radio" class="btn-check" name="sasong" id="btnradio-PU" value="PU" autocomplete="off">
                        <label id="lbl-PU" class="btn btn-outline-primary" for="btnradio-PU"><?php echo $texts->getTxt('PU') ?></label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $texts->getTxt('visa-knapp') ?>
                        </button>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                </form>
            </div>

            <div class="std">
                <h1> <?php echo $texts->getTxt('sasong-header') ?> </h1>
                <h2><?php echo $selectYear ?> - <?php echo $texts->getTxt($selectSeason) ?></h2>

                <?php writeSasongTable($pdo, $selectSeason, $language, $texts, $selectYear) ?>
            </div>
        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
