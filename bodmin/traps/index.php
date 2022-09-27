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
$info = "";

$postAction = "";
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
            <p>Ver 1.0</p>

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
            <div id="action-info" style="background-color: aliceblue" class="mg-text-center"><small><?= $info ?></small></div>
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
                            <th id="thName">xxxx</th>
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
                                <label class="control-label" for="inpName" id="lblInpName"></label>
                                <input type="text" id="inpName" required class="form-control input-sm" autofocus="autofocus">
                                <div class="text-alert"><small id="warningInpName"></small></div>
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


