<?php
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "functions.php";

include_once 'OmOssMenu.php';

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);

$pageMetaData->setAdditionalJavaScriptFiles('headerOmOss.js');
$pageMetaData->setAdditionalJavaScriptFiles('jul.js');

//footer info
$introText = ' ';
$updatedDate = '2022-03-10';
$updatedBy = ' ';

$language = getRequestLanguage();


$pageMenu = New TopMenu($language);
$pageMenu->setOmOssSelected();

$sectionMenu = new OmOssMenu($language);
$sectionMenu->setJulgavaSelected();


echo getHtmlHead('', $pageMetaData, $language);
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
                <h2 id="bodyHeader"></h2>
                <p id="p1"></p>
                <p id="p2"></p>
                <p id="p3"></p>
                <h3 id="orderHereHeader"></h3>
                <div class="frame container pb-3">
                    <h4 id="motifHeader"></h4>
                    <p id="motifPrompt"></p>
                    <form id="orderGift">
                        <div class="mb-3">
                            <div class="modal-body Xd-flex Xjustify-content-center">
                                <div class="btn-group" role="group" aria-label="Select gift" id="giftGroup">

                                    <input type="radio" checked class="btn-check gift-button" name="gift" id="btnradio-siskin" value="siskin" autocomplete="off" >
                                    <label id="lbl-siskin" class="btn btn-outline-primary" for="btnradio-siskin"><img src="images/xmas-1-mini.jpg" alt="siskin"/>Gråsiska</label>


                                </div>
                            </div>
                            <div><small><span id="motifWarning" class="text-danger"></span></small></div>
                        </div>

                        <div class="mb-3">
                            <h4 id="giftHeader"></h4>

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
                    <div id="showSection""></div>
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
                <div class="modal-body Xd-flex Xjustify-content-center">
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