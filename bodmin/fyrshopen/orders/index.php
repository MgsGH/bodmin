<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

include_once $path . '/aahelpers/common-functions.php';
include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/AppMenu.php';
include_once $path . "/aahelpers/PageMetaData.php";

// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setSelect2(true);
$pageMetaData->setAdditionalJavaScriptFiles('orders.js');

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 10;
$info = "";


$pdo = getDataPDO();
/*
if (!checkBookingsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ../login/index.php");
    exit;
}
*/

$language = getRequestLanguage();

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(3);
echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
echo $appMenu->getAsHTML();


?>

    <!-- main page -->
    <div class="container-fluid">
    <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>
    <div class="row">

        <div class="col-sm-2 mg-sidenav positionX-relative">
            <div>
                <div class="mb-3">
                    <h2 id="hdrMain">main</h2>
                    <h3 id="hdrSub">main</h3>
                    <p>Ver. 0</p>
                </div>

                <hr class="dotted">
                <small id="infoLabel"></small><br/>
                <div class="btn-block" id="editButtons">
                    <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top editButton">xxxx</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top editButton">xxxx</button>
                </div>
            </div>

            <div id="bookingInfoPanel" class="mg-hide-element">
                <hr class="dotted">

                <div>
                    <small id="bookedRecordLabel">Vald boking</small> <strong><small id="bookedRecordText">Some data here</small></strong>
                </div>
                <button id="btnEditBooking" type="button" class="btn btn-sm btn-primary mg-top editButton">xxxx</button>
                <button id="btnShowBooking" type="button" class="btn btn-sm btn-primary mg-top editButton">xxxx</button>
                <button id="btnDeleteBooking" type="button" class="btn btn-sm btn-danger mg-top editButton">xxxx</button>
            </div>
            
            <br/>
            <br/>
        </div>

        <div class="col-sm-10 mg-white">
            <div>
                <table id="data" class="table table-hover w-auto">
                    <thead>
                    <tr>
                        <th colspan="6">
                            <!-- Custom rounded search bars with input group -->
                            <form>
                                <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
                                        </div>
                                        <input type="search" id="tblFilterBox" placeholder="xxxx" aria-describedby="button-addon2" class="mg-form-control border-0 bg-light">
                                    </div>
                                </div>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th id="tblHdrOrderNumber"></th>
                        <th id="tblHdrFirstName"></th>
                        <th id="tblHdrLastName"></th>
                        <th id="tblHdrCity"></th>
                        <th id="tblHdrEmail"></th>
                        <th id="tblHdrCreatedWhen"></th>
                        <th id="tblHdrOrderStatus"></th>
                    </tr>
                    </thead>
                    <tbody id="dataRows">
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

    <!-- Modal edit/new/delete/ customer -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div id="#modal-mode" class="mg-hide-element"></div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHeaderEdit">xxxx</h5>
                    <button type="button" class="close closeModal" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalMainSectionEdit">
                        <div id="tabs" class="container">
                        <ul>
                            <li><a id="customerModalTabBaseData" href="#baseData">xxx</a></li>
                            <li><a id="customerModalTabInvoiceData" href="#invoiceData">xxx</a></li>
                        </ul>
                        <div id="baseData" class="container">

                            <!-- Customer name -->
                            <div class="mb-2">
                                <label for="inputCustomerName" id="lblCustomerName"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerName" name="customerName" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerNameWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Customer address -->
                            <div class="mb-2">
                                <label for="inputCustomerAddress" id="lblAddress"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerAddress" name="customerName" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerAddressWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Customer Zip code & City  -->
                            <div class="pb-2">
                                <label for="inputCustomerZipCode" id="lblZipCode"></label> & <label for="inputCustomerCity" id="lblCity"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerZipCode" name="customerZipCode" required class="form-control">
                                    <input type="text" id="inputCustomerCity" name="customerCity" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerCityWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Customer Contact Person -->
                            <div class="pb-2">
                                <label for="inputCustomerContactPerson" id="lblContactPerson">hoho</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerContactPerson" name="customerContactPerson" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerContactPersonWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Customer email -->
                            <div class="mb-2">
                                <label for="inputCustomerEmail" id="lblEmail"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerEmail" name="customerEmail" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerEmailWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Customer telephone -->
                            <div class="mb-2">
                                <label for="inputCustomerTelephoneOne" id="lblTelephoneOne"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerTelephoneOne" name="customerTelephoneOne" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerTelephoneOneWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Customer telephone -->
                            <div class="mb-2">
                                <label for="inputCustomerTelephoneTwo" id="lblTelephoneTwo"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputCustomerTelephoneTwo" name="customerTelephoneTwo" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="customerTelephoneTwoWarning" class="formWarning"></small></div>
                            </div>

                        </div>
                        <div id="invoiceData">

                            <!-- Invoice name -->
                            <div class="mb-2">
                                <label for="inputInvoiceName" id="lblInvoiceName"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputInvoiceName" name="invoiceName" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="invoiceNameWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Invoice id -->
                            <div class="mb-2">
                                <label for="inputInvoiceId" id="lblInvoiceId"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputInvoiceId" name="invoiceId" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="invoiceIdWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Invoice address -->
                            <div class="mb-2">
                                <label for="inputInvoiceAddress" id="lblInvoiceAddress"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputInvoiceAddress" name="invoiceName" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="invoiceAddressWarning" class="formWarning"></small></div>
                            </div>

                            <!-- Invoice Zip code & City  -->
                            <div class="pb-2">
                                <label for="inputInvoiceZipCode" id="lblInvoiceZipCode"></label> & <label for="inputInvoiceCity" id="lblInvoiceCity"></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="inputInvoiceZipCode" name="invoiceZipCode" required class="form-control">
                                    <input type="text" id="inputInvoiceCity" name="invoiceCity" required class="form-control">
                                </div>
                                <div class="text-danger"><small id="invoiceCityWarning" class="formWarning"></small></div>

                            </div>    

                        </div>
                    </div>
                    </div>
                    <div id="modalMainSectionDelete">
                        <h6 id="headerDelete" class="mb-4"></h6>
                        <p id="blurbDelete"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnModalMainCancel" type="button" class="btn btn-secondary closeModal" data-dismiss="modal">xxxx</button>
                    <button id="btnModalMainSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());