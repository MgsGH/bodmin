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
$pageMetaData->setAdditionalJavaScriptFiles('publikationer.js');

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 7;
$errorPage = 'index-empty.php';
$info = "";

$postAction = "";
$pdo = getDataPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: ./login/index-empty.php");
    exit;
}



$loggedInUser = $_SESSION['userId'];
checkIfLoggedIn($loggedInUser, $pageMetaData);  // stops execution if not logged in
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

        <div class="col-2 mg-sidenav">
            <h2 id="hdrMain">xxxx</h2>
            <br/>
            <div id="controlPanel">
                <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPhoto">
                    xxxx
                </button>
                <hr>
                <small id="infoPanel">xxxx</small><br/>
                <div class="btn-block" id="editButtons">
                    <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">xxxx</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">xxxx</button>
                    <button id="btnShow" type="button" class="btn btn-sm btn-info mg-top">xxxx</button>
                </div>
            </div>
        </div>

        <div class="col-6 mg-white">

            <div class="table-wrapper-scroll-y my-custom-scrollbar mg-height-600">
                <table id="data" class="table table-hover table-bordered w-auto mb-0">
                    <thead>
                        <tr>
                            <th colspan="1">
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
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Modal edit/new/delete -->
<div id="editMainTable" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="#modal-mode" class="mg-hide-element"></div>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalHeader" class="modal-title">xxxx</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="editForm" action="handleData.php" method="post" enctype="multipart/form-data">
                    <div id="editSection">
                        <div class="form-group">

                            <label id="lblTitle" for="inpTitle">xxxx</label>
                            <input id="inpTitle" type="text" name="plats" class="form-control" size="150">
                            <div class="text-danger"><small id="titleWarningText"></small></div>
                            <br/>

                            <label id="lblAuthor" for="inpAuthor"></label>
                            <input id="inpAuthor" name="author" type="text" required class="form-control">
                            <div class="text-danger"><small id="authorWarningText"></small></div>
                            <br/>

                            <label id="lblJournal" for="inpJournal"></label>
                            <input id="inpJournal" name="journal" type="text" required class="form-control">
                            <div class="text-danger"><small id="authorWarningText"></small></div>
                            <br/>

                            <label id="lblYear" for="inpYear">xxxx</label>
                            <input id="inpYear" name="year" type="number" min="1950" step="1" value="2020" class="form-control">
                            <div class="text-danger"><small id="yearWarningText"></small></div>
                            <br/>

                            <label id="lblTaxa" for="slctTaxa">xxxx</label>
                            <select id="slctTaxa" class="form-control">
                            </select>
                            <div>
                                <ul id="selectedTaxa" class="mgUlInline">
                                </ul>
                            </div>
                            <div class="text-danger"><small id="selectedTaxaWarningText"></small></div>
                            <br/>

                            <label id="lblKeywords" for="slctKeywords" >xxxx</label>
                            <select id="slctKeywords" class="form-control">
                            </select>
                            <div class="text-danger"><small id="selectedKeywordsWarningText"></small></div>
                            <div>
                                <ul id="selectedKeywords" class="mgUlInline">
                                </ul>
                            </div>
                            <br/>

                            <input id="cbPublished" type="checkbox" name="published">
                            <label id="lblPublished" for="cbPublished"></label>
                            <br/>

                        </div>
                    </div>
                    <div id="deleteSection"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCancelMainModal" type="button" class="btn btn-secondary" data-dismiss="modal">XXXX</button>
                <button id="btnSaveMainModal" class="btn btn-primary" type="submit">XXXX</button>
            </div>
        </div>
    </div>
</div>

<?php

echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());