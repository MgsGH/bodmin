<?php
session_start();
include_once "RingTexter.php";
include_once "RingmarkningMenu.php";
include_once "../aahelpers/PageMetaData.php";
include_once "../aahelpers/TopMenu.php";
include_once "../aahelpers/common-functions.php";
include_once "../aahelpers/db.php";


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('ringmarkningHeader.js');
$pageMetaData->setAdditionalJavaScriptFiles('aterfynd.js');
$pageMetaData->setJquery(true);
$pageMetaData->setBootstrapFyra(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setMultiSelect(true);
$pageMetaData->setSelect2(true);
$pageMetaData->setLeafLet(true);

//footer info
$introText = ' ';
$updatedDate = '2021-12-03';
$updatedBy = ' ';

$pdo = getDataPDO();

$language = getRequestLanguage();
$langAsNo = 2;
if (isset($_GET['lang'])){
    if ($_GET['lang'] === 'en'){
        $langAsNo = 1;
    }
}

$texts = new RingTexter($language);

$arterData = getRingedAndRecoveredTaxa($pdo, $langAsNo);

//
$defaultArt = 'BLMES';
$selectedArt = getSessionThenRequestLastDefaultValue('art', $defaultArt);
if (!selectedTaxaAmongArterData($selectedArt, $arterData)){
    $selectedArt = $defaultArt;
}

$defaultYear = getCurrentYear()-1;
$selectYear = getSessionThenRequestLastDefaultValue('year', $defaultYear);
$startYear = 1947;
$dropDownRingingYears = getDropDownYears($startYear);

$pageMenu = New TopMenu($language);
$pageMenu->setMarkningSelected();

$sectionMenu = new RingmarkningMenu($language);
$sectionMenu->setAterfyndSelected();

echo getHtmlHead('', $pageMetaData, $language);

?>

    <div class="basePage">

        <?php echo getBannerHTML('ringmvinjett.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>
        <span id="lang" class="mg-hide-element"><?= $langAsNo ?></span>

        <div class="d-flex mt-2">

            <div>
                <?php echo $sectionMenu->getHTML(); ?>
            </div>

            <div class="container">
                <h2 id="mainHeader"><?= $texts->getTxt('aterfynd') ?></h2>
                <div class="control-panel pt-3 px-3 py-0 pb-3">

                    <div>
                        <div>
                            <label for="slcttaxa" id="labelSelectTaxa">Välj en ringmärkt (och återfunnen) art</label>
                            <select name="art" class="form-select js-example-basic-single" id="slcttaxa">
                                <?php
                                foreach ($arterData as $art){
                                    echo getDropDownOption($art['NAME'], $art['SHORTNAME'], $selectedArt);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="pt-2">
                            <span id="labelFilter">Filtrera data ytterligare</span>
                        </div>

                    </div>

                    <div>
                        <div class="d-flex">
                            <div class="card">
                                <div class="card-header">
                                    <strong id="cardHeaderRinged">Märkdata</strong>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            <label for="slctRingingYears" id="labelRingedYears">År</label><br/>
                                            <select name="year" class="select" multiple="multiple" id="slctRingingYears">
                                                <?php
                                                echo getDropDownOption($texts->getTxt('alla-ar'), 'alla', $selectYear);
                                                foreach ($dropDownRingingYears as $year){
                                                    $txt = $year;
                                                    echo getDropDownOption($txt, $year, $selectYear);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="ml-2">
                                            <label for="slctRingingMonths" id="labelRingedMonths">Månad</label><br/>
                                            <select name="months" multiple="multiple" class="select" id="slctRingingMonths">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <label for="slctage" id="labelRingedAge">Ålder</label><br/>
                                        <select class="select" multiple="multiple" id="slctage">
                                        </select>
                                    </div>
                                    <div id="sexDropDownSection" class="pt-3">
                                        <label for="slctsex" id="labelRingedSex">Kön (om arten tillåter detta)</label><br/>
                                        <select class="select" multiple="multiple" id="slctsex">
                                            <option value="1">Hanarx</option>
                                            <option value="2">Honorx</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card ml-3">
                                <div class="card-header">
                                    <strong id="cardHeaderRecoveries">Återfyndsdata</strong>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            <label for="slctRecoveryYears" id="labelRecoveriesYears">År</label><br/>
                                            <select name="recoveryYears" class="form-select" multiple="multiple" id="slctRecoveryYears">
                                            </select>
                                        </div>
                                        <div class="ml-2">
                                            <label for="slctRecoveryMonths" id="labelRecoveriesMonths">Månad</label><br/>
                                            <select name="recoveryMonths" multiple="multiple" class="select" id="slctRecoveryMonths">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="Xmt-2">

                                        <div class="mgFull mt-3">
                                            <label for="inputTime" id="labelInputTime">Tidsintervall:</label>
                                            <input type="text" id="inputTime" readonly style="border:0; color:#2333e7; ">
                                            <div id="sliderTime"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6 text-left">
                                                <small id="sliderTimeMinValue">0</small>
                                            </div>
                                            <div class="col-6 text-right">
                                                <small id="sliderTimeMaxValue">max</small>
                                            </div>
                                        </div>

                                        <div class="mgFull mt-3">
                                            <label for="inputDistance" id="labelInputDistance">Avståndsintervall:</label>
                                            <input type="text" id="inputDistance" readonly style="border:0; color:#2333e7; ">
                                            <div id="sliderDistance"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-left">
                                                <small id="sliderDistanceMinValue">0</small>
                                            </div>

                                            <div class="col-6 text-right">
                                                <small id="sliderDistanceMaxValue">max</small>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <br/>
                </div>
                <div id="datatabs">
                    <div class="pb-3">
                        <ul>
                            <li><a href="#dataMeta"><span id="tabHeaderSummary">Sammanställning</span></a></li>
                            <li id="tabMap"><a href="#dataMap"><span id="tabHeaderMap">Karta</span></a></li>
                            <li><a href="#dataList"><span id="tabHeaderList">Lista</span></a></li>
                            <li><a href="#dataInfo"><span id="tabHeaderGoodToKnow">Bra att veta</span></a></li>
                        </ul>
                    </div>
                    <div id="dataList">
                        <div id="areaList">
                            <table class="table striped">
                                <thead>
                                    <tr>
                                        <th id="tabListRingingData">Märkdata</th>
                                        <th id="tabListRecoveryData">Återfyndsdata</th>
                                    </tr>
                                </thead>
                                <tbody id="tableRecoveries">

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div id="dataMeta">
                        <div id="areaMeta" class="d-flex">
                            <div>
                                <h5 id="dataMetaHeader">Xxxx</h5>
                                <p><strong><span id="taxonGrandTotal">Totalt</span></strong><br/>
                                    <span id="rmTot">999</span><span id="taxonGrandTotalOne"> ringmärkta, av dessa är </span><span id="totRecoveries">XX</span> (<span id="rmProcent">x</span>% )<span id="taxonGrandTotalTwo"> återfunna (inkl lokala fynd) </span><br/>
                                </p>
                                <strong><span id="filteringHeader">Efter filtering enligt ovan</span></strong><br/>
                                <span id="rmFilterTot">65</span> (<span id="rmFilterProcent">x</span>% )<span id="filteringSuffix"> återfynd.</span><br/>
                            </div>

                        </div>
                        <div class="d-flex pt-4">
                            <div class="pr-2">
                                <strong><span id="distanceListHeader">Mest långväga fynd</span></strong>
                                <p id="avstandsLista"></p>
                            </div>
                            <div class="pl-2">
                                <div class="pr-2">
                                    <strong><span id="timeListHeader">Största tidsintervall</span></strong>
                                    <p id="tidsLista"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="dataMap">
                        <div id="rmap" style="height: 600px"></div>
                    </div>

                    <div id="dataInfo">

                        <strong>Artlistan</strong>
                        <p>Listan innehåller endast de arter/raser som har givit (minst ett) återfynd av fåglar märkta vid Falsterbo.</p>

                        <p>Fåglar som ringmärkts på andra platser och kontrollerats vid Falsterbo ingår t.v. inte. Inte heller kontroller av egna märkningar.</p>

                        <p>För småfåglar är återfyndsandelen mycket låg, ofta bara någon enstaka procent. Varje urval minskar antalet fynd som visas och kan alltså till slut resultera i att inga fynd visas.</p>

                        <strong>Ålder vid märktillfället</strong>
                        <p>Majoriteten av småfåglarna är märkta som flygga årsungar. Vadare och större fåglar innehåller en större andel fynd av fåglar märkta som adulta. Boungemärkning i större skala har utförts på måsar, tärnor, blåmes, talgoxe och stare samt i mindre omfattning på tornfalk, kattuggla, rödstjärt och svartvit flugsnappare.</p>
                        <p>Endast de åldrar som är registrerade för vald art och de fåglar som återfunnits visas bland åldersvalen. </p>

                        <strong>Kön</strong>
                        <p>Könsurval visas endast då arten åtminstone i vissa dräkter/åldrar kan könsbestämmas.</p>

                        <strong>Tidsperiod</strong>
                        <p>Endast år och månader då vald art har fångats (och senare återfunnits) visas i tidsurvalet i sektionen märkdata. Detsamma gäller återfyndsdata, endast år och månader då en ringmärkt fågel har påträffats visas.</p>
                        <p>Det är inte ovanligt att datum för påträffande är oklart. Dessa fynd filteras inte med hjälp av tids reglaget, då vi inte vet hur lång tid som har förflutit sedan märkningen. </p>

                        <strong>Avstånd</strong>
                        <p>På kartorna visas alla fynd som gjorts för vald art.</p>

                        <strong>Förfluten tid</strong>
                        <p>Genom att begränsa tidavståndet mellan märk- och fynddatum kan man t.ex. välja ut fynd under samma säsong. Observera att förfluten tid inte alltid är samma sak som fågelns ålder.</p>

                        <strong>Kartorna</strong>
                        <p>Fördelningen av fynd på kartorna visar i grova drag fåglarnas flyttningsvägar, häcknings- eller övervintringsområden. Man måste dock tänka på att fördelningen i hög grad även är relaterad till mänsklig närvaro och mänskliga aktiviteter (t.ex. jakt, ringmärkning).</p>
                    </div>
                </div>
            </div>

        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());