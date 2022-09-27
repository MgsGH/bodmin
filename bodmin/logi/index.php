<?php
session_start();

include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 8;
$errorPage = 'login\index.php';

$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: http://anka.localhost/login/index-empty.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
echo getHTMLHeader();
$appMenu->setSidaSelected(4);
echo $appMenu->getAsHTML();


?>

    <!-- main page -->
    <div class="container-fluid">

        <div class="row">

            <div class="col-2 mg-sidenav">
                <div id="datepicker">
                    <h2 id="hdrMain">XX</h2>
                </div>
                <br/>
                <button id="btnNew" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editPerson">

                </button>
                <hr>
                <small id="selectInfo"></small><br/>
                <div class="btn-block" id="editButtons">
                    <button id="btnChange" type="button" class="btn btn-sm btn-primary mg-top">XX</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">XX</button>
                </div>

                <br/>
                <div id="infoLabel" style="background-color: aliceblue" class="mg-text-center"><small></small></div>

                <div class="mg-hide-element">
                    <?= showPostVariablesByName() ?>
                </div>

                <br/>
                <br/>
            </div>

            <div class="col-6">
                <br/>
                Lodging info here in due course..

            </div>
        </div>
    </div>

<?= getHTMLEnd();
