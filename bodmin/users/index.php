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
$pageMetaData->setAdditionalJavaScriptFiles('users.js');

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 10;
$info = "";


$pdo = getDataPDO();
/*
if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ../login/index.php");
    exit;
}
*/
$permissionOptions = getPermissionOptionsAsHTML($pdo,  $_SESSION["preferredLanguageId"]); // dropdowns for selecting permission level in perm-modal
$modules = getModules($pdo, $_SESSION["preferredLanguageId"]); // create the module form dynamically - kind of - all boxes the same for all users.
$language = getRequestLanguage();

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(4);
echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
echo $appMenu->getAsHTML();


?>

<!-- main page -->
<div class="container-fluid">
    <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>
    <div class="row">

        <div class="col-sm-2 mg-sidenav positionX-relative">
            <div class="positionX-absolute topX-0 startX-5">
                <div class="mb-3">
                    <h2 id="hdrMain">main</h2>
                    <p>Ver. 1.0</p>
                </div>


                <button id="btnNew" type="button" class="btn btn-sm btn-primary">
                    xxxx
                </button>
                <br/>

                <hr>
                <small id="infoLabel"></small><br/>
                <div class="btn-block" id="editButtons">
                    <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top editButton">xxxx</button>
                    <button id="btnPasswordReset" type="button" class="btn btn-sm btn-primary mg-top editButton">xxxx</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top editButton">xxxx</button>
                </div>
                <div>
                    <button id="btnPermissions" type="button" class="btn btn-sm btn-primary mg-top editButton"></button>
                </div>

                <br/>
                <div id="action-info" style="background-color: aliceblue" class="mg-text-center"><small><?= $info ?></small></div>

                <div class="mg-hide-element">

                </div>
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
                        <th id="tblHdrUserNamn"></th>
                        <th id="tblHdrPersonNamn"></th>
                        <th id="tblHdrSignature"></th>
                        <th id="tblHdrAktiverad"></th>
                        <th id="tblHdrDefaultLanguage"></th>
                        <th id="tblHdrSkapadNar"></th>
                    </tr>
                    </thead>
                    <tbody id="dataRows">
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

    <!-- Modal edit/new/delete/pwd reset-->
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
                    <form method="post" id="edit-box">

                        <div id="user-section">
                            <!-- user name -->
                            <div class="form-group mb-3">
                                <label for="editUserName" id="lblUserName"></label><br/>
                                <input type="text" id="editUserName" name="userName" required class="form-control">
                                <div class="text-danger"><small id="userNameWarning" class="formWarning"></small></div>
                            </div>

                            <!-- person -->
                            <div class="form-group mb-3">
                                <label for="personSelect" id="lblPersonName"></label>
                                <div>
                                    <select id="personSelect" class="form-select" form="edit-box" name="personDropDown">
                                        <option value="0">----</option>
                                    </select>
                                </div>

                            </div>

                            <!-- language -->
                            <div class="form-group mb-3">
                                <label id="lblLanguage" for="languageSelect">xxxx</label><br/>
                                <select id="languageSelect" class="form-select" form="edit-box" name="languageDropDown">

                                </select>
                            </div>

                        </div>

                        <div id="pwd-section" class="mg-hide-element">
                            <hr>
                            <div class="form-group mb-3">
                                <label for="pwdone" id="lblPwdOne"></label><br/>
                                <input type="password" id="pwdone" name="pwdone" required class="form-control">
                                <div class="text-danger"><small class="pwdWarning formWarning"></small></div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="pwdtwo" id="lblPwdTwo"></label><br/>
                                <input type="password" id="pwdtwo" name="pwdtwo" required class="form-control top">
                                <div class="text-danger"><small class="pwdWarning formWarning"></small></div>
                            </div>
                            <hr>
                        </div>

                        <div id="activated-section">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="activated" name="activated">
                                <label for="activated" id="lblAktiverad" class="form-check-label"></label>
                            </div>
                        </div>
                        <div id="delete-section"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnModalMainCancel" type="button" class="btn btn-secondary closeModal" data-dismiss="modal">xxxx</button>
                    <button id="btnModalMainSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>

    <!----------------------------------------------------------------------------------------- Modal permissions-->
    <div class="modal fade" id="editPermissions" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="edit-title"><span id="modalPermissionsTitle">xxxx</span> <span id="editPermissionsFor"></span></h5>
                    <button type="button" class="close closeModalPermissions" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="edit-permissions">
                        <?= getPermissionsSectionAsHTML($modules, $permissionOptions) ?>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnPermCancel" type="button" class="btn btn-secondary closeModalPermissions" data-dismiss="modal">xxxx</button>
                    <button id="btnPermSave" class="btn btn-primary">xxxx</button>
                </div>
            </div>
        </div>
    </div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());