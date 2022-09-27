<?php
session_start();

// common for all pages
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/db.php";
include_once '../aahelpers/common-functions.php';

// unique for this page
include_once 'PublikationerTexter.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('index.js?dummy=' . $t);
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setSelect2(true);
$pageMetaData->setDataTables(true);

//footer info
$introText = ' ';
$updatedDate = '2021-10-17';
$updatedBy = ' ';

$language = getRequestValueWithDefault('lang', 'sv');
$langNum = getLang($language);

$texts = new PublikationerTexter($language);
$pdo = getDataPDO();

$pageMenu = New TopMenu($language);
$pageMenu->setPublikationerSelected();

$dropDownKeyWords = getDropDownPublicationKeywords($pdo, $langNum);
$dropDownAuthors = getAuthors($pdo);
$dropDownArter = getDropDownPublicationTaxa($pdo, $langNum);

$publicationsKit = getPublications($pdo);
$antalPublikationer = 42;

echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);


?>

    <div class="basePage">

        <?= getBannerHTML( 'vinjett_publikationer.jpg'); ?>
        <?= $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="d-flex mt-2">
            <div class="std art-list-nav">
                <div class="pt-2"><h5>Visa vad och hur</h5></div>

                    <div>

                        <div class="pt-2"><strong><?= $texts->getTxt('filtrera') ?></strong></div>
                        <div class="pt-2"><label for="ddAuthor"><?= $texts->getTxt('forfattare') ?></label></div>
                        <select name="person" class="js-example-basic-single" id="ddAuthor">
                            <?php
                                 echo getDropDownOption($texts->getTxt('alla'), 'alla', '');
                                 foreach ($dropDownAuthors as $author){
                                     $txt = $author['TEXT'];
                                     echo getDropDownOption($txt, $author['AUTHOR_ID'], '');
                                 };
                            ?>
                        </select>

                        <div class="pt-2"><label for="ddKeyword"> <?= $texts->getTxt('nyckel-ord') ?></label></div>
                        <select name="keyword" class="js-example-basic-single" id="ddKeyword">
                            <?php
                            echo getDropDownOption($texts->getTxt('alla'), 'alla', '');
                            foreach ($dropDownKeyWords as $dropDownKeyWord){
                                $txt = $dropDownKeyWord['TEXT'] .'&nbsp;(' . $dropDownKeyWord['NO_OF'] . ')';
                                echo getDropDownOption($txt, $dropDownKeyWord['KEYWORD_ID'], '');
                            };
                            ?>
                        </select>

                        <div class="pt-2"><label for="ddTaxon"> <?= $texts->getTxt('art') ?></label></div>
                        <select name="species" class="js-example-basic-single" id="ddTaxon">
                            <?php
                            echo getDropDownOption($texts->getTxt('alla'), 'alla', '');
                            foreach ($dropDownArter as $dropDownArt){
                                $txt = $dropDownArt['TEXT'];
                                echo getDropDownOption($txt, $dropDownArt['TAXA_ID'], '');
                            };
                            ?>
                        </select>
                        <br/>
                        <div class="pt-3"><strong><?= $texts->getTxt('sortering') ?></strong></div>
                        <input type="radio" id="radioBoxYearsDescending" name="yearRB" value="desc">
                        <label for="radioBoxYearsDescending"><?= $texts->getTxt('sorting-desc') ?></label><br>
                        <input type="radio" id="radioBoxYearsAscending" name="yearRB" value="asc" checked>
                        <label for="radioBoxYearsAscending"><?= $texts->getTxt('sorting-asc') ?></label><br>
                        <br/>
                    </div>
                <hr>

            </div>
            <div class="std">
                <table class="table table-striped publications" id="publicationsTable">
                    <thead id="publicationsTableHead">
                        <tr class="mg-hide-element">
                           <th class="text-center">X</th>
                           <th class="text-center">Y</th>
                        </tr>
                    </thead>
                    <tbody id="publicationsTableBody"></tbody>
                </table>
            </div>

        </div>
        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());