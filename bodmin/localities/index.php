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
$pageMetaData->setAdditionalJavaScriptFiles('localities.js');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setSelect2(true);


//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$module = 14;
$errorPage = 'index-empty.php';
$info = "";

$postAction = "";
$language = getRequestLanguage();
$pdo = getDataPDO();
$languageOptions = getLanguageOptionsAsHTML($pdo, $language);


if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $module, $pdo)) {
    header( "location: ./login/index-empty.php");
    exit;
}


$language = getRequestLanguage();

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($module);
echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
echo $appMenu->getAsHTML();

?>

    <!-- main page -->
    <div class="container-fluid">
        <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>

        <div class="row">
            <div class="col-sm-2 mg-sidenav">
                <h3 id="hdrMain">xxxx</h3>
                <p id="version"></p>

                <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPerson">
                    xxxx
                </button>
                <hr>
                <small id="infoLabel">xxxx</small> <small id="infoSelectedRecord" class="mg-bold"></small><br/>
                <small id="infoPermissions">info permissions</small>

                <div class="btn-block" id="editButtons">
                    <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top editButton">Ändra</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top editButton">Tag bort</button>
                </div>
                <div>
                    <button id="btnTranslations" type="button" class="btn btn-sm btn-primary mg-top editButton">Översättningar (Namn)</button>
                </div>

                <br/>
                <br/>
            </div>
            <div class="col-5 mg-white-smoke">

                <div>
                    <table id="data" class="table table-hover w-auto">
                        <thead>
                            <tr>
                                <td colspan="3">
                                    <!-- Custom rounded search bars with input group -->
                                    <form>
                                        <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-1">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
                                                </div>

                                                <input type="search" id="tblFilterBox" placeholder="xxxx" aria-describedby="button-addon2" class="mg-form-control border-0 bg-light">
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th id="thName">xxxx</th>
                                <th id="thStandardized">xxxx</th>
                                <th id="thMonitoring">xxxx</th>

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
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="edit-box">

                        <div id="modalMainEditSection">

                            <div class="form-group-sm">
                                <label class="control-label" for="inpName" id="lblInpName"></label>
                                <input type="text" id="inpName" required class="form-control input-sm" autofocus="autofocus">
                                <div class="text-alert"><small id="warningInpName"></small></div>
                            </div>

                            <div class="form-check form-group-sm">
                                <input type="checkbox" id="cbStandardized" class="form-check-input ">
                                <label class="control-label" for="cbStandardized" id="lblStandardized">label</label>
                            </div>

                            <div class="form-check form-group-sm">
                                <input type="checkbox" id="cbMonitoring" class="form-check-input ">
                                <label class="control-label" for="cbMonitoring" id="lblMonitoring">label</label>
                            </div>

                        </div>
                        <div id="modalMainDeleteSection"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnModalMainCancel" type="button" class="btn btn-secondary closeModal" data-dismiss="modal">xxxx</button>
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
                    <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="modal-canvas">

                    <form method="post" id="form-edit-items">

                        <div class="form-group row mg-hide-element translationRow" id="baseRow">

                            <div class="col-sm-3">
                                <select id="id-select-item-x" class="form-select" name="name-select-item-x">
                                    <?= $languageOptions ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control dataBox" id="id-input-item-x" placeholder="Ange översättning här" name="name-input-box-x">
                                <div class="text-danger"><small id="warning-item-x">Test här</small></div>
                            </div>

                            <div class="col-sm-5" title="Remove translation" id="div-remove-button-container-x">
                                <button type="button" class="btn btn-outline-warning mb-1 deleteButton" id="button-remove-row-x"><strong>x</strong></button>
                            </div>

                        </div>

                        <div class="item-list-item" id="itemRows">
                        </div>
                        <div class="text-danger"><small id="not-unique"></small></div>
                        <br/>
                        <button id="btnTranslationAdd" type="button" class="btn-sm btn-primary">xxxx</button>

                    </form>
                </div>

                <div class="modal-footer">
                    <button id="btnTranslationsCancel" class="btn btn-secondary closeModal" data-dismiss="modal">xxxx</button>
                    <button id="btnTranslationsSave" class="btn btn-primary">xxxx</button>
                </div>
            </div>
        </div>
    </div>

<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());

