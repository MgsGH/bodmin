<?php
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . "/aahelpers/TopMenu.php";
include_once $path . "/aahelpers/common-functions.php";

include_once $path . "/strack/StrackHeaderTexter.php";
include_once $path . "/strack/StrackTexter.php";
include_once $path . "/strack/StrackMenu.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/strack/strackHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('metodik.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);


//footer info
$introText = ' ';
$updatedDate = '2022-09-01';
$updatedBy = ' ';

$language = getRequestValueWithDefault('lang', 'sv');
$texts = new StrackTexter($language);
$headerTexts = new StrackTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setStrackSelected();

$sectionMenu = new StrackMenu($language);
$sectionMenu->setMetodikSelected();

?>
    <?php echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language) ?>
    <div class="basePage">

        <?= getBannerHTML('../nabben-small.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="std">

                <h2><?php echo $texts->getTxt('header-metodik') ?></h2>
                <h3><?php echo $texts->getTxt('m-intro-header') ?></h3>
                <p> <?php echo $texts->getTxt('m-intro') ?> </p>
                <h3><?php echo $texts->getTxt('m-standard-roos-header') ?> </h3>
                <p> <?php echo $texts->getTxt('m-standard-roos-i') ?> </p>
                <p> <?php echo $texts->getTxt('m-standard-roos-ii') ?> </p>
                <h3><?php echo $texts->getTxt('m-rovisar-header') ?> </h3>
                <p> <?php echo $texts->getTxt('m-rovisar') ?> </p>
                <h3><?php echo $texts->getTxt('m-std-header') ?> </h3>
                <p> <?php echo $texts->getTxt('m-std-i') ?> </p>
                <p> <?php echo $texts->getTxt('m-std-ii') ?> </p>
                <p> <?php echo $texts->getTxt('m-std-iii') ?> </p>
                <p> <?php echo $texts->getTxt('m-std-iv') ?> </p>
                <p> <?php echo $texts->getTxt('m-std-v') ?> </p>
                <h3><?php echo $texts->getTxt('m-omr-header') ?></h3>
                <p> <?php echo $texts->getTxt('m-omr-i') ?> </p>
                <p> <?php echo $texts->getTxt('m-omr-ii') ?> </p>
                <p> <?php echo $texts->getTxt('m-omr-iii') ?> </p>
                <p> <?php echo $texts->getTxt('m-omr-iv') ?> </p>
                <p> <?php echo $texts->getTxt('m-omr-v') ?> </p>
                <p> <?php echo $texts->getTxt('m-omr-vi') ?> </p>
                <p> <?php echo $texts->getTxt('m-omr-vii') ?> </p>
                <p> <?php echo $texts->getTxt('m-sammanfattning') ?> </p>
                <ul>
                    <li><?php echo $texts->getTxt('m-bullet-i') ?></li>
                    <li><?php echo $texts->getTxt('m-bullet-ii') ?></li>
                </ul>
                <h3><?php echo $texts->getTxt('m-ref-header') ?></h3>
                <p><?php echo $texts->getTxt('m-ref-i') ?></p>
                <p><?php echo $texts->getTxt('m-ref-ii') ?></p>
                <p><?php echo $texts->getTxt('m-ref-iii') ?></p>
                <p><?php echo $texts->getTxt('m-ref-iv') ?></p>
                <p><?php echo $texts->getTxt('m-ref-v') ?></p>
                <p><?php echo $texts->getTxt('m-ref-vi') ?></p>
                <p><?php echo $texts->getTxt('m-ref-vii') ?></p>

                <p class="info">
                </p>

            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());