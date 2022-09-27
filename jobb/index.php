<?php

include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once '../aahelpers/common-functions.php';
include_once 'JobbTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('bilder.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);

//footer info
$introText = ' ';
$updatedDate = '2021-12-21';
$updatedBy = ' ';

$language = getRequestLanguage();
$pageMenu = New TopMenu($language);
$pageMenu->setJobbSelected();

$texts = new JobbTexter($language);
echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);


?>
<div class="basePage">

    <?= getBannerHTML('staff.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

    <div class="d-flex">
        <div class="std">
            <p><img src="/bilder/mihac_bm.jpg" width="300" height="400" class="shadow" alt="Mindre hackspett i handen" title="Mindre hackspett"></p>
            <p><img src="/bilder/staff-1.jpg" class="shadow" alt="Mindre hackspett i handen" title="Mindre hackspett"></p>
            <p><img src="/bilder/smsum_tim_w.jpg" width="300" height="200" class="shadow" alt="Småfläckig sumphöna i handen" title="Småfläckig sumphöna"></p>
            <p><img src="/bilder/lafal_w.jpg" width="300" height="425" class="shadow" alt="Lärkfalk i handen" title="Lärkfalk"></p>
        </div>

        <div class="std">

            <h2><?= $texts->getTxt('intro') ?></h2>
            <h3><?= $texts->getTxt('assistenter-header') ?></h3>
            <?= $texts->getTxt('bullet-1') ?><br>
            <?= $texts->getTxt('bullet-2') ?><br>

            <p><b><?= $texts->getTxt('arb-upg-header') ?></b><br/>
            <?= $texts->getTxt('ass-arb-upg-1') ?></p>
            <p><?= $texts->getTxt('ass-arb-upg-2') ?></p>

            <p><b><?= $texts->getTxt('forkunskaper-header') ?></b><br/>
            <?= $texts->getTxt('ass-forkunskaper-1') ?></p>

            <p><b><?= $texts->getTxt('ersattning-header') ?></b><br/><?= $texts->getTxt('ass-ersattning-1') ?></p>

            <h3><?= $texts->getTxt('guide-header') ?></h3>
            <p><?= $texts->getTxt('guide-intro') ?></p>
            <p><b><?= $texts->getTxt('arb-upg-header') ?></b><br/>
            <?= $texts->getTxt('guide-arbetsuppgifter-1') ?></p>
            <p><?= $texts->getTxt('guide-arbetsuppgifter-2') ?></p>
            <p><b><?= $texts->getTxt('forkunskaper-header') ?></b><br/>
            <?= $texts->getTxt('guide-forkunskaper-1') ?></p>
            <p><?= $texts->getTxt('guide-forkunskaper-2') ?></p>
            <p><b><?= $texts->getTxt('ersattning-header') ?></b><br/>
            <?= $texts->getTxt('guide-ersattning') ?></p>

            <h3><?= $texts->getTxt('intresserad-header') ?></h3>
            <p><?= $texts->getTxt('intresserad-intro') ?>
                <ul>
                <li><?= $texts->getTxt('intresserad-1') ?></li>
                <li><?= $texts->getTxt('intresserad-2') ?></li>
                <li><?= $texts->getTxt('intresserad-3') ?></li>
            </ul>

            <h3><?= $texts->getTxt('kontakt-header') ?></h3>
            <p><?= $texts->getTxt('kontakt-intro') ?>
            <ul>
                <li><?= $texts->getTxt('kontakt-1') ?></li>
                <li><?= $texts->getTxt('kontakt-2') ?></li>
                <li><?= $texts->getTxt('kontakt-3') ?></li>
            </ul>

        </div>
        <div class="std">
            <p><img src="/bilder/blmes_sm_w.jpg" width="300" height="369" class="shadow" title="Blåmes" alt="Blåmes"></p>
            <p><img src="/bilder/svflu_se_w.jpg" width="300" height="205" class="shadow" title="Svartvit flusnappare" alt="Svartvit flusnappare"></p>
            <p><img src="/bilder/guidning_1w.jpg" width="300" height="216" class="shadow" title="Karin i sitt esse!" alt="Karin guidar"></p>
            <p><img src="/bilder/svbus_se_w.jpg" width="300" height="233" class="shadow" title="Svarhakad buskskvätta" alt="Svarhakad buskskvätta"></p>
            <p><img src="/bilder/staff-2.jpg" class="shadow" title="Svarhakad buskskvätta" alt="Svarhakad buskskvätta"></p>
        </div>
    </div>

    <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());