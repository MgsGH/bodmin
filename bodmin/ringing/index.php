<?php
session_start();

include_once '../aahelpers/functions.php';
include_once '../aahelpers/db.php';
include_once '../aahelpers/AppMenu.php';


//page configuration
$allowedComingFromPage = array("anywhere");
$permissionRequired = 3;
$page = 2;

$pdo = getPDO();

if (!checkPermissionsOkForModule($allowedComingFromPage, $permissionRequired, $page, $pdo)) {
    header( "location: http://anka.localhost/login/index-empty.php");
    exit;
}

$appMenu = new AppMenu($pdo, $_SESSION['userId']);

logSessionData();

$langId = $_SESSION["preferredLanguageId"];
$locationOptions = getLocationsOptionsAsHTML($pdo, $langId); // options when selecting ringing locations
$trappingOptions = getTrappingMethodsOptionsAsHTML($pdo, $langId); //
$ringsOptions = getRingTypesOptionsAsHTML($pdo, $langId); //
$measurementOptions = getOptionalMeasurementsOptionsAsHTML($pdo, $langId);

echo getHTMLHeader();
$appMenu->setSidaSelected($page-1);
echo $appMenu->getAsHTML();


?>
    <!-- main page -->
    <div class="container-fluid">

        <div class="row">

            <div class="mg-sidenav col-3">

                <h2 id="hdrMain">XX</h2>
                <p>Ver. 0</p>
                <label for="ddLocations" class="mg-hide-element">Not shown</label>
                <select id="ddLocations" class="form-control mg-w-275" name="dropDownLocation">
                    <?= $locationOptions ?>
                </select>
                <div id="datepicker" class="mg-top">

                </div>
                <br/>
                <small id="selectedLanguageAndDate"><span id="selectedIntro">Selected:</span> <span id="selLocation" class="mg-bold"></span> <span id="selDate" class="mg-bold">2010-50-41</span></small>
                <hr/>
                <small id="selectStatusHeader" class="mg-bold">Status</small><br/>
                <small id="selectStatusBody">No data, date/place not started.</small>

                <hr>
                <button id="btnRingCheck" type="button" class="btn btn-sm btn-primary mg-top">Check rings</button>
                <button id="btnEdit" type="button" class="btn btn-sm btn-primary mg-top">XX</button>&nbsp;<button id="btnFinish" type="button" class="btn btn-sm btn-primary mg-top">Finish the place and date</button>&nbsp;
                <br/>
                <button id="btnEffort" type="button" class="btn btn-sm btn-secondary mg-top">Effort</button>


                <br/>
                <br/>
                <br/>
            </div>
            <div class="col-9" id="spinner-area">
                <div><br/><br/><br/><br/><img src="../aahelpers/img/loading/ajax-loader.gif" alt="loading" class="mx-auto d-block"><br/><br/></div>
            </div>

            <div class="col-9" id="working-area">
                <div id="dataEntrySection">

                        <br/>
                        <h4 id="dataEntrySectionHeader">----</h4>

                    <div id="tabs-min">
                        <ul>
                            <li><a href="#dataInputOneByOne" id="labelDataTabOneByOne">---</a></li>
                            <li><a href="#dataInputBatches" id="labelDataTabBatches">---</a></li>
                            <li><a href="#controlsInput" id="labelDataTabReTraps">---</a></li>
                        </ul>


                        <div id="dataInputOneByOne">

                            <div id="one-by-one-form" class="mg-bordered">

                                <div class="form-row">

                                    <div class="form-check form-group col-md-1">
                                        <label for="cbType" id="lblCheckBoxSystematic">Systematic</label><br/>
                                        <input type="checkbox" id="cbSystematic" class="form-check-input mg-pad-left-xx" placeholder="Standardized">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="ddTrappingMethod" id="lblTrappingMethod">Method</label>
                                        <select id="ddTrappingMethod" class="form-control" name="ddTrappingMethod">
                                            <?= $trappingOptions ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-8">
                                        <label for="inpObservation" id="lblOther">Other</label>
                                        <input type="text" id="inpObservation" class="form-control" placeholder="Comment, free text">
                                    </div>

                                </div>


                                <div class="row" id="secondRowAll">

                                    <div class="form-row col-2 pr-1">

                                        <div class="form-group col-md-5">
                                            <label for="inpHour" id="lblInpHour">Hour</label>
                                            <input type="text" list="dataListHours" id="inpHour" placeholder="00-23" maxlength="2" class="form-control" required>
                                            <datalist id="dataListHours">
                                                <option value="00">
                                                <option value="01">
                                                <option value="02">
                                                <option value="03">
                                                <option value="04">
                                                <option value="05">
                                                <option value="06">
                                                <option value="07">
                                                <option value="08">
                                                <option value="09">
                                                <option value="10">
                                                <option value="11">
                                                <option value="12">
                                                <option value="13">
                                                <option value="14">
                                                <option value="15">
                                                <option value="16">
                                                <option value="17">
                                                <option value="18">
                                                <option value="19">
                                                <option value="20">
                                                <option value="21"
                                                <option value="22">
                                                <option value="23">
                                            </datalist>
                                            <span><small id="warning-inpHour" class="mg-warning-input mg-hide-element">Mbg!</small></span>
                                        </div>

                                        <div class="form-group col-md-7">
                                        <label for="inpSpecies" id="lblInpTaxa">Species</label>
                                        <input list="dataListTaxa" type="text" id="inpSpecies" placeholder="Taxa" class="form-control" maxlength="5">
                                        <datalist id="dataListTaxa">
                                        </datalist>
                                        <span><small id="warning-inpSpecies" class="mg-warning-input mg-hide-element"></small></span>
                                    </div>

                                    </div>

                                    <div class="form-row col-10 pl-1" id="secondRow">

                                        <div class="form-group col-md-2" id="ringSection">
                                            <label for="inpRing" id="lblRing">Ring</label>
                                            <input type="text" id="inpRing" placeholder="" class="form-control" maxlength="10">
                                            <span><small id="warning-inpRing" class="mg-warning-input"></small></span>
                                        </div>

                                        <div class="form-group col-md-1">
                                                <label for="inpAge" id="lblInpAge">Age</label>
                                                <input type="text" id="inpAge" placeholder="" class="form-control" maxlength="2" title="1, 1+, 2, 2+, etc.">
                                                <span><small id="warning-inpAge" class="mg-warning-input"></small></span>
                                            </div>

                                        <div class="form-group col-md-1">
                                            <label for="inpSex" id="lblInpSex">Sex</label>
                                            <select id="ddSex" class="form-control" name="ddTrappingMethod">
                                                <option value="-">-</option>
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-row mb-0">

                                    <div class="form-group col-md-2">
                                        <select id="dd-more-measurements" class="form-control form-control-sm">
                                            <option value="0" selected><span id="dd-more-measurements-default-text">More measurements</span></option>
                                            <?= $measurementOptions ?>
                                        </select>
                                    </div>

                                </div>
                                <div id="extra-measurements" class="col-3 mg-hide-element mt-0">
                                    <hr>
                                </div>

                                <!------------------------------------------------------------------------------------->
                                <div class="form-row">
                                    <div class="col-1 form-group">
                                        <button type="button" id="btnMoveOn" class="btn btn-outline-primary btn-sm">Next</button>
                                    </div>
                                </div>

                                <!------------------------------------------------------------------------------------->
                                <div id="additional-measurement-row" class="input-group input-group-sm mb-3 col-12 mg-hide-element p-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Something</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Value" aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <button id="btnRemoveMeasurementRow-" class="btn btn-outline-danger additional-measurement-row" type="button"> X </button>
                                    </div>
                                </div>


                                <div id="editControls" class="mg-hide-element">

                                    <div class="modal-footer">
                                        <button id="btnRingingRecordCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                                        <button id="btnRingingRecordSave" class="btn btn-primary" type="submit">xxxx</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="dataInputBatches">
                            <h4>When many birds...!</h4>
                        </div>

                        <div id="controlsInput">
                            <h4>Here we enter re-traps</h4>
                        </div>
                    </div>


                </div>
                <div>
                    <br/>
                    <h4 id="hdrEnteredData">Entered data</h4>
                </div>
                <div id="dataTabs">
                    <ul>
                        <li><a href="#dataTabFullList"><span id="tabDataFullList">Full list</span></a></li>
                        <li><a href="#dataTabSummaryByHour"><span id="tabDataSummaryHour">Summary - by hour</span></a></li>
                        <li><a href="#dataTabSummaryBySpeciesAndAge"><span id="tabDataSummaryAgeSpecies">Summary by species and age</span></a></li>
                        <li><a href="#dataTabCompare"><span id="tabDataComparisons">Comparisons</span></a></li>
                    </ul>
                    <div id="dataTabFullList">
                        <table id="data" class="table table-hover">
                        <thead>
                            <tr class="d-flex" id="dataTableHeader">
                                <th class="col-2" id="thRingNo">Ring No#</th>
                                <th class="col-1" id="thTaxa">Species</th>
                                <th class="col-1" id="thHour">Hour</th>
                                <th class="col-1" id="thAge">Age</th>
                                <th class="col-1" id="thSex">Sex</th>

                            </tr>
                        </thead>
                        <tbody id="speciesDataEntryTableBody">
                            <tr id="baseRow" class="mg-hide-element">
                                <td class="col-2">0</td>
                                <td class="col-1">1</td>
                                <td class="col-1">2</td>
                                <td class="col-1">3</td>
                                <td class="col-1">4</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div id="dataTabSummaryByHour">
                        <h4>Summary by hour goes here...</h4>
                        <p>A billion trillion tendrils of gossamer clouds hydrogen atoms vanquish the impossible vastness is bearable only through love stirred by starlight. Invent the universe emerged into consciousness the only home we've ever known dispassionate extraterrestrial observer something incredible is waiting to be known from which we spring. Bits of moving fluff finite but unbounded with pretty stories for which there's little good evidence network of wormholes the carbon in our apple pies a still more glorious dawn awaits and billions upon billions upon billions upon billions upon billions upon billions upon billions.</p>
                    </div>
                    <div id="dataTabSummaryBySpeciesAndAge">
                        <h4>Summary by species and age</h4>
                        <p>Can we try some other colours maybe I like it, but can the snow look a little warmer, for can the black be darker can you make the logo bigger yes bigger bigger still the logo is too big but i was wondering if my cat could be placed over the logo in the flyer, could you move it a tad to the left. Can you help me out? you will get a lot of free exposure doing this use a kpop logo that's not a kpop logo! ugh start on it today and we will talk about what i want next time im not sure, try something else, so doing some work for us "pro bono" will really add to your portfolio i promise. Can you make the blue bluer? can you make it stand out more? nor can you help me out? you will get a lot of free exposure doing this or I know somebody who can do this for a reasonable cost, and just do what you think. I trust you, but it's great, can you add a beard though . Use a kpop logo that's not a kpop logo!</p>
                    </div>
                    <div id="dataTabCompare">
                        <h4>Comparisons</h4>
                        <p>Halloumi cheesy feet hard cheese. Cow mascarpone lancashire cow cheesecake squirty cheese goat camembert de normandie. Croque monsieur cheese triangles pecorino cheesecake bocconcini brie stinking bishop boursin. St. agur blue cheese camembert de normandie cheese slices manchego parmesan fromage frais camembert de normandie queso. Danish fontina.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------------------------------------------------------------------- Modal R I N G S -->
    <div class="modal fade" id="modalEditRings" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRingsHeader">xxxx <span id="forWhatRing"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div id="modal-ring-types-avert">
                        Duck!
                    </div>

                    <div id="ring-types-rows">
                        <div class="form-group form-row mg-hide-element mg-row" id="rings-row-1">

                            <div class="form-group col-sm-4">
                                <label id="lblModalRingType-1">Ringtyp</label>
                                <select id="slct-rings-1" class="form-control" name="slct-rings-1">
                                    <?= $ringsOptions ?>
                                </select>
                            </div>

                            <div class="form-group col-sm-4">
                                <label id="lblModalRingNo-1">Nuv. ringnummer</label>
                                <input type="text" id="ring-no-1" class="form-control input-sm" name="inp-ring-1">
                            </div>

                            <div class="form-group col-sm-2">
                                <label id="lblModalDummy-1"><span class="mg-button-padding">..................</span></label>
                                <button id="btnRemoveRow-1" type="button" class="btn-sm btn-outline-danger mg-top-three" title="Remove Row"><b> X </b></button>
                            </div>

                        </div>
                    </div>
                    <div class="text-danger" id="div-not-unique"><small id="rings-not-unique">Some test text here..</small></div>
                    <br/>
                    <button id="btnRingAdd" type="button" class="btn-sm btn-primary">xxxx</button>
                </div>

                <div class="modal-footer">
                    <button id="btnRingCancel" type="button" class="btn btn-secondary" data-dismiss="modal">xxxx</button>
                    <button id="btnRingSave" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>

    <!---------------------------------------------------------------------------------------------- Modal - prompt check rings -->
    <div class="modal fade" id="modalPromptRingCheck" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPromptRingCheckHeader">xxxx</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <p id="modalPromptRingCheckMessage">Please check rings before starting a data entry session.</p>

                </div>

                <div class="modal-footer">
                    <button id="btnModalPromptRingCheckClose" class="btn btn-primary" type="submit">xxxx</button>
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------------------------------------------------------------------- Modal - prompt check rings -->
    <div class="modal fade" id="modalDayDone" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDayDoneHeader">xxxx</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <p id="modalDayDoneMessage"></p>

                </div>

                <div class="modal-footer">
                    <button id="btnModalDayDoneNo" class="btn btn-primary">xxxx</button>
                    <button id="btnModalDayDoneYes" class="btn btn-primary">xxxx</button>
                </div>
            </div>
        </div>
    </div>

<?= getHTMLEnd();
