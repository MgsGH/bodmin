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
$pageMetaData->setAdditionalJavaScriptFiles('personer.js');
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setSelect2(true);

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$module = 9;
$errorPage = 'index-empty.php';
$language = getRequestLanguage();
$info = "";

$postAction = "";
$pdo = getDataPDO();


if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $module, $pdo)) {
    header( "location: ./login/index-empty.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(9);
$personsData = getPersons($pdo);                        // dropdowns for selecting person in user-modal

echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected($module);
echo $appMenu->getAsHTML();
?>

<!-- main page -->
<div class="container-fluid">
    <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>
    <div class="row mg-white-smoke">

        <div class="col-2 mg-sidenav">
            <h2 id="hdrMain">xxxx</h2>
            <p>Ver 1.01</p>
            <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPerson">
                xxxx
            </button>
            <hr>
            <small id="infoLabel">xxxx</small><br/>
            <div class="btn-block" id="editButtons">
                <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">xxxx</button>
                <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">xxxx</button>
            </div>
            <div>
                <button id="btnEmail" type="button" class="btn btn-sm btn-primary mg-top">xxxx</button>
            </div>

            <br/>
            <div id="action-info" style="background-color: aliceblue" class="mg-text-center"><small><?= $info ?></small></div>

            <br/>
            <br/>
        </div>

        <div class="col-6">
            <div>
                <table id="data" class="table table-hover w-auto">
                    <thead>
                    <tr>
                       <th colspan="4">
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
                        <th id="tblHdrForNamn">xxxx</th>
                        <th id="tblHdrEfterNamn">xxxx</th>
                        <th id="tblHdrRefNamn">xxxx</th>
                        <th id="tblHdrSkapadNar">xxxx</th>
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
<div class="modal fade" id="modalEditPerson" tabindex="-1" role="dialog" aria-hidden="true">
        <div id="#modal-mode" class="mg-hide-element"></div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPersonHeader">xxxx</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form method="post" id="edit-box">

                        <div id="modalMainEditSection">
                            <div class="form-group">

                                <label for="inpForNamn" id="lblForNamn"></label>
                                <input type="text" id="inpForNamn" name="firstName" required class="form-control">
                                <div class="text-danger"><small id="warningForNamn"></small></div>
                                <br/>

                                <label for="inpLastNamn" id="lblLastName">xxxx</label>
                                <input type="text" id="inpLastName" name="lastName" required class="form-control">
                                <div class="text-danger"><small id="warningLastName"></small></div>
                                <br/>

                                <label for="inpRefNamn" id="lblRefNamn">xxxx</label>
                                <input type="text" id="inpRefNamn" name="authorName" class="form-control" size="50">
                                <br/>

                                <label id="lblWebSajt" for="inpWebSajt"></label>
                                <input type="url" id="inpWebSajt" name="webSite" class="form-control" size="50">
                                <br/>

                                <label for="inpWebText" id="lblWebText">xxxx</label>
                                <input type="text" id="inpWebText" name="webText" class="form-control">
                                <br/>

                                <label for="inpSignatureText" id="lblSignatureText">xxxx</label>
                                <input type="text" id="inpSignatureText" name="signatureText" class="form-control">
                                <div class="text-danger"><small id="warningSignatureText">TEST</small></div>
                                <br/>

                                <div id="passedSection">
                                    <input id="cbPassedAway" type="checkbox" name="published">
                                    <label id="lblPassedAway" for="cbPassedAway">xxAvlidenxx</label>
                                    <br/>
                                    <br/>
                                </div>

                                <p> <small id="modalEditPersonExtraInfo">xxxx</small></p>
                            </div>
                        </div>
                        <div id="modalMainDeleteSection"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnModalEditPersonCancel" type="button" class="btn btn-secondary" data-dismiss="modal">XXXX</button>
                    <button id="btnModalEditPersonSave" class="btn btn-primary" type="submit">XXXX</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal e-mail-->
<div class="modal fade" id="modalManageEmail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modalitle"><span id="modalManageEmailHeader">xxxx</span><span id="forVemNamn"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-canvas">

                <form method="post" id="form-edit-email">

                    <div id="email-list">
                        <div class="form-group row" id="email-1">
                            <label for="input-email-1" class="col-sm-2 col-form-label lblEmail">xxxx</label>
                            <div class="col-sm-5">
                                <div>
                                    <input type="email" class="form-control email" id="input-email-1" placeholder="Email" name="name-ebox-1">
                                </div>
                                <div class="text-danger"><small id="enamnWarningText-1"></small></div>
                            </div>
                            <div class="col-sm-5 mg-top" id="cb-section-1">
                                <input class="form-check-input" type="checkbox" value="" id="cb-email-1"> <!-- no name here on purpose -->
                                <label class="form-check-label formCheckLabel" for="cb-email-1">xxxx</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger"><small id="not-unique"></small></div>
                    <button id="btnModalManageEmailAddEmail" type="button" class="btn-sm btn-primary">xxxx</button>
                </form>
            </div>

            <div class="modal-footer">
                <button id="btnModalManageEmailCancel" type="button" class="btn btn-secondary" data-dismiss="modal"></button>
                <button id="btnModalManageEmailSave" class="btn btn-primary">xxxx</button>
            </div>
        </div>
    </div>
</div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());