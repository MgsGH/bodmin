<?php
session_start();

$path = '/home/hkghbhzh/public_html';
$lookinto = 'something.' . $_SERVER['SERVER_NAME'];
$developmentEnvironment = strpos($lookinto , 'fbo.localhost');

if ($developmentEnvironment){
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
$pageMetaData->setAdditionalJavaScriptFiles('weather.js');

//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$module = 21;
$errorPage = 'bodmin/login/';

$pdo = getDataPDO();


if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $module, $pdo)) {
    header( "location: https://falsterbofagelstation.se/bodmin/login/");
    exit;
}


$language = getRequestLanguage();

$appMenu = new AppMenu($pdo, $_SESSION['userId']);
$appMenu->setSidaSelected(7);
echo getHtmlHead('', $pageMetaData, $language);
echo getLoggedInHeader();
echo $appMenu->getAsHTML();

?>

    <!-- main page -->
    <div class="container-fluid">
        <span id="coolLevel" class="mg-hide-element"><?= $_SESSION['userId'] ?></span>

        <div class="row">

            <div class="mg-sidenav">
                <h2 id="hdrMain">XX </h2>
                <p>Ver. 1.0.1</p>
                <div id="datepicker">

                </div>
                <small>
                    <span id="selectedIntro">Selected:</span> <span id="selectedDate" class="mg-bold">2010-50-41</span><span id="introTime"></span><span id="selectedTime" class="mg-bold">2010-05-14</span>
                </small>
                <br/>
                <hr>
                <button id="btnNew" type="button" class="btn btn-sm btn-primary"></button>
                <br/>

                <div class="btn-block" id="editButtons">
                    <button id="btnChange" type="button" class="btn btn-sm btn-primary mg-top">XX</button>
                    <button id="btnDelete" type="button" class="btn btn-sm btn-danger mg-top">XX</button>
                </div>

                <br/>

                <div id="infoLabel" style="background-color: aliceblue" class="mg-text-center"><small></small></div>
                <div id="help" class="pt-4 pb-5 mg-hide-element">

                </div>
                <br/>
                <br/>
            </div>

            <div class="col-8 mg-white-smoke">
                <br/>

                <div>
                    <table id="data" class="table table-hover w-auto">
                        <thead>
                        <tr>
                            <th id="thTime">xxxx</th>
                            <th id="thClouds">xxxx</th>
                            <th id="thWindDirection">xxxx</th>
                            <th id="thWindForce">xxxx</th>
                            <th id="thTemp">xxxx</th>
                            <th id="thVisibility">xxxx</th>
                            <th id="thPressure">xxxx</th>
                            <th id="thComment">xxxx</th>
                            <th id="thCreated">xxxx</th>
                        </tr>
                        </thead>
                        <tbody id="weatherTableBody">
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

                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label id="lblSlctTime" for="slctTime">Tid</label>
                                </div>
                                <div class="col col-md-4">
                                    <select id="slctTime" class="form-select">
                                    </select>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10 mg-top-three"><small id="warningSelectTime">warning</small></div>
                            </div>


                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label id="lblSlctClouds" for="slctClouds">Cloudiness</label>
                                </div>
                                <div class="col col-md-4">
                                    <select id="slctClouds" class="form-select">
                                    </select>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningTextSelectedCloudsWarningText">warning</small></div>
                            </div>

                            <div class="row">
                                <div class="col col-md-4 mg-top-seven">
                                    <label id="lblSlctWindDirection" for="slctWindDirection">Wind direction</label>
                                </div>
                                <div class="col col-md-4">
                                    <select id="slctWindDirection" class="form-select">
                                    </select>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningTextSelectedWindDirection">warning</small></div>
                            </div>

                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label class="control-label" for="inpVindStyrka" id="lblInpVindStyrka">Vindstyrka</label>
                                </div>
                                <div class="col col-md-4">
                                    <input type="text" id="inpVindStyrka" required class="form-control input-sm" placeholder="0 to 45">
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningInpVindStyrka">warning</small></div>
                            </div>

                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label class="control-label" for="inpTemperatur" id="lblInpTemperatur">Temperatur</label>
                                </div>
                                <div class="col col-md-4">
                                    <input type="text" id="inpTemperatur" required class="form-control input-sm" placeholder="-25 to 35°C">
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningInpTemperatur">warning</small></div>
                            </div>

                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label class="control-label" for="inpVisibility" id="lblInpVisibility">Sikt (km) </label>
                                </div>
                                <div class="col col-md-4">
                                    <input type="text" id="inpVisibility" required class="form-control input-sm" placeholder="0 to 99">
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningInpVisibility">warning</small></div>
                            </div>

                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label class="control-label" for="inpTryck" id="lblInpTryck">Tryck</label>
                                </div>
                                <div class="col col-md-4">
                                    <input type="text" id="inpTryck" required class="form-control input-sm" placeholder="950 to 1080">
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningInpTryck">warning</small></div>
                            </div>

                            <div class="row">
                                <div class="col col-md-4 mt-1">
                                    <label id="lblSlctComment" for="slctComment">Väder</label>
                                </div>
                                <div class="col col-md-7">
                                    <select id="slctComment" class="form-select">
                                    </select>
                                    <div class="col col-md-12 mt-1">
                                        <ul id="selectedKeywords" class="mgUlInline">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="text-danger col col-md-10"><small id="warningTextSelectedComment">warning</small></div>

                                <br/>
                            </div>

                        </div>
                        <div id="modalMainDeleteSection"></div>
                        <div id="modalWaitSection"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnModalMainCancel" type="button" class="btn btn-secondary closeModal" data-dismiss="modal">xxxx</button>
                    <button id="btnModalMainSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


<?= getHTMLEndWithJS($pageMetaData->getJavaScriptSection());
