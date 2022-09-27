<?php
include_once 'OmStationenTexter.php';
include_once 'OmOssMenu.php';
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/common-functions.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('headerOmOss.js?dummy=' . $t);

//footer info
$introText = ' ';
$updatedDate = '2019-11-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new OmStationenTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setInternationelltSelected();
echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

?>

    <div class="basePage">

        <?=  getBannerHTML( 'omossvinjett.png'); ?>
        <?=  $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div>
                <?= $sectionMenu->getHTML(); ?>
            </div>


            <div class="std">
                <div>
                    <h2><?= $texts->getTxt('inter-header') ?></h2>
                    <p>
                        <?= $texts->getTxt('inter-text-1') ?>
                    </p>
                    <p>
                        <?= $texts->getTxt('inter-text-2') ?>
                    </p>
                </div>

                <div class="flex">

                    <div>
                        <img class="shadow" src="/bilder/friendship_agreement.jpg" alt="agreement" width="250" height="400">
                    </div>
                    <div>
                        <h2><?= $texts->getTxt('inter-perspektiv') ?></h2>
                        <p><a href="internationellt/mutual_benefits.pdf">Mutual Benefits</a></p>
                        <p><a href="internationellt/cmbo2016.pdf">A global friendship agreement through the lens of the Cape May B.O. (2016), David La Puma</a></p>
                        <p><a href="internationellt/fbo_report_2016.pdf">Friendship Agreement in a perspective from Falsterbo B.O. (2016), Björn Malmhagen</a></p>
                        <p><a href="internationellt/spurn_report_2016.pdf">The Friendship Agreement between New Jersey Audubon’s Cape May B.O. (USA), Falsterbo B.O. (Sweden) and Spurn B.O. (UK). A perspective from Spurn 2016. Nick Whitehouse</a></p>
                    </div>
                </div>

            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());