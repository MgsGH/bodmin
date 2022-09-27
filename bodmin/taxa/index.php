<?php
session_start();
$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}
include_once $path . '/aahelpers/common-functions.php';
include_once $path . '/aahelpers/db.php';
include_once $path . '/aahelpers/AppMenu.php';

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 12;
$errorPage = 'index-empty.php';

$pdo = getDataPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ./login/index.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($page-1);
$langId = $_SESSION["preferredLanguageId"];
$languageOptions = getLanguageOptionsAsHTML($pdo, $langId);
$measurementOptions = getMeasurementsOptionsAsHTML($pdo, $langId);    // for dropdown in modal
$taxaCodeTypesOptions = getTaxaCodeTypesOptionsAsHTML($pdo, $langId); // for dropdown in modal
$ringTypesOptions = getRingTypesOptionsAsHTML($pdo, $langId);  // for dropdown in modal


echo getHTMLHeader();
echo $appMenu->getAsHTML();

?>

    <!-- main page -->
    <div class="container-fluid">

    <div class="row">

        <div class="col-sm-2 mg-sidenav">
            <h3 id="hdrMain">xxxx</h3>
            <p>Ver. 1.0</p>
            
            <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPerson">
                xxxx
            </button>
            <hr>
            <small id="infoLabel">xxxx</small><br/>
            <div class="btn-block" id="editButtons">
                <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">Ändra</button>
                <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">Tag bort</button>
            </div>
            <hr>
            <div>
                <button id="btnTranslations" type="button" class="btn btn-sm btn-primary mg-top">---</button>
                <button id="btnRings" type="button" class="btn btn-sm btn-primary mg-top">---</button>
                <button id="btnMeasurements" type="button" class="btn btn-sm btn-primary mg-top">--</button>
                <button id="btnCodes" type="button" class="btn btn-sm btn-primary mg-top">--</button>
            </div>

            <br/>
            <div id="action-info" style="background-color: aliceblue" class="mg-text-center"><small></small></div>
            <br/>
            <br/>
        </div>

        <div class="col-5">
            <br/>
            <!-- Custom rounded search bars with input group -->
            <form>
                <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
                        </div>

                        <input type="search" id="tblFilterBox" placeholder="xxxx" aria-describedby="button-addon2" class="mg-form-control border-0 bg-light">
                    </div>
                </div>
            </form>
            <div>
                <table id="data" class="table table-hover w-auto">
                    <thead>
                        <tr>
                            <th id="thShortName">xxxx</th>
                            <th id="thScientific">xxxx</th>
                            <th id="thSysNo">xxxx</th>
                            <th id="thDeciGrams">xxxx</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

    <!-- Modal edit/new/delete -->
    <!-- https://getbootstrap.com/docs/4.0/components/forms/ -->

    <div class="modal fade" id="editMain" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMainHeader">XXXX</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="edit-box">

                        <div id="modalMainEditSection">

                            <div class="form-group-sm">
                                <label class="control-label" for="inpShortName" id="lblInpShortName"></label>
                                <input type="text" id="inpShortName" required class="form-control input-sm" autofocus="autofocus" maxlength="5">
                                <div class="text-alert"><small id="warningShortName"></small></div>
                            </div>

                            <div class="form-group-sm">
                                <label class="control-label" for="inpScientific" id="lblInpScientific"></label>
                                <input type="text" id="inpScientific" required class="form-control input-sm" >
                                <div class="text-alert"><small id="warningInpScientific"></small></div>
                            </div>

                            <div class="form-group-sm">
                                <label class="control-label" for="slctTaxa" id="lblDropDownTaxa"></label>
                                <select id="slctTaxa" class="form-control input-sm">
                                </select>
                            </div>
                            <br/>
                            <div class="form-group-sm">
                                <input type="checkbox" id="cbDeciGrams">
                                <label class="form-check-label" for="cbDeciGrams" id="lblDeciGrams">Decigrams</label>
                            </div>

                        </div>
                        <div id="modalMainDeleteSection"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnModalMainCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                    <button id="btnModalMainSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


    <!-- -----------------------------------------------------------------------------------Modal translations -->
    <div class="modal fade" id="modalEditTranslation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTranslationsHeader">xxxx <span id="forWhatName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-canvas">

                    <div id="translation-rows">
                        <div class="form-group form-row mg-hide-element mg-row" id="translation-row-1">

                            <div class="col-sm-2">
                                <label id="lblModalLanguage-1">L</label>
                                <select id="slct-lang-1" class="form-control" name="slct-lang-1">
                                    <?= $languageOptions ?>
                                </select>
                            </div>

                            <div class="form-group form-row col-sm-9">
                                <label id="lblModalTranslation-1">T</label>
                                <input type="text" id="translation-1" class="form-control input-sm" name="inp-translation-1">
                                <div id="warningx-1" class="text-danger"><small id="error-msg-1">Some test text here..</small></div>
                            </div>

                            <div class="col-sm-1">
                                <label id="lblModalDummy-1"><span class="mg-button-padding">..................</span></label>
                                <button id="btnRemoveRow-1" type="button" class="btn-sm btn-outline-danger mg-top-three mg-delete-translation-row" title="Remove Row"><b> X </b></button>
                            </div>

                        </div>
                    </div>
                    <div class="text-danger" id="div-translation-not-unique"><small id="languages-not-unique">Some test text here..</small></div>
                    <br/>
                    <button id="btnTranslationAdd" type="button" class="btn-sm btn-primary">xxxx</button>

                </div>

                <div class="modal-footer">
                    <button id="btnTranslationsCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                    <button id="btnTranslationsSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


    <!------------------------------------------------------------------------------- Modal M E A S U R E M E N T S -->
    <div class="modal fade" id="modalEditMeasurements" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMeasurementsHeader">xxxx <span id="forWhatMeasurement"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-measurement-canvas">

                    <form method="post" id="form-edit-measurement">
                        <div id="measurement-rows">
                            <div class="form-group form-row mg-hide-element mg-row" id="measurements-row-1">

                                <div class="col-sm-2">
                                    <label id="lblModalMeasurementsType-1">Measurement</label>
                                    <select id="slct-measurements-1" class="form-control" name="slct-measurements-1">
                                        <?= $measurementOptions ?>
                                    </select>
                                </div>

                                <div class="form-group form-row col-sm-4">

                                    <div class="col-sm-4">
                                        <label id="lblModalMeasurementsSex-1">Sex</label>
                                        <select id="slctSex-1" class="form-control input-sm" name="slctSex-1">
                                        </select>
                                    </div>

                                    <div class="col-sm-8">
                                        <label id="lblModalMeasurementsAge-1">Age</label>
                                        <select id="slctAge-1" class="form-control input-sm" title="Decide ages eligible for the setting" name="slctAge-1">
                                        </select>
                                    </div>

                                </div>

                                <div class="col-sm-2">
                                    <label id="lblModalMeasurementsMonths-1" for="slctMonth-1">---</label>
                                    <select id="slctMonth-1" class="form-control input-sm" multiple="multiple" name="slctMonth-1">
                                    </select>
                                </div>

                                <div class="form-group form-row col-sm-3">
                                    <div class="col-sm-5">
                                        <label id="lblModalMeasurementsMin-1">Min</label>
                                        <input class="form-control mg-min" id="id-min-1" placeholder="Min" name="name-input-min-1">
                                        <div class="text-danger varning" id="div-warning-min-1"><small id="warning-min-1">Test här</small></div>
                                    </div>

                                    <div class="col-sm-7 form-group form-row">
                                        <div class="col-sm-9">
                                            <label id="lblModalMeasurementsMax-1">Max</label>
                                            <input class="form-control mg-min" id="id-max-1" placeholder="Max" name="name-input-max-1">
                                            <div class="text-danger varning" id="div-warning-max-1"><small id="warning-max-1">Test här</small></div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label id="lblModalDummyMax-1"><span class="buttonPadding">&nbsp;</span></label>
                                            <button id="btnRemoveRow-1" type="button" class="btn-sm btn-outline-danger mg-top-three mg-delete-measurement-row" title="Remove Row"><b> X </b></button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="text-danger" id="div-not-unique"><small id="measurements-not-unique">Some test text here..</small></div>
                        <br/>
                        <button id="btnMeasurementAdd" type="button" class="btn-sm btn-primary">xxxx</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button id="btnMeasurementsCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                    <button id="btnMeasurementsSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


    <!----------------------------------------------------------------------------------------------- Modal codes -->
    <div class="modal fade" id="modalEditTaxaCodeTypes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTaxaCodeTypeHeader">xxxx <span id="forWhatName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-canvas">

                    <div id="taxa-code-type-rows">
                        <div class="form-group form-row mg-hide-element mg-row" id="taxa-code-type-row-1">

                            <div class="col-sm-7">
                                <label id="lblModalEditTaxaCodeTypes-TaxaCodeType-1">L</label>
                                <select id="slct-code-type-1" class="form-control">
                                    <?= $taxaCodeTypesOptions ?>
                                </select>
                            </div>

                            <div class="form-group form-row col-sm-4">
                                <label id="lblModalEditTaxaCodeTypes-TaxaCodeTypeCode-1">T</label>
                                <input type="text" id="code-1" class="form-control input-sm">
                                <div id="warning-code-type-1" class="text-danger"><small id="error-msg-code-type-1">Some test text here..</small></div>
                            </div>

                            <div class="col-sm-1">
                                <label id="lblModalDummy-1"><span class="mg-button-padding">..................</span></label>
                                <button id="btnRemoveRow-1" type="button" class="btn-sm btn-outline-danger mg-top-three mg-delete-code-type-row" title="Remove Row"><b> X </b></button>
                            </div>

                        </div>
                    </div>
                    <div class="text-danger" id="div-taxa-code-types-not-unique"><small id="taxa-code-types-not-unique">Warning not unique</small></div>
                    <br/>
                    <button id="btnTaxaCodeTypeAdd" type="button" class="btn-sm btn-primary">xxxx</button>

                </div>

                <div class="modal-footer">
                    <button id="btnTaxaCodeTypesCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                    <button id="btnTaxaCodeTypesSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


    <!--------------------------------------------------------------------------------------------- Modal ring types -->
    <div class="modal fade" id="modalRingTypes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalRingTypesHeader" class="modal-title">xxxx <span id="forWhatName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal-canvas" class="modal-body">

                    <div id="ring-type-rows">
                        <div class="form-group form-row mg-hide-element mg-row" id="ring-type-row-1">

                            <div class="col-sm-7">
                                <label id="lblRingType-1">L</label>
                                <select id="slct-ring-type-1" class="form-control">
                                    <?= $ringTypesOptions ?>
                                </select>
                            </div>

                            <div class="form-group form-row col-sm-2">
                                <label id="lblModalRingPriority-1">Prio</label>
                                <input id="inpPrioritet-1" type="text" maxlength="2" class="form-control input-sm">
                                <div id="div-warning-priority-1" class="text-danger"><small>Duck!</small></div>
                            </div>

                            <div class="col-sm-1">
                                <label id="lblModalDummy-1"><span class="mg-button-padding">..................</span></label>
                                <button id="btnRemoveRow-1" type="button" class="btn-sm btn-outline-danger mg-top-three mg-delete-ring-type-row" title="Remove Row"><b> X </b></button>
                            </div>

                        </div>
                    </div>
                    <div class="text-danger" id="div-ring-types-not-unique"><small id="ring-types-not-unique">Warning not unique</small></div>
                    <br/>
                    <button id="btnRingTypeAdd" type="button" class="btn-sm btn-primary">xxxx</button>

                </div>

                <div class="modal-footer">
                    <button id="btnRingTypesCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                    <button id="btnRingTypesSave" class="btn btn-primary">xxxx</button>
                </div>
            </div>
        </div>
    </div>




<?= getHTMLEnd();

