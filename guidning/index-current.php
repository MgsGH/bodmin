<?php


include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once '../aahelpers/common-functions.php';

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

?>
<?php echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
<div class="basePage">

    <?= getBannerHTML('guidevinjett.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

    <div class="container mt-3">
        <div class="row">
        <div class="col-4">
            <h2><?php echo $texts->getTxt('seasons') ?></h2>
            <p><?php echo $texts->getTxt('intro') ?></p>
            <h2><?php echo $texts->getTxt('innehall-header') ?></h2>
            <p><?php echo $texts->getTxt('innehall') ?></p>
            <p><?php echo $texts->getTxt('orientering') ?></p>
            <p><?php echo $texts->getTxt('flyttning') ?></p>
            <p><?php echo $texts->getTxt('stationen') ?></p>
            <p><?php echo $texts->getTxt('markning') ?></p>
        </div>
        <div class="col-4">
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
        <div class="col-4">
            <h2><?php echo $texts->getTxt('boka-header') ?></h2>
            <p><?= $texts->getTxt('boka-intro') ?> <a href="mailto:falsterbo@skof.se"><b> <?= $texts->getTxt('boka-epost') ?></b></a></p>
            <h2><?php echo $texts->getTxt('pris-header') ?></h2>
            <p><?php echo $texts->getTxt('pris-1') ?></p>
            <p><?php echo $texts->getTxt('pris-2') ?></p>
            <h2><?php echo $texts->getTxt('exkursioner-header') ?></h2>
            <p><?php echo $texts->getTxt('exkursioner-1') ?></p>
            <p><?php echo $texts->getTxt('exkursioner-2') ?></p>
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

    <div class="d-flex justify-content-center">
        <div class="row">
            <div class="col-6">
                <img src="/bilder/sfrlogoh48px.gif" width="83" height="48" alt="logga"><br>
            </div>
            <div class="col-6">
                <img src="/bilder/vellinge.gif" width="77" height="48" alt="logga">
            </div>

        </div>
    </div>
    <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>

</div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());