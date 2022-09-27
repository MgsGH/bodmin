<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "../aahelpers/TopMenu.php";
include_once '../taxa/ArtlistanTexts.php';
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/db.php";
include_once '../aahelpers/common-functions.php';


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setDataTables(true);
$pageMetaData->setAdditionalJavaScriptFiles('index.js');

$pdo = getDataPDO();
$language = getRequestLanguage();

$texts = new ArtlistanTexts($language);

//footer info
$introText = ' ';
$updatedDate = '2021-12-27';
$updatedBy = $texts->getTxt('sammanställt');

$pageMenu = New TopMenu($language);
$pageMenu->setArtListaSelected();


echo getHtmlHead($texts->getTxt('page-title'), $pageMetaData, $language);

?>

    <div class="basePage">
        <?php echo getBannerHTML('taxa-vinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>

        <div class="Xd-flex mt-2">

            <div class="taxa-table control-panel pl-6">

                <div class="pt-2 pb-4">
                    <h5 id="headerShowWhat">Visa vad</h5>
                    <div class="d-flex pl-6">
                        <div class="Xmg-yellow">
                            <span id="artgrupper">XX</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="rare" checked>
                                <label class="form-check-label" id="labelRare" for="rare"></label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="hackare" checked>
                                <label class="form-check-label" id="labelHackare" for="hackare"></label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="rareHackare" checked>
                                <label class="form-check-label" id="labelRareHackare" for="rareHackare"></label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="tidigareHackare" checked>
                                <label class="form-check-label" id="labelTidigareHackare" for="tidigareHackare"></label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="ovrigaIckeHackande" checked>
                                <label class="form-check-label" for="ovrigaIckeHackande" id="labelOvrigaIckeHackande"></label>
                            </div>

                        </div>


                        <div>

                            <span id="namn">XX</span>

                            <div class="form-check form-switch col-2">
                                <div class="ml-4">
                                    <input class="form-check-input" type="checkbox" id="sciName" checked>
                                    <label class="form-check-label" id="labelSciName" for="sciName"></label>
                                </div>
                            </div>
                            <div class="form-check form-switch col-2">
                                <input class="form-check-input" type="checkbox" id="commonName" checked>
                                <label class="form-check-label" id="labelCommonName" for="commonName"></label>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="d-flex justify-content-center">
                <div class="pt-2 taxa-table" id="tablePlaceHolder">
                    <table id="taxaTable" class="table table-striped table-sm w-auto">
                        <thead class="thead-light" id="taxaListHead">
                        </thead>
                        <tbody id="taxaListBody">
                        </tbody>
                    </table>'
                </div>
            </div>

        </div>
        <br/><br/>
        <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="taxonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taxonDetailHeader">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="fyndSummary">
                        <p><span id="no-of-fynd">4</span> <span id="noOfFyndText">xx</span>, <span id="no-of-birds">55r</span> <span id="noOfBirdsText">xx</span>.</p>
                    </div>
                    <div>
                        <table class="table table-striped table-hover table-sm w-auto">

                            <thead class="thead-light">
                            <tr>
                                <th id="tableHeaderFynd"></th>
                                <th id="tableHeaderDate"></th>
                                <th id="tableHeaderNoAgeSex"></th>
                                <th id="tableHeaderPlaceCircumstancesAndReferences"></th>
                            </tr>
                            </thead>
                            <tbody id="taxonObservationsTableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="buttonBack" class="btn btn-primary" data-bs-dismiss="modal">Back to list</button>
                </div>
            </div>
        </div>

    </div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
