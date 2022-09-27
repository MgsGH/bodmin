<?php
include_once 'OmStationenTexter.php';
include_once 'OmOssMenu.php';
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";


// Steers linked-in CSS and JS files
include_once "../aahelpers/PageMetaData.php";
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('headerOmOss.js?dummy=' . $t);

//footer info
$introText = ' ';
$updatedDate = '2021-12-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new OmStationenTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setBidragSelected();

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
                <h2><?= $texts->getTxt('bidrag-header') ?></h2>
                <p><?= $texts->getTxt('bidrag-intro-1') ?></p>

                <div class="flex">
                    <div class="std">
                        <div style="mt-2">
                            <img src="https://www.falsterbofagelstation.se/stodoss/bilder/fagelvan170w.jpg" alt="Bli en fågelvän logga">
                        </div>
                        <p class="mt-3"><?= $texts->getTxt('bidrag-intro-2') ?></p>
                        <p><?= $texts->getTxt('bidrag-intro-3') ?></p>
                        <div>
                            <p><?= $texts->getTxt('bidrag-swish-1') ?> <?= $texts->getTxt('bidrag-swish-2') ?></p>
                        </div>
                        <p><?= $texts->getTxt('bidrag-intro-4') ?></p>

                    </div>


                    <div class="mt-3">
                        <h3><?= $texts->getTxt('bidrag-fv-1') ?></h3>
                        <p><strong><?= $texts->getTxt('bidrag-fv-2') ?></strong></p>
                        <p><?= $texts->getTxt('bidrag-fv-3') ?></p>


                        <p><strong><?= $texts->getTxt('bidrag-fv-4') ?></strong></p>
                        <p><?= $texts->getTxt('bidrag-fv-5') ?></p>
                        <p><?= $texts->getTxt('bidrag-fv-6') ?></p>

                        <p><strong><?= $texts->getTxt('bidrag-fv-7') ?></strong></p>
                        <p><?= $texts->getTxt('bidrag-fv-8') ?></p>

                        <p><strong><?= $texts->getTxt('bidrag-fv-9') ?></strong></p>
                        </p><?= $texts->getTxt('bidrag-fv-10') ?></p>
                        <ul>
                            <li><?= $texts->getTxt('bidrag-fv-l-1') ?></li>
                            <li><?= $texts->getTxt('bidrag-fv-l-2') ?></li>
                            <li><?= $texts->getTxt('bidrag-fv-l-3') ?></li>
                            <li><?= $texts->getTxt('bidrag-fv-l-4') ?></li>
                        </ul>


                        <p><strong><?= $texts->getTxt('bidrag-fv-11') ?></strong><br/>
                        </p><?= $texts->getTxt('bidrag-fv-11') ?></p>
                        <ul>
                            <li><?= $texts->getTxt('bidrag-fv-2-1') ?></li>
                            <li><?= $texts->getTxt('bidrag-fv-2-2') ?></li>
                        </ul>

                        <p><strong><?= $texts->getTxt('bidrag-fv-12') ?></strong></p>
                        <p><?= $texts->getTxt('bidrag-fv-13') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());