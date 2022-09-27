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
$pageMetaData->setAdditionalJavaScriptFiles('korrelationer.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2022-09-01';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');

$texts = new StrackTexter($language);

$headerTexts = new StrackTexter($language);
$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$selectShowHow = getSessionThenRequestLastDefaultValue('showHow', 'om');
$_SESSION['show'] = $selectShowHow;

$sectionMenu = new StrackMenu($language);
$sectionMenu->setMiljoOversiktSelected();

$radioGroupName = "showHow";

?>
    <?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
    <div class="basePage">

        <?= getBannerHTML( '/strack/nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav">
                <div class="pt-2">
                    <h5><?= $texts->getTxt('mo-select-hdr') ?></h5>
                </div>
                <form name="visavad" method="GET">
                    <input type="hidden" id="lang" name="lang" value="<?= $language ?>">
                    <div class="mt-2 mb-3">
                        <?= getRadioButton("om", $radioGroupName, "om", $selectShowHow ) ?><label class="label-left-margin-5" for="om"><?= $texts->getTxt('mo-oversikt-show-om') ?></label> <br>
                        <?= getRadioButton("sy", $radioGroupName, "sy", $selectShowHow ) ?><label class="label-left-margin-5" for="sy"><?= $texts->getTxt('mo-oversikt-show-sys') ?></label><br>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $texts->getTxt('visa-data-knapp') ?></button>
                    <br/>
                </form>
                <hr>
                <div>
                    <p><?= $texts->getTxt('mo-oversikt-intro-ii') ?></p>
                    <?php writeSignificanceLegend($texts); ?>
                    <br/>
                    <br/>
                </div>
            </div>

            <div class="std">
                <h2> <?= $texts->getTxt('mo-oversikt-hdr') ?> </h2>
                <div class="d-flex">
                    <div clsdd="std">
                        <h3 class="green"><?= $texts->getTxt('mo-increasing') ?> </h3>
                        <?php writeStrackPopTrendsTableIncreasing($pdo, $language, $selectShowHow, $texts)  ?>
                    </div>
                    <div class="std">
                        <h3><?= $texts->getTxt('mo-stable') ?></h3>
                        <?php writeStrackPopTrendsTableNonSignificant($pdo, $language, $selectShowHow, $texts) ?>
                    </div>
                    <div class="std">
                        <h3 class="alarm"><?= $texts->getTxt('mo-decreasing') ?></h3>
                        <?php  writeStrackPopTrendsTableDecreasing($pdo, $language, $selectShowHow, $texts) ?>
                    </div>
                </div>
            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());