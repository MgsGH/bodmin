<?php
session_start();

// common for all pages
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/db.php";
include_once '../aahelpers/common-functions.php';

// unique for this page
include_once 'GalleriTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('index.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);


//footer info
$introText = ' ';
$updatedDate = '2021-12-27';
$updatedBy = ' ';

$language = getRequestValueWithDefault('lang', 'sv');
$langNum = getNoCode($language);

$texts = new GalleriTexter($language);
$pdo = getDataPDO();

$pageMenu = New TopMenu($language);

$dropDownKeyWords = getImageKeywords($pdo, $language);
$dropDownFotografer = getPhotographers($pdo);
$dropDownArter = getTaxaWithImages($pdo, $langNum);

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);
$pageMenu->setGalleriSelected();

?>

    <div class="basePage">
        <?= getBannerHTML( 'noheader.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">

            <div class="std rast-nav">
                    <div class="pt-2">

                        <h5 class="pt-2"><span id="headerText"></span></h5>
                        <div><strong id="filterText">Filtrera</strong></div>
                        <div id="filterPhotographerText"></div>
                        <select name="person" class="js-example-basic-single" id="ddPhotographer">
                            <?php
                            echo getDropDownOption($texts->getTxt( 'alla'), '0', '0');
                            foreach ($dropDownFotografer as $fotograf){
                                $txt = $fotograf['NAME'] .'   (' . $fotograf['NOOF'] . ')';
                                echo getDropDownOption($txt, $fotograf['PERSON_ID'], '');
                            }
                            ?>
                        </select>

<?php /*
                        <div class="pt-2"><?= $texts->getTxt('grupp') ?></div>
                        <select name="keyword">
                            <?php
                            /*
                            echo getDropDownOption($texts->getTxt('alla'), 'alla', '');
                            foreach ($dropDownKeyWords as $dropDownKeyWord){
                                $txt = $dropDownKeyWord['NAME'] .' (' . $dropDownKeyWord['NOOF'] . ')';
                                echo getDropDownOption($txt, $dropDownKeyWord['ID'], '');
                            };
                        </select>
                            */
?>

                        <div class="pt-2" id="taxonText"></div>
                        <select name="taxon" class="js-example-basic-single" id="ddTaxon">
                            <?php
                            echo getDropDownOption($texts->getTxt('alla'), '0', '');
                            foreach ($dropDownArter as $dropDownArt){
                                $txt = $dropDownArt['NAME'] .' (' . $dropDownArt['NOOF'] . ')';
                                echo getDropDownOption($txt, $dropDownArt['TAXA_ID'], '');
                            }
                            ?>
                        </select>
                        <br/>

                        <div class="pt-2">
                            <label for="ddNoOfImages"><strong id="imagesPerPageText">Antal bilder per sida</strong></label>
                        </div>
                        <div>
                            <select name="noofimages" class="js-example-basic-single" id="ddNoOfImages" style="width: 30%">
                                <option value="12">12</option>
                                <option value="20" selected>20</option>
                                <option value="32">32</option>
                            </select>
                        </div>
                        <br/>
                    </div>

                <hr>

            </div>
            <div class="std">

                <h2 class="pt-2"><span id="headerTextPartOne"></span><span id="headerTextPartTwo"></span></h2>

                <div id="imagesPanel">

                </div>

                <div class="text-center">

                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button id="btnBack" type="button" class="btn btn-primary btn-sm" disabled><<</button>
                        <button type="button" class="btn btn-outline-primary disabled mg-noBorder btn-sm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                        <button id="btnNext" type="button" class="btn btn-primary btn-sm">>></button>
                    </div>


                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-body">
                        <div id="modalImagePanel">

                        </div>
                        <div><span id="taxonName"></span><span id="imageMetaDataPlace"></span>, <span id="imageMetaDataDate"></span>. <span id="photographerText"></span><span id="photographerName">Fotograf har</span></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="buttonBack" class="btn btn-sm btn-outline-primary" data-bs-dismiss="modal">X</button>
                    </div>
                </div>
            </div>

        </div>


        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>





<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());