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
$sectionMenu->setExkursionerSelected();

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
                <h2><?php echo $texts->getTxt('exkursioner-header') ?></h2>
                <p><?php echo $texts->getTxt('exkursioner-1') ?></p>
                <p><?php echo $texts->getTxt('exkursioner-2') ?></p>
            </div>

        </div>
    </div>



    <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
</div>
</div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());