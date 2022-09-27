<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/db.php';
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/ringmarkning/RingTexter.php";
include_once $path . "/ringmarkning/RingmarkningMenu.php";
include_once $path . "/aahelpers/common-functions.php";
include_once $path . "/ringmarkning/ringmarkning-functions.php";

// decides linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/ringmarkning/ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('dagssummor.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootStrapFyra(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2022-03-17';
$updatedBy = ' ';

$pdo = getDataPDO();
$language = getRequestValueWithDefault('lang', 'sv');
$texts = new RingTexter($language);

$date = '';
if (isset($_GET['date'])){
    $date = $_GET['date'];
}

$headerTexts = new RingTexter($language);
$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setSenasteSelected();
echo getHtmlHead('', $pageMetaData, $language);
?>

    <div class="basePage">
        <?= getBannerHTML('../ringmvinjett.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="date" class="mg-hide-element"><?= $date ?></span>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <?= $sectionMenu->getHTML(); ?>

            <div class="std cal-nav pt-2">
                <div>
                    <h5><?= $texts->getTxt('dag-cal-title') ?></h5>
                </div>
                <div>
                    <div id="datepicker" class="pb-3">
                    </div>
                </div>
            </div>

            <div class="std">
                <h2><?= $texts->getTxt('dags-summa-rubrik') ?> </h2>
                <h3 id="ringingDateHeader"></h3>
                <div id="ringDataSection">

                </div>

            </div>
        </div>
        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());