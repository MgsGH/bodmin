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
$t = time();
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/aahelpers/PhotoPopUp.js?dummy=' . $t);
$pageMetaData->setAdditionalJavaScriptFiles('bilder.js?dummy=' . $t);
$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);
$pageMetaData->setSelect2(true);
$pageMetaData->setCropper(true);

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$module = 7;
$errorPage = 'index.php';
$info = "";

$postAction = "";
$pdo = getDataPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $module, $pdo)) {
    header( "location: /bodmin/login/index.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(2);
$personsData = getPersons($pdo);                                    // dropdown for selecting person as photographer
$language = getRequestLanguage();
echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
echo $appMenu->getAsHTML();

?>

<!-- main page -->
<div class="container-fluid">
    <span id="lang" class="mg-hide-element"><?= getLang($language) ?></span>
    <span id="loggedInUserId" class="mg-hide-element"><?= getLoggedInUserId() ?></span>
    <div class="row">

        <div class="col-2 mg-sidenav">
            <h2 id="hdrMain"></h2>
            <br/>
            <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPhoto">
                
            </button>
            <hr>
            <div><small id="filter-intro">Antal bilder</small> <small id="antal-bilder"></small></div>
            <hr>
            <div id="info"></div>
            <small id="infoLabel"></small><br/>
            <div class="btn-block" id="editButtons">
                <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top edit-button"></button>
                <button id="btnShow" type="button" class="btn btn-sm btn-info mg-top edit-button"></button>
                <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top edit-button"></button>
            </div>

            <br/>
            <div id="actionInfo" style="background-color: aliceblue" class="mg-text-center"><small><span id="actionI"></span></small></div>

            <br/>
            <br/>
        </div>

        <div class="col-6 mg-white-smoke">
            <br/>
            <!-- Custom rounded search bars with input group -->
            <form>
                <div id="myPhotos" class="mg-hide-element">
                    <label for="cbxMyPhotosOnly">XXX</label>
                    <input id="cbxMyPhotosOnly" type="checkbox">
                </div>
                <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button id="button-addon2" type="submit" class="btn btn-link text-warning"><i class="fa fa-search"></i></button>
                        </div>
                        <input type="search" id="tblFilterBox" placeholder="" aria-describedby="button-addon2" class="mg-form-control border-0 bg-light">
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-center mt-3">
                <div class="btn-group text-center" role="group" aria-label="Pagination buttons">
                    <button type="button" class="btn btn-primary btn-sm back-button"><<</button>
                    <button type="button" class="btn btn-outline-primary disabled mg-noBorder btn-sm">&nbsp;&nbsp;Bläddra&nbsp;&nbsp;</button>
                    <button id="next-top" type="button" class="btn btn-primary btn-sm next-button">>></button>
                </div>
            </div>
            <div class="mt-3">
                <table id="data" class="table table-hover table-bordered mb-0">
                    <thead>
                    <tr>
                        <th id="tblHdrPhoto" class="text-center"></th>
                        <th id="tblHdrData" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody id="imageTableBody">
                    </tbody>
                </table>

            </div>
            <div class="d-flex justify-content-center mt-3 mb-5">
                <div class="btn-group text-center" role="group" aria-label="Pagination buttons">
                    <button type="button" class="btn btn-primary btn-sm back-button"><<</button>
                    <button type="button" class="btn btn-outline-primary disabled mg-noBorder btn-sm">&nbsp;&nbsp;Bläddra&nbsp;&nbsp;</button>
                    <button type="button" class="btn btn-primary btn-sm next-button">>></button>
                </div>
            </div>

        </div>
    </div>

</div>


    <?php
        require $path . "/aahelpers/popUpImage.php";
    ?>

    <!-- Modal show photo -->
    <div id="modalShowPhotoWindow" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalShowPhotoHeader" class="modal-title"></h5>
                    <button id="closeModalEditPhoto" type="button" class="close closeModalShowPhoto" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="showSection"></div>
                </div>
                <div class="modal-footer">
                    <button id="btnModalShowPhotoCancel" type="button" class="btn btn-secondary closeModalShowPhoto"></button>
                </div>
            </div>
        </div>
    </div>


<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());