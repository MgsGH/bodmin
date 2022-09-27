<?php
include_once "LokalerMenu.php";
include_once "LokalerTexter.php";
include_once "LokalerHeaderTexter.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('lokalerHeader.js?dummy=' . $t);
$pageMetaData->setAdditionalJavaScriptFiles('loadHeaderTexts.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new LokalerTexter($language);
$headerTexts = new LokalerHeaderTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setLokalerSelected();

$sectionMenu = new LokalerMenu($language);
$sectionMenu->setFotevikenOmradetSelected();
echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
?>

    <div class="basePage">
        <?= getBannerHTML('fbowide100h.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">

                <h2><?= $texts->getTxt('f-och-f-header') ?></h2>

                <p><?= $texts->getTxt('f-och-f-1') ?></p>
                <p><?= $texts->getTxt('f-och-f-2') ?></p>
                <p><?= $texts->getTxt('f-och-f-3') ?></p>

                <div class="d-flex">
                    <div class="w-75">
                        <h3><?= $texts->getTxt('vag-beskrivningar') ?></h3>
                        <h3><?= $texts->getTxt('f-och-f-5') ?></h3>
                        <p><?= $texts->getTxt('f-och-f-6') ?></p>
                        <h3><?= $texts->getTxt('f-och-f-7') ?></h3>
                        <p><?= $texts->getTxt('f-och-f-8') ?></p>
                        <p><?= $texts->getTxt('f-och-f-9') ?></p>
                        <p><?= $texts->getTxt('f-och-f-10') ?></p>
                        <h3><?= $texts->getTxt('f-och-f-11') ?></h3>
                        <p><?= $texts->getTxt('f-och-f-12') ?></p>
                        <p><?= $texts->getTxt('f-och-f-13') ?></p>
                        <p><?= $texts->getTxt('f-och-f-4') ?></p>

                        <h3><?= $texts->getTxt('f-och-f-14') ?></h3>
                        <p><?= $texts->getTxt('f-och-f-15') ?></p>
                        <h3><?= $texts->getTxt('f-och-f-16') ?></h3>

                        <p><?= $texts->getTxt('f-och-f-17') ?></p>
                        <p><?= $texts->getTxt('f-och-f-18') ?></p>
                        <h3><?= $texts->getTxt('f-och-f-19') ?></h3>
                        <p><?= $texts->getTxt('f-och-f-20') ?></p>
                        <p><?= $texts->getTxt('f-och-f-21') ?></p>
                        <p><?= $texts->getTxt('f-och-f-22') ?></p>
                    </div>


                    <div class="std mr-3">
                        <div>
                            <br>
                            <img src="/bilder/fotevik_sve.jpg" class="shadow" alt="Karta över foteviken">
                            <br>
                            <br>
                            <div class="std">
                                <p><?= $texts->getTxt('f-och-f-24') ?></p>
                            </div>
                            <img src="/bilder/angarna_sve.jpg" class="shadow" alt="Karta Gessie ängar och Eskilstorps ängar">
                            <br>
                            <br>

                            <img src="/bilder/fredshog_sve.jpg" class="shadow" alt="Karta Fredshög">
                            <br>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <p class="info"></p>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());