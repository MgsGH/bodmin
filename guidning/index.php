<?php


include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once '../aahelpers/common-functions.php';
include_once "SectionMenu.php";

include_once 'GuidningsTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');

$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2021-09-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$pageMenu = New TopMenu($language);

$texts = new GuidningsTexter($language);
$pageMenu->setGuidningSelected();

$sectionMenu = new SectionMenu($language);
$sectionMenu->setContentSelected();

?>
<?= getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
<div class="basePage">

    <?= getBannerHTML('guidevinjett.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
    <div class="d-flex mt-2">
        <div>
        <?= $sectionMenu->getHTML(); ?>
        </div>
        <div class="d-flex container-fluid pt-2">
            <div class="col-6">
                <h2><?= $texts->getTxt('header') ?></h2>
                <p><?= $texts->getTxt('intro-i') ?></p>
                <p><?= $texts->getTxt('intro-ii') ?></p>

                <h3><?= $texts->getTxt('innehall-header') ?></h3>
                <p><?= $texts->getTxt('innehall') ?></p>
                <p><?= $texts->getTxt('orientering') ?></p>
                <p><?= $texts->getTxt('flyttning') ?></p>
                <p><?= $texts->getTxt('stationen') ?></p>
                <p><?= $texts->getTxt('markning') ?></p>

                <h3><?= $texts->getTxt('seasons') ?></h3>
                <p><?= $texts->getTxt('intro') ?></p>

                <h3><?= $texts->getTxt('boka-header') ?></h3>
                <p><?= $texts->getTxt('boka-intro') ?> <a href="mailto:falsterbo@skof.se"><b> <?= $texts->getTxt('boka-epost') ?></b></a></p>
                <p><?= $texts->getTxt('kalender') ?></p>
                <h3><?= $texts->getTxt('pris-header') ?></h3>
                <p><?= $texts->getTxt('pris-1') ?></p>
                <p><?= $texts->getTxt('pris-2') ?></p>

            </div>

            <div class="col-6">
                <div class="d-flex justify-content-center">
                    <img src="/bilder/hawkeye_kp.jpg" class="shadow" alt="Sparvhök i handen" title="Sparvhök, Accipiter nisus, (K. Persson©)"><br>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <img src="/bilder/guidning_1w.jpg" class="shadow" alt="Karin guidar" title="Karin guidar">
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <img src="/bilder/mesar.jpg" class="shadow" alt="Mesar i handen" title="Stjärtmesar (Foto: Björn Malmhagen)">
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center pt-3">
        <div class="row">
            <p>
                <?= $texts->getTxt('support') ?>
            </p>
        </div>
    </div>
    <div class="d-flex justify-content-center pt-3">
        <div class="d-flex justify-content-center">
            <img src="/bilder/sfrlogoh48px.gif" class="img-responsive" width="83" height="48" alt="logga"><br>
        </div>
        <div class="d-flex justify-content-center">
            &nbsp;&nbsp;
        </div>
        <div class="d-flex justify-content-center">
            <img src="/bilder/vellinge.gif" class="img-responsive" width="77" height="48" alt="logga">
        </div>
    </div>
    <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>
</div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());