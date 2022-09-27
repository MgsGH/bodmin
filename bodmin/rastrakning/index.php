<?php
session_start();

include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 3;
$errorPage = 'index-empty.php';
$info = "";

$postAction = "";
$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ./login/index-empty.php");
    exit;
}


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $postAction = trim($_POST["action"]);

    if ($postAction === 'edit') {
        $publish = 0;
        if (isset($_POST['done'])){
            $publish = 1;
        }
        updateRastRakningVecka($pdo, $_POST['main-item-year'], $_POST['main-item-vecka'], $_SESSION['userId'], $publish, $_POST['name-main-item-id']);
        $recordInfo = $_POST["main-item-year"] . '-' . $_POST["main-item-vecka"] ;
        $info = '<span id="lblWhen">Week</span>' . ' '  . $recordInfo . '<span id="what"></span>' . '.<br/>' . '<p id="webOk"></p>';
    }

    if ($postAction === 'add') {
        writeRastRakningVecka($pdo, $_POST['main-item-year'], $_POST['main-item-vecka'], $_SESSION['userId']);
        $recordInfo = $_POST["main-item-year"] . '-' . $_POST["main-item-vecka"] ;
        $info = '<span id="lblWhen">Week</span>' . ' '  . $recordInfo . '<span id="what"></span>' . '.<br/>' . '<p id="webOk"></p>';
    }

    if ($postAction === 'delete') {
        deleteRastRakningVecka($pdo, $_POST['name-main-item-id']);
        $recordInfo = $_POST["main-item-year"] . '-' . $_POST["main-item-vecka"] ;
        $info = '<span id="lblWhen">Week</span>' . ' '  . $recordInfo . '<span id="what"></span>' . '.<br/>' . '<p id="webOk"></p>';
    }

}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($page-1);
$data = getRastrakningsVeckor($pdo);          // main table
$personerData = getAllActivePersons($pdo);    // as observers

echo getHTMLHeader();
echo $appMenu->getAsHTML();

?>

    <!-- main page -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-2 mg-sidenav">
                <h2 id="hdrMain"></h2>
                <br/>
                <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit-main-table">

                </button>
                <hr>
                <small id="infoLabel"></small><br/>
                <div class="btn-block" id="editButtons">
                    <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">xxxx</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">xxxx</button>
                </div>
                <hr>
                <small id="obsInfo"><strong></strong></small><br/>
                <div class="xform-group row mg-left-x">

                    <div class="mg-top">
                        <select class="form-control custom-select custom-select-sm" id="select-locality-drop-down">
                        </select>
                    </div>

                    <div class="mg-left-x">
                        <button id="btnEditSubItems" type="button" class="btn btn-sm btn-primary mg-top"></button>
                    </div>

                </div>

                <br/>
                <div id="action-info" style="background-color: aliceblue" class="mg-text-center"><small></small></div>

                <div class="mg-hide-element">
                    <?=  showPostVariablesByName()  ?>
                </div>

                <br/>
                <br/>
            </div>

            <div class="col-4">
                <br/>
                <div>

                    <!-- Custom rounded search bars with input group -->
                    <form>
                        <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4 form-group row">
                            <div class="input-group-prepend col-xs-1">
                                <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="col-xs-2">
                                <input id="tableSearchBox1" type="search" placeholder="" class="mg-form-control border-0 bg-light mg-top">
                            </div>
                            <div class="col-xs-2">
                                <input id="tableSearchBox2" type="search" placeholder="" class="mg-form-control border-0 bg-light mg-top">
                            </div>

                        </div>
                    </form>
                </div>
                <div id="loaderDiv" class="text-center"><img src="../aahelpers/img/loading/ajax-loader.gif" alt="wait"></div>

                <div id="rrTable" class="mg-hide-element"><?= getRastRakningTableAsHTML($data); ?></div>
            </div>
        </div>

    </div>

    <!-- Modal edit/new/delete -->
    <div class="modal fade" id="modal-edit-main-table" tabindex="-1" role="dialog" aria-hidden="true">
        <div id="#modal-mode" class="mg-hide-element"></div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Ny rasträkningsvecka</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form-edit-main-table">
                        <input type="hidden" id="action" name="action" value="add">
                        <input type="hidden" id="main-item-id" name="name-main-item-id" value="">
                        <input type="hidden" id="main-item-recInfo" name="recordInfo" value="">
                        <div id="main-edit-section">
                            <div class="form-group">
                                <label id="lblAr" for="main-item-year"></label>
                                <input type="text" maxlength="4" id="main-item-year" name="main-item-year" required class="form-control">
                                <br/>
                                <div class="text-danger"><small id="main-item-year-WarningText"></small></div>
                                <label id="lblVecka" for="main-item-vecka"></label>
                                    <input type="text" maxlength="2" id="main-item-vecka" name="main-item-vecka" required class="form-control">
                                <br/>
                                <div class="text-danger"><small id="main-item-vecka-WarningText"></small></div>
                                <br/>
                                <div class="custom-control custom-checkbox" id="done-section">
                                    <input type="checkbox" class="custom-control-input" name="done" id="main-item-done">
                                    <label class="custom-control-label" for="main-item-done" id="lblPublished"></label>
                                </div><br/>
                                <br/>
                                <div class="text-danger"><small id="main-item-done-WarningText">nnn</small></div>
                            </div>
                        </div>
                        <div id="delete-section"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnCancel" type="button" class="btn btn-secondary" data-dismiss="modal"></button>
                    <button id="btnSaveEditForm" class="btn btn-primary" type="submit"></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal sub items -->
    <div class="modal fade" id="modal-edit-sub-items" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modalDataTitle" id="edit-email-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-header">
                    <h5><span id="hdrIntro"></span> <span id="main-item-name">2015-04</span>, <span id="main-item-lokal-namn">Kanalen</span></h5>

                </div>
                <div class="modal-body" id="modal-canvas">

                    <form method="post" id="form-edit-items">
                        <input type="hidden" id="item-action" name="action" value="maintain-items">
                        <input type="hidden" id="id-items-name" name="name-items-name" value="">
                        <input type="hidden" id="id-items-owner-id" name="name-items-owner-id" value="">

                        <!-- Head ---------------------------------------------------------------------------------->
                        <div class="form-group row mg-left-x">
                            <div class="mg-top">
                                <label for="input-date" id="lblDate"></label>
                            </div>
                            <div class="mg-left-x">
                                <input type="date" class="form-control form-control-sm" id="input-date" name="select-box-date" value="<?= getMeTheDate() ?>">
                            </div>
                            <div class="mg-left-x"></div>
                            <div class="mg-left-x"></div>
                            <div class="mg-top">
                                <label for="selectBoxObservator" id="lblObserver"></label>
                            </div>
                            <div class="mg-left-x">
                                <select class="form-control custom-select custom-select-sm" id="select-box-observator">
                                    <?= getOptionsAsHTML($personerData, $_SESSION['personId']); ?>
                                </select>
                            </div>
                        </div>
                        <!-- /Head ---------------------------------------------------------------------------------->
                        <!-- table header kind of -->
                        <div class="form-group row" id="item-x">
                            <div class="col-sm-3" id="hdrArt">
                            </div>
                            <div class="col-sm-4" id="hdrAntal">
                            </div>
                            <div class="col-sm-5" id="hdrAverage">
                            </div>
                        </div>

                        <div id="item-list-item">
                            <!-- template section used by Jquery to clone new taxa sections -->
                            <div class="form-group row mg-hide-element" id="taxa-template-item">
                                <div class="col-sm-3 mg-top" id="taxa-name-0">
                                    Bergand x
                                </div>
                                <div>
                                    <input type="number" class="form-control form-control-sm col-xs-2" id="id-input-item-0" name="antal-input-box-0">
                                </div>
                                <div class="col-sm-5">
                                    <span id="average-0" class="mg-top">123/45</span>
                                </div>
                                <div class="mg-hide-element" id="record-id-0">0</div>
                            </div>
                        </div>
                        <hr>
                        <!------------------------ --->
                        <div class="form-group row" id="add-item">
                            <div class="col-sm-6">
                                <select id="select-taxa-drop-down" class="form-control custom-select custom-select-sm">
                                    <option value="0" selected></option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <button id="btnAddTaxa" type="button" class="btn-sm btn-primary"></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnTaxaDataCancel" type="button" class="btn btn-secondary" data-dismiss="modal"></button>
                    <button id="btnTaxaDataSave" class="btn btn-primary" type="submit">Xxxxx</button>
                </div>
            </div>
        </div>
    </div>

    btnAddTaxa
    btnTaxaDataCancel
    btnTaxaDataSave

<?= getHTMLEnd();