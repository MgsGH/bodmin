<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . "/strack/StrackHeaderTexter.php";
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/strack/StrackTexter.php";
include_once $path . "/strack/StrackMenu.php";
include_once $path . "/aahelpers/common-functions.php";
include_once $path . "/aahelpers/db.php";
include_once $path . "/strack/strack-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/strack/strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('dagssummor.js');
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2021-04-14';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');

$texts = new StrackTexter($language);


$date = '';
if (isset($_GET['date'])){
    $date = $_GET['date'];
}

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$sectionMenu = new StrackMenu($language);
$sectionMenu->setSenasteSelected();

?>
    <?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
    <div class="basePage">

        <?= getBannerHTML('../nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="date" class="mg-hide-element"><?= $date ?></span>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">
            <div class="mg-blue">
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std cal-nav pt-2">
                <h5><?= $texts->getTxt('dag-cal-title') ?></h5>
                <div>
                    <div id="datepicker" class="pb-3">
                    </div>
                </div>
                <p><?= $texts->getTxt('intro-i') ?></p>
                <p><?= $texts->getTxt('intro-ii') ?></p>
                <hr>
                <div class="text-center">
                    <br/>
                    <?= $texts->getTxt('info-antal-1') ?><br/>
                    <strong><span id="noOfBirds">127</span></strong><br/>
                    <?= $texts->getTxt('info-antal-2') ?><br/>
                    <br/>
                    <br/>
                </div>
            </div>

            <div class="std">
                <h2><?= $texts->getTxt('page-header') ?> </h2>
                <h3 id="strackDataHeader"></h3>
                <div id="strackDataSection">

                </div>

            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());