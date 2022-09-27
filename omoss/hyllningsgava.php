<?php
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "functions.php";

include_once 'OmStationenTexter.php';
include_once 'OmOssMenu.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);
$t = time();
$pageMetaData->setAdditionalJavaScriptFiles('headerOmOss.js?dummy=' . $t);
$pageMetaData->setAdditionalJavaScriptFiles('gift.js');

//footer info
$introText = ' ';
$updatedDate = '2022-02-17';
$updatedBy = ' ';

$language = getRequestLanguage();
$texts = new OmStationenTexter($language);

$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setHyllningsgavaSelected();

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
                <h2><?= $texts->getTxt('hyllningsgava-header') ?></h2>
                <p><?= $texts->getTxt('hyllningsgava-para-1') ?></p>
                <p><?= $texts->getTxt('hyllningsgava-para-2') ?></p>
                <p><?= $texts->getTxt('hyllningsgava-para-3') ?></p>
                <h3 id="orderHereHeader"></h3>
                <div class="frame container pb-3">
                    <h4 id="motifHeader"><?= $texts->getTxt('hyllningsgava-motiv') ?></h4>
                    <p id="motifPrompt"></p>
                    <form id="orderGift">
                        <div class="mb-3">
                            <div class="modal-body d-flex justify-content-center">
                                <div class="btn-group" role="group" aria-label="Select gift" id="giftGroup">

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-svalor" value="svalor" autocomplete="off">
                                    <label id="lbl-svalor" class="btn btn-outline-primary" for="btnradio-svalor"><img src="images/gift-1-mini.jpg" alt="svalor"/>Svalor</label>

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-fiskgjuse" value="fiskgjuse" autocomplete="off">
                                    <label id="lbl-fiskgjuse" class="btn btn-outline-primary" for="btnradio-fiskgjuse"><img src="images/gift-2-mini.jpg" alt="fiskgjuse"/>Fiskgjuse</label>

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-blamesar" value="blamesar" autocomplete="off">
                                    <label id="lbl-blamesar" class="btn btn-outline-primary" for="btnradio-blamesar"><img src="images/gift-3-mini.jpg" alt="blåmes"/>Blåmesar</label>

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-havsorn" value="havsorn" autocomplete="off">
                                    <label id="lbl-havsorn" class="btn btn-outline-primary" for="btnradio-havsorn"><img src="images/gift-4-mini.jpg" alt="havsörn"/>Havsörn</label>

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-flommen" value="flommen" autocomplete="off">
                                    <label id="lbl-flommen" class="btn btn-outline-primary" for="btnradio-flommen"><img src="images/gift-5-mini.jpg" alt="flommen"/>Flommen</label>

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-skarflackor" value="skarflackor" autocomplete="off">
                                    <label id="lbl-skarflackor" class="btn btn-outline-primary" for="btnradio-skarflackor"><img src="images/gift-6-mini.jpg" alt="skarflackor"/>Skärfläckor</label>

                                    <input type="radio" class="btn-check gift-button" name="gift" id="btnradio-rodsjart" value="rodsjart" autocomplete="off">
                                    <label id="lbl-rodsjart" class="btn btn-outline-primary" for="btnradio-rodsjart"><img src="images/gift-7-mini.jpg" alt="rodsjtart"/>Rödstjärt</label>

                                </div>
                            </div>
                            <div><small><span id="motifWarning" class="text-danger"></span></small></div>
                        </div>

                        <div class="mb-3">
                            <h4 id="dateHeader"></h4>

                            <div class="form-group mb-3 w-50">
                                <label id="dateLabel" for="deliveryDate">Datum</label>
                                <input name="deliveryDate" id="deliveryDate" class="form-control">
                                <div id="dateLabelSuffix" class="form-text"></div>
                                <div><small><span id="dateWarning" class="text-danger"></span></small></div>
                            </div>

                            <div class="form-group mb-2 w-50">
                                <label id="greetingLabel" for="greeting"></label>
                                <textarea id="greeting" class="form-control" cols="50" rows="3"></textarea>
                                <div><small><span id="greetingWarning" class="text-danger"></span></small></div>
                            </div>

                            <div class="form-group mb-1 w-50">
                                <label id="jubileeLabel" for="jubilee"></label>
                                <input id="jubilee" name="jubilee" type="text" class="form-control" size="50">
                                <div><small><span id="toWhomWarning" class="text-danger"></span></small></div>
                            </div>

                            <div class="form-group mb-1 w-50">
                                <label id="wishesLabel" for="wishes"></label>
                                <input id="wishes" name="wishes" class="form-control" type="text" size="50">
                                <div><small><span id="wishesWarning" class="text-danger"></span></small></div>
                            </div>

                        </div>

                        <h4 id="deliveryAddressHeader"></h4>
                        <div class="w-50">

                            <div class="mb-2">
                                <div class="row mb-2">
                                    <div class="col-auto form-group w-50">
                                        <input type="text" id="deliveryFirstName" name="deliveryFirstName" class="form-control" placeholder="" aria-label="First name">
                                    </div>
                                    <div class="col form-group w-50">
                                        <input type="text" id="deliveryLastName" name="deliveryLastName" class="form-control" placeholder="Last name" aria-label="Last name">
                                    </div>
                                </div>
                                <div><small><span id="deliveryNameWarning" class="text-danger"></span></small></div>
                            </div>

                            <div class="mb-3">

                                <div class="mb-2 form-group">
                                    <input id="deliveryAddressStreet" name="street" type="text" class="form-control" placeholder="">
                                </div>

                                <div class="row mb-2">
                                    <div class="col form-group">
                                        <input type="text" id="deliveryAddressZipCode" name="zipcode" class="form-control" placeholder="Postnummer" aria-label="First name">
                                    </div>
                                    <div class="col form-group">
                                        <input id="deliveryAddressCity" type="text" name="town" class="form-control" placeholder="Post ort" aria-label="Last name">
                                    </div>
                                </div>
                            </div>
                            <div><small><span id="deliveryAddressWarning" class="text-danger"></span></small></div>
                        </div>
                        <div>
                            <h4 id="payeeHeader"></h4>
                        </div>
                        <div class="w-50">
                            <div class="mb-2">
                                <div class="row form-group">
                                    <div class="col w-50">
                                        <input type="text" id="payeeFirstName" class="form-control" placeholder="" aria-label="First name">
                                    </div>
                                    <div class="col w-50">
                                        <input type="text" id="payeeLastName" class="form-control" placeholder="" aria-label="Last name">
                                    </div>
                                </div>
                                <div><small><span id="payeeNameWarning" class="text-danger"></span></small></div>
                            </div>
                        </div>

                        <div class="w-75">
                            <div class="mb-3">
                                <div class="row form-group">
                                    <div class="col w-50">
                                        <input type="email" id="payeeEmail" name="email" class="form-control" placeholder="" aria-label="e-mail">
                                    </div>
                                    <div class="col">
                                        <input type="tel" id="payeeTelephone" name="telephone" class="form-control" placeholder="" aria-label="Telefonnummer">
                                    </div>
                                </div>
                                <div><small><span id="payeeContactWarning" class="text-danger"></span></small></div>
                            </div>
                        </div>

                        <div>
                            <h4 id="sumHeader"></h4>
                        </div>
                        <div class="w-50 form-group">
                            <label for="sum" class="form-label"><span id="sumValue">X</span> kronor</label>
                            <input type="range" class="form-range" min="300" max="10000" step="100" value="500" id="sum">
                        </div>

                        <div>
                            <hr>
                        </div>
                        <div>
                            <button id="orderButton" class="btn btn-primary"></button>
                        </div>
                        <div><small><span id="generalWarning" class="text-danger"></span></small></div>

                    </form>

                </div>
            </div>

        </div>
            <?= getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
        </div>


    </div>

    <!-- Modal show letter template (photo) -->
    <div id="modalShowPhotoWindow" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalShowPhotoHeader" class="modal-title"></h5>
                    <button id="closeModalShowPhoto" type="button" class="close closeModalShowPhoto" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div id="showSection"></div>
                </div>
                <div class="modal-footer">
                    <button id="btnModalShowPhotoCancel" type="button" class="btn btn-secondary closeModalShowPhoto"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal show order -->
    <div id="modalShowOrderWindow" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalShowOrderHeader" class="modal-title"></h5>
                    <button id="closeModalShowOrder" type="button" class="close closeModalShowOrder" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div id="showOrderSection"></div>
                </div>
                <div class="modal-footer">
                    <button id="btnModalShowOrderCancel" type="button" class="btn btn-secondary closeModalShowOrder">C</button>
                    <button id="btnModalShowOrderConfirm" type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());