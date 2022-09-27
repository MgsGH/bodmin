<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'RastTexter.php';
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once '../aahelpers/common-functions.php';
include_once '../aahelpers/db.php';
include_once 'rast-functions.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$pdo = getDataPDO();

$language = getRequestValueWithDefault('lang', 'sv');


$texts = new RastTexter($language);

$startYear = 1993;
$defaultYearData = getMaxRastRakningsYear($pdo);
$defaultYear = $defaultYearData[0]["MAXYEAR"];
$maxYear = $defaultYearData[0]["MAXYEAR"];

$selectedYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$_SESSION['year'] = $selectedYear;
$dropDownYears = getDropDownYears($startYear);

$startWeek = 1;
$defaultWeekData = getMaxRastRakningsWeekForYear($pdo, $maxYear);
$defaultWeek = $defaultWeekData[0]["MAXWEEK"];
$maxWeek = $defaultWeekData[0]["MAXWEEK"];
$dropDownWeeks = getDropDownWeeks($startWeek);
$selectedVecka = getSessionThenRequestLastDefaultValue('vecka', $defaultWeek);

$rub_txt = $texts->getTxt('vecka-som-visas');
if (($selectedVecka == $maxWeek) && ($selectedYear == $maxYear)) {
    $rub_txt = $texts->getTxt('second-header');
}

$bladdraNextWeekLink = getNextWeekLink($maxWeek, $maxYear, $selectedVecka, $selectedYear, $texts, $language);
$bladdraNextYearLink = getNextYearLink($maxWeek, $maxYear, $selectedVecka, $selectedYear, $texts, $language);
$bladdraPreviousYearLink = getPreviousYearLink($selectedVecka, $selectedYear, $texts, $language);
$bladdraPreviousWeekLink = getPreviousWeekLink($selectedVecka, $selectedYear, $texts, $language);

$sub_rub_txt = $selectedYear . ' ' . $texts->getTxt('vecka') . ' ' . $selectedVecka;
$dataForTheWeeks = getDataRastRakningForSpecificWeek($pdo, $selectedYear, $selectedVecka, $language );

$pageMenu = New TopMenu($language);
$pageMenu->setRastFagelSelected();

?>

<?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
<div class="basePage">

    <?= getBannerHTML('rrvinjett.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

    <div class="d-flex mt-2">

        <div class="std rast-nav">
            <div class="pb-2">
                <h5 class="pt-3"><?= $texts->getTxt('select-header') ?></h5>
            </div>
            <form name="visavad" method="GET">
                <div class="row">
                    <div class="col-2 mgpt-2">
                        <label for="year"><?= $texts->getTxt('Ar:') ?></label>
                    </div>
                    <div class="col-9">
                        <select name="year" class="form-select">
                            <?php
                            foreach ($dropDownYears as $year){
                                $txt = $year;
                                echo getDropDownOption($txt, $year, $selectedYear);
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-2 mgpt-2">
                        <label for="vecka"><?= $texts->getTxt('Vecka:') ?></label>
                    </div>
                    <div class="col-9">
                        <select name="vecka" class="form-select">
                            <?php
                            foreach ($dropDownWeeks as $period){
                                $txt = $period;
                                echo getDropDownOption($txt, $period, $selectedVecka);
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="pt-3">
                    <button type="submit" class="btn btn-primary">
                        <?= $texts->getTxt('visa-knapp') ?>
                    </button>
                </div>

            </form>
            <hr>
            <h4><?= $texts->getTxt('lokaler-header') ?></h4>
            <p><?= $texts->getTxt('intro-ii') ?></p>
            <p><img alt="" src="/bilder/rast_s.jpg"></p>
            <br/>
            <br/>
            <br/>
            <br/>

        </div>


        <div class="container pt-1">

            <h2> <?= $rub_txt ?></h2>
            <h3> <?= $sub_rub_txt ?></h3>

            <p><?= $texts->getTxt('intro-i') ?></p>
            <div class="d-flex">
                <div class="Xmg-peanut">
                    <table class="table table-striped table-hover table-sm w-auto">
                    <thead class="thead-light">
                    <?= getRastTableHeader($texts) ?>
                    </thead>

                    <?php foreach ($dataForTheWeeks as $dataForTheWeek): ?>

                        <?php
                        $noCellClass = 'rr-sum no-f';
                        $artNamnCellClass = '<species-name';
                        if ($dataForTheWeek['SNR'] == 996){
                            $noCellClass = 'rr-sum no-f summa';
                            $artNamnClass = 'species-name summa';
                        }
                        ?>
                        <tr>
                            <td class="<?= $artNamnCellClass ?> "> <?= formatSpeciesName($dataForTheWeek['NAMN'], $language) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['KANAL']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['BLACK']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['ANGSN']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['NABMA']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['SLALH']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['REVLA']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['KNOSE']) ?></td>
                            <td class="<?= $noCellClass ?> "> <?= formatNo($dataForTheWeek['SUMMA']) ?></td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                    <div class="center">
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <?= getPreviousYearLink($selectedVecka, $selectedYear, $texts, $language) ?>
                            <?= getPreviousWeekLink($selectedVecka, $selectedYear, $texts, $language) ?>
                            <button type="button" class="btn btn-outline-primary btn-sm disabled">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                            <?= getNextWeekLink($maxWeek, $maxYear, $selectedVecka, $selectedYear, $texts, $language) ?>
                            <?= getNextYearLink($maxWeek, $maxYear, $selectedVecka, $selectedYear, $texts, $language) ?>

                        </div>
                    </div>
                </div>
                <div id="dummy-for-formatting">&nbsp;</div>
            </div>
            <br/>

        </div>

    </div>
    <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
