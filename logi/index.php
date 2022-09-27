<?php
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once '../aahelpers/common-functions.php';

include_once 'LogiTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);
$pageMetaData->setLeafLet(true);

//footer info
$introText = ' ';
$updatedDate = '2021-11-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$pageMenu = New TopMenu($language);
$texts = new LogiTexter($language);

$pageMenu->setLogiSelected();
echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

?>

    <div class="basePage">

        <?= getBannerHTML('logivinjett.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>


        <div class="d-flex">

            <div class="std">

                <p class="mt-2"><?= $texts->getTxt('info') ?></p>
                <p>
                    <?= $texts->getTxt('booking-intro') ?>
                </p>
                <ul>
                    <li><?= $texts->getTxt('booking-bullet-1') ?></li>
                    <li><?= $texts->getTxt('booking-bullet-2') ?></li>
                    <li><?= $texts->getTxt('booking-bullet-3') ?></li>
                </ul>
                <p><?= $texts->getTxt('booking-end') ?></p>


                <p><?= $texts->getTxt('incheckning') ?></p>
                <p><?= $texts->getTxt('lakan') ?></p>
                <p><?= $texts->getTxt('adress') ?></p>
                <p><?= $texts->getTxt('avgift') ?></p>
                <p><?= $texts->getTxt('avbokning') ?></p>
                <p class="center"><?= $texts->getTxt('valkommen') ?></p>
                <br/>
                <br/>
                <br/>
                <p><?= $texts->getTxt('alternativ') ?> <a href='http://www.vellinge.se/uppleva-gora/turism/boende/'>http://www.vellinge.se/uppleva-gora/turism/boende</a></p>
            </div>
            <div class="std mr-1 mt-2">

                <div id="dataMap">
                    <div id="rmap" style="height: 600px"></div>
                </div>
                <p class="mt-2"><b><?= $texts->getTxt('vagbeskrivning-header') ?></b></p>
                <p><?= $texts->getTxt('vagbeskrivning-0') ?></p>
                <p><?= $texts->getTxt('vagbeskrivning-1') ?></p>
                <p><?= $texts->getTxt('vagbeskrivning-2') ?></p>
            </div>
        </div>
        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

