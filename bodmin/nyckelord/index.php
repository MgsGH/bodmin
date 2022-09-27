<?php
session_start();

include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';


//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 13;
$errorPage = 'index-empty.php';

$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ../login/index-empty.php");
    exit;
}


$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($page-1);
$languageOptions = getLanguageOptionsAsHTML($pdo, $_SESSION["preferredLanguageId"]); // for dropdown in translate modal

echo getHTMLHeader();
echo $appMenu->getAsHTML();

?>

<!-- main page -->
<div class="container-fluid">

    <div class="row">

        <div class="col-sm-2 mg-sidenav">
            <h2 id="hdrMain">hdrMain</h2>
            <br/>
            <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPerson">
                btnNew
            </button>
            <hr>
            <small id="infoPanel">
                <span id="infoPanelIntro"></span> <strong><span id="selectedRowIdentifier"></span></strong>
            </small><br/>
            <div class="btn-block" id="editButtons">
                <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">
                    btnEdit
                </button>
                <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">
                    btnDelete
                </button>
            </div>
            <div>
                <button id="btnTranslations" type="button" class="btn btn-sm btn-primary mg-top">
                    btnTranslations
                </button>
            </div>
            <br/>
            <div id="actionInfo" style="background-color: aliceblue" class="mg-text-center"><small><span id="actionI"></span></small></div>
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
            <div id="dataTableSection">
                <table id="data" class="table table-hover w-auto">
                    <thead>
                        <tr>
                            <th id="tblHdrCategory">Xxxx</th>
                            <th id="tblHdrKeyword">Xxxx</th>
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
<div class="modal fade" id="editMain" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="#modal-mode" class="mg-hide-element"></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMainHeader">XXXX</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="formMainModal">
                    <div id="modalMainEditSection">
                        <div class="form-group">

                            <label for="ddCategory" id="lblddCategory">xxxx</label>
                            <select id="ddCategory" name="category" required class="form-control">
                            </select>
                            <div class="text-danger"><small id="WarningCategory"></small></div>
                            <br/>

                            <label for="inpDescription" id="lblInpDescription">xxxx</label>
                                <input type="text" id="inpDescription" name="description" required class="form-control">
                            <div class="text-danger"><small id="warningInpDescription"></small></div>

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
                <h5 class="modal-title"><span id="modalTranslationsHeader">xxxx</span> <span id="forVemNamn"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-canvas">

                <form>

                    <div id="item-list-item">
                        <div class="form-group row" id="item-1">

                            <div class="col-sm-3">
                                <select id="id-select-item-1" class="form-control" name="name-select-item-1">
                                    <?= $languageOptions ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="id-input-item-1" placeholder="Ange översättning här" name="name-input-box-1">
                                <div class="text-danger"><small id="warning-item-1">Test här</small></div>
                            </div>

                            <div class="col-sm-5 mg-top">
                                <input class="form-check-input" type="checkbox" value="" id="cb-item-1">
                                <label class="formCheckLabel" for="cb-item-1">
                                    xxxx
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="text-danger"><small id="not-unique">Some test text here..</small></div>
                    <br/>
                    <button id="btnTranslationAdd" type="button" class="btn-sm btn-primary">xxxx</button>
                </form>
            </div>

            <div class="modal-footer">
                <button id="btnTranslationsCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                <button id="btnTranslationsSave" class="btn btn-primary" type="submit">xxxx</button>
            </div>
        </div>
    </div>
</div>


<?= getHTMLEnd();