<?php

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . "/aahelpers/PageMetaData.php";
include_once $path . '/aahelpers/common-functions.php';
include_once $path . "/sales/SalesMenu.php";
include_once $path . "/sales/data/db.php";

$pdo = getSalesPDO();

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');

$pageMetaData->setAdditionalJavaScriptFiles('orders.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setJQueryUI(true);

$sectionMenu = new salesMenu('sv');
$sectionMenu->setOrdersSelected();
$language = 1;

echo getHtmlHead('', $pageMetaData, $language);
?>
<div class="basePage">

    <div class="container-fluid" id="pageHeader">

    </div>
    <div class="d-flex mt-2">

        <div class="std cal-nav pt-2">
            <?= $sectionMenu->getHTML(); ?>
        </div>

        <div class="std">
            <div id="intro">
                <h2>Beställningslista</h2>
                <h5></h5>
                <div id="introText">

                </div>
                <div class="mb-2">

                </div>
            </div>

            <div id="itemList">

            </div>
            <div id="submitOrder" class="mg-hide-element">
                <button id="btnOpenOrderForm" class="btn-sm btn-outline-success">Slutför beställning</button>
           </div>
           <div id="tack" class="mg-hide-elment text-center mt-6">
                <h4>Tack för din beställning. Varorna kommer inom kort.</h4>
           </div>

        </div>
    </div>

</div>


<!-- Modal edit/new/delete -->
<div class="modal fade" id="modalEditPerson" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="#modal-mode" class="mg-hide-element"></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditPersonHeader">xxxx</h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="post" id="edit-box">

                    <div>

                        <div class="form-group mb-2">
                            <div class="row">
                                <div class="col">
                                    <label for="inpFirstName" id="lblFirstName">För-</label> och <label for="inpLastName" id="lblLastName">efternamn</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="inpFirstName" name="firstName" required class="form-control-sm" placeholder="Förnamn">    <input type="text" id="inpLastName" name="lastName" required class="form-control-sm" placeholder="Efternamn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span><small class="mg-warning-input" id="warningFirstName">Firstname</small></span><span class="text-alert"><small class="mg-warning-input" id="warningLastName">Eftertname</small></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">

                            <div class="row">
                                <div class="col">
                                    <label for="inpPostalAddress" id="lblPostalAddress">Box eller gatuadress</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="inpPostalAddress" name="postalAddress" class="form-control-sm" size="49" placeholder="Postadress">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span><small class="mg-warning-input" id="warningPostalAddress"></small></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">

                            <div class="row">
                                <div class="col">
                                    <label id="lblZipCode" for="zipCode">Postnummer</label> och <label for="inpCity" id="lblCity">Postort</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="inpZipCode" name="zipCode" class="form-control-sm" size="20" placeholder="Postnummer">  <input type="text" id="inpCity" name="city" class="form-control-sm" placeholder="ort">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span><small class="mg-warning-input" id="warningZipCode"></small></span><span><small class="mg-warning-input" id="warningCity"></small></span>
                                </div>
                            </div>

                        </div>

                        <div class="form-group mb-2">

                            <div class="row">
                                <div class="col">
                                    <label for="inpCountry" id="lblCountry">Land</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="inpCountry" name="country" class="form-control-sm" size="49" placeholder="Land" value="Sverige">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span><small class="mg-warning-input" id="warningCountry"></small></span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group mb-5">

                            <div class="row">
                                <div class="col">
                                    <label for="inpEMail" id="lblEMail">E-post adress</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="inpEMail" name="email" class="form-control-sm" size="49" placeholder="E-post adress">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span><small class="mg-warning-input" id="warningEMail"></small></span>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button id="btnModalEditPersonCancel" type="button" class="btn btn-secondary closeModal" data-dismiss="modal">XXXX</button>
                <button id="btnModalEditPersonSave" class="btn btn-primary" type="submit">XXXX</button>
            </div>
        </div>
    </div>
</div>





<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());


