<?php
session_start();

include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';


//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 14;
$errorPage = 'index-empty.php';


$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ./login/index-empty.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($page-1);
$languageOptions = getLanguageOptionsAsHTML($pdo, $_SESSION["preferredLanguageId"]); // for dropdown in modal

echo getHTMLHeader();
echo $appMenu->getAsHTML();

?>

    <!-- main page -->
    <div class="container-fluid">

    <div class="row">

        <div class="col-sm-2 mg-sidenav">
            <h3 id="hdrMain">xxxx</h3>
            <p>Ver 1.1</p>

            <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPerson">
                xxxx
            </button>
            <hr>
            <small id="infoLabel">xxxx</small><br/>
            <div class="btn-block" id="editButtons">
                <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">Ändra</button>
                <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">Tag bort</button>
            </div>
            <div>
                <button id="btnTranslations" type="button" class="btn btn-sm btn-primary mg-top">Översättningar (Namn)</button>
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
                        <label for="tblFilterBox" class="sr-only">Filter table here</label>
                        <input type="search" id="tblFilterBox" placeholder="xxxx" aria-describedby="button-addon2" class="mg-form-control border-0 bg-light">
                    </div>
                </div>
            </form>
            <div>
                <table id="data" class="table table-hover w-auto">
                    <thead>
                        <tr>
                            <th id="thName">xxxx</th>
                            <th id="thStandard">xxxx</th>
                            <th id="thDisplaySpecified">xxxx</th>
                            <th id="thCommonValidation">xxxx</th>
                            <th id="thSortOrder">xxxx</th>
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

                            <div class="form-group-sm col-sm-10 pb-2">
                                <label class="control-label" for="inpName" id="lblInpName">Test</label>
                                <input type="text" id="inpName" required autofocus class="form-control input-sm">
                                <div class="text-alert"><small id="warning-inpname"></small></div>
                            </div>

                            <div id="sectionSortOrder" class="form-group-sm col-sm mb-4">
                                <label class="control-label" for="inpSortOrder" id="labelSortOrder">Sortorder</label>
                                <input type="text" id="inpSortOrder" required class="form-control input-sm col-sm-2" width="2">
                                <div class="text-danger col-sm-6"><small id="warning-sortorder"></small></div>
                            </div>

                            <div class="form-check pb-2">
                                <input type="checkbox" id="checkBoxStandard">
                                <label for="checkBoxStandard" id="labelCheckBoxStandard">Standard</label>
                            </div>

                            <div id="sectionStandardMatt" class="mg-hide-element">

                                <div class="form-check pb-2">
                                    <input type="checkbox" id="checkBoxCommonDisplay">
                                    <label for="checkBoxCommonDisplay" id="labelCheckBoxValByTaxon">Validation data by taxon</label>
                                </div>

                                <div id="sectionMeasurementData" class="mg-hide-element form-check pb-2">

                                    <div class="form-group-sm pb-2">
                                        <label id="labelSex" for="slctSex">Sex</label>
                                        <select id="slctSex" class="form-control input-sm col-sm-5">
                                        </select>
                                    </div>

                                    <div class="form-group-sm pb-2">
                                        <label id="labelAge" for="slctAge">Age</label>
                                        <select id="slctAge" class="form-control input-sm col-sm-6" title="Decide ages eligible for the setting">
                                        </select>
                                    </div>

                                    <div class="form-group-sm pb-2">
                                        <label id="labelMonths" for="slctMonth">Months</label><br/>
                                        <select id="slctMonth" class="form-control input-sm col-sm-8" multiple>
                                        </select>
                                        <div class="text-danger col-sm-6"><small id="warning-months"></small></div>
                                    </div>
                                </div>

                                <div class="form-check pb-2 pt-2">
                                    <input type="checkbox" id="checkBoxCommonValidation">
                                    <label for="checkBoxCommonValidation" id="labelCheckBoxCommonValidation">Common validation</label>
                                </div>

                                <div id="sectionMeasurementValidationData" class="mg-hide-element form-check">

                                    <div class="form-group-sm pb-2">
                                        <label id="labelMin" for="inpMin">Min</label>
                                        <input class="form-control mg-min col-sm-2" id="inpMin" placeholder="Min">
                                        <div class="text-danger varning col-sm-8"><small id="warning-inpMin">Test här</small></div>
                                    </div>

                                    <div class="form-group-sm pb-2">
                                        <label id="labelMax" for="inpMax">Max</label>
                                        <input class="form-control mg-min col-sm-2" id="inpMax" placeholder="Max">
                                        <div class="text-danger varning col-sm-8"><small id="warning-inpMax">Test här</small></div>
                                    </div>
                                </div>


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

    <!-- Modal translations -->
    <div class="modal fade" id="modalEditTranslation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTranslationsHeader">xxxx <span id="forWhatName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div id="translation-rows">
                        <div class="form-group form-row mg-hide-element mg-row" id="translation-row-1">

                            <div class="col-sm-2">
                                <label id="lblModalLanguage-1" for="slct-lang-1">L</label>
                                <select id="slct-lang-1" class="form-control" name="slct-lang-1">
                                    <?= $languageOptions ?>
                                </select>
                            </div>

                            <div class="form-group form-row col-sm-9">
                                <label id="lblModalTranslation-1" for="translation-1">T</label>
                                <input type="text" id="translation-1" class="form-control input-sm" name="inp-translation-1">
                                <div id="warningx-1" class="text-danger"><small id="error-msg-1">Some test text here..</small></div>
                            </div>

                            <div class="col-sm-1">
                                <label id="lblModalDummy-1"><span class="mg-button-padding">..................</span></label>
                                <button id="btnRemoveRow-1" type="button" class="btn-sm btn-outline-danger mg-top-three" title="Remove Row"><b> X </b></button>
                            </div>

                        </div>
                    </div>
                    <div class="text-danger" id="div-not-unique"><small id="languages-not-unique">Some test text here..</small></div>
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

<?= getHTMLEnd();


