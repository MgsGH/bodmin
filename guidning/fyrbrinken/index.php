<?php


include_once "../../aahelpers/PageMetaData.php";
include_once "../../aahelpers/TopMenu.php";
include_once '../../aahelpers/common-functions.php';
include_once "../SectionMenu.php";

include_once '../GuidningsTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');

$pageMetaData->setAdditionalJavaScriptFiles('fyrbrinken.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);

//footer info
$introText = ' ';
$updatedDate = '2022-03-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$pageMenu = New TopMenu($language);

$texts = new GuidningsTexter($language);
$pageMenu->setGuidningSelected();

$sectionMenu = new SectionMenu($language);
$sectionMenu->setBrinkenSelected();

?>
<?php echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
<div class="basePage">

    <?= getBannerHTML('/guidning/guidevinjett.jpg'); ?>
    <?= $pageMenu->getHTML(); ?>
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
    <div class="d-flex mt-2">
        <div>
        <?= $sectionMenu->getHTML(); ?>
        </div>


        <div class="container-fluid pt-2">
            <div>
                <h2><?=$texts->getTxt('lagom-tempo-header')?></h2>
                <p><?=$texts->getTxt('lagom-tempo-i')?></p>
                <p><?=$texts->getTxt('lagom-tempo-ii')?></p>
                <img src="/v2images/maxipics/maxipic-2594.jpg" alt="photo" title="Foto: Björn Malmhagen.">
                <p><?=$texts->getTxt('lagom-tempo-iii')?></p>
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
    <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>
</div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());