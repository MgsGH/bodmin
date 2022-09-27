<?php
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('alla-arter-alla-std-ar.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2021-11-27';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new RingTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setMiljoOvervakningSelected();

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
?>

    <div class="basePage">

        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
        <div class="d-flex mgFull Xmg-yellow mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="container mgFull">
                <h2><?= $texts->getTxt('mo-pop-intro-sida-hdr') ?></h2>
                <p>
                    <?= $texts->getTxt('mo-pop-intro-sida-para-1') ?>
                </p>
                <p>
                    <?= $texts->getTxt('mo-pop-intro-sida-para-2') ?>
                </p>
                <p>
                    <?= $texts->getTxt('mo-pop-intro-sida-para-3') ?>
                </p>
                <p> <?= $texts->getTxt('mo-pop-intro-sida-para-4') ?></p>
                <p>
                <ul>
                    <li><?= $texts->getTxt('mo-pop-intro-sida-ul-1') ?></li>
                    <li><?= $texts->getTxt('mo-pop-intro-sida-ul-2') ?></li>
                    <li><?= $texts->getTxt('mo-pop-intro-sida-ul-3') ?></li>
                </ul>
                </p>
                <p><?= $texts->getTxt('mo-pop-intro-sida-para-5') ?> </p>

            </div>

            <div class="std">
                <br>
            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());