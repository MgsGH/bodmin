<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "aahelpers/TopMenu.php";
include_once "aahelpers/PageMetaData.php";
include_once "aahelpers/common-functions.php";
include_once "aahelpers/db.php";

$path = '/home/hkghbhzh/public_html';
if ($_SERVER['HTTP_HOST'] === 'fbo.localhost'){
    $path =  'C:\xampp\apps\fbo\htdocs';
}

// https://stackoverflow.com/questions/1547381/how-do-i-cache-a-web-page-in-php


// Steers linked-in CSS and JS files
$pageMetaData = New PageMetaData('');
$pageMetaData->setAdditionalJavaScriptFiles('/aahelpers/blog-common.js');
$pageMetaData->setAdditionalJavaScriptFiles('home.js');

$pageMetaData->setJquery(true);
$pageMetaData->setJQueryUI(true);
$pageMetaData->setBootstrapFem(true);


//footer info
$introText = ' ';
$updatedDate = '2022-03-16';
$updatedBy = ' ';

$language = getRequestLanguage();

$pageMenu = New TopMenu($language);
$pageMenu->setStartSidaSelected();
$aSolen = sol_upp_ned($language);


echo getHtmlHead('', $pageMetaData, $language);
?>

    <div class="basePage">
        <?php echo getBannerHTML('fbohome.jpg'); ?>
        <?php echo $pageMenu->getHTML(); ?>

        <div class="container">

            <span id="langAsNo" class="mg-hide-element"><?= getLang($language) ?></span>

            <div class="d-flex pl-0 justify-content-between">

                <div class="col-center mr-2 pr-4">

                    <div id="homeHeader" class="mb-2">

                        <div class="mt-2 mb-1">
                            <span id="introToday"></span>
                            <span id="introDayData"></span>.
                            <span id="introSunUp"> Solen går upp </span>
                            <span id="introSunUpData"><?= $aSolen[0] ?></span>
                            <span id="introSunDown">och ned </span>
                            <span id="introSundownData"><?= $aSolen[1] ?></span>.
                            <span id="introNamesData"></span>
                            <span id="introNamesSuffix"> har namnsdag.</span>
                        </div>


                        <div id="smhiSection">
                            <table class="smhi">
                                <tr class="smhi-blue-row">
                                    <td rowspan="4" class="center">
                                        <a target="_blank" href="https://www.smhi.se/vader/prognoser/ortsprognoser/q/Skan%C3%B6r%20med%20Falsterbo/Vellinge/3336568#tab=table" title="Klicka för prognos!">
                                           <img alt="SMHI logga" src="./bilder/smhilogo2.gif">
                                        </a>
                                    </td>
                                    <td colspan="8" class="center pt-1 pb-2">
                                        <span id="smhiHeaderWeatherType"><span id="smhiHeader"></span> <span id="smhiInfo"></span></span>
                                    </td>
                                </tr>
                                <tr class="smhi-blue-row">
                                    <td id="smhiHeaderTime" class="smhi-header-50">Tid</td>
                                    <td id="smhiHeaderClouds" class="smhi-info"></td>
                                    <td id="smhiHeaderWind" class="smhi-info"></td>
                                    <td id="smhiHeaderTemp" class="smhi-info"></td>
                                    <td id="smhiHeaderWindChill" class="smhi-info"></td>
                                    <td id="smhiHeaderVisibility" class="smhi-info"></td>
                                    <td id="smhiHeaderPressure" class="smhi-info"></td>
                                    <td id="smhiHeaderComment" class="smhi-info">Comment</td>
                                </tr>

                                <tr class="smhi-blue-row">
                                    <td class="smhi-data-50"><b><span id="smhiDataTime"></span></b></td>
                                    <td class="smhi-data"><b><span id="smhiDataClouds"></span></b></td>
                                    <td class="smhi-data"><b><span id="smhiDataWindDirection"></span>&nbsp;<span id="smhiDataWindForce"></span> m/s</b></td>
                                    <td class="smhi-data"><b><span id="smhiDataTemp"></span></b></td>
                                    <td class="smhi-data"><b><span id="smhiDataChillFactor"></span></b></td>
                                    <td class="smhi-data"><b><span id="smhiDataVisibility"></span> km</b></td>
                                    <td class="smhi-data"><b><span id="smhiDataPressure"></span> hPa</b></td>
                                    <td class="text-nowrap pr-1"><b><span id="smhiDataComment"></span></b>&nbsp;</td>
                                </tr>
                                <tr class="smhi-blue-row">
                                    <td colspan="8" class="center pt-1 pb-2">
                                        <span id="smhiInfoII"></span> <a href="https://www.smhi.se/q/Falsterbo/Vellinge/2715477" target="_blank"><span id="smhiShortPrognosisText"></span></a>
                                    </td>
                                </tr>
                            </table>
                            <div>

                            </div>
                        </div>
                    </div>

                    <div id="newsSection">


                        <div id="theMostRecentBlogEntry" class="mb-4">
                            <div class="pt-5 pb-5"><img src="/aahelpers/img/loading/ajax-loader.gif" alt="loading" class="mx-auto d-block"></div>
                        </div>

                        <div id="featuredNews" class="none">
                            <div class="pb-3 mg-hide-element" id="featuredNewsIntroSection">
                                <h2 id="headerAndraNyheter"></h2>
                                <p id="featuredNewsIngress"></p>
                            </div>

                            <div id="featuredNewsBody" class="pb-2">

                            </div>
                        </div>

                    </div>

                </div>

                <div id="home-right-col">

                    <div id="gallerySection">

                        <div class="text-center pt-4">

                            <small id="galleryIntro">Tre&nbsp;senaste&nbsp;bilderna</small>
                        </div>

                        <div id="gallerySectionBody">

                        </div>

                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        <a href="https://falsterbofagelstation.se/omoss/stod.php">
                            <img src="bilder/bgmes2_w.jpg" width="100" height="130" class="icon" alt="logga med 90 nummer, Bankgiro 900 3012">
                        </a>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a href="https://www.insamlingskontroll.se/">
                            <img src="bilder/90konto100.gif" alt="logga med 90 nummer, Bankgiro 900 3012">
                        </a>
                    </div>

                    <div class="pt-4">
                        <div class="d-flex justify-content-center" id="ringFound">
                            Upphittad&nbsp;ring?
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="https://www.nrm.se/forskningochsamlingar/miljoforskningochovervakning/rapporteraring/internetformular.3300.html">
                                <img src="bilder/ring1tr.gif" alt="Bild på ring" class="icon">
                            </a>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="https://www.nrm.se/forskningochsamlingar/miljoforskningochovervakning/rapporteraring/internetformular.3300.html">
                                <span id="ringReportHere">Rapportera här</span>
                            </a>
                        </div>

                    </div>


                    <div class="text-center pt-4 container">
                        <h4 id="lokalt">Lokalt</h4>
                        <hr>
                    </div>
                    <div class="d-flex justify-content-center pt-1 mb-3">
                        <a href="https://www.falsterbofagelstation.se/sales/">
                            <img src="bilder/fyrshopen_5x3.jpg" alt="icon" class="">
                        </a>
                    </div>
                    <div class="d-flex justify-content-center pt-2">
                        <a href="https://www.falsterbonaset.se/">
                            <img src="bilder/fnflogga110px.jpg" alt="icon" class="">
                        </a>
                    </div>
                    <div class="text-center">
                        <a href="https://www.falsterbonaset.se/">
                            Falsterbonäsets
                        </a>
                        <br/>
                        <a href="https://www.falsterbonaset.se/">
                            Naturvårds-Förening
                        </a>
                    </div>

                    <div class="d-flex justify-content-center pt-3">
                        <a href="https://www.microbirding.se/kommun.php?kommunid=1233">
                            <img src="bilder/vex.jpg" class="mx-auto d-block" alt="logga">
                        </a>
                    </div>
                </div>

            </div>
            <hr>
            <div id="supportersSection" class="container-fluid">
                <div class="text-center">
                    <h4 id="supporters">Finansiella supporters (alfabetisk ordning)</h4>
                </div>

                <div class="text-center mt-2 mb-4">
                    Johan och Jakob Söderbergs stiftelse, Crafoordska stiftelsen samt Marie Claire Cronstedts stiftelse
                </div>

                <div class="row horizontal align-items-center">

                    <div class="col vertical">
                        <a href="https://www.kiteoptics.com/en/nature/">
                        <img class="center-block image-center" alt="Kite optics logotype" src="bilder/kitelogo.jpg"/>
                        </a>
                    </div>


                    <div class="col vertical justify-content-center text-center m-auto">
                        <a href="https://stiftelsemedel.se/stiftelsen-lunds-djurskyddsfond/">
                          Stiftelsen Lunds djurskyddsfond
                        </a>
                    </div>

                    <div class="col vertical">
                        <div class="d-flex justify-content-center">
                            <a href="https://www.naturvardsverket.se/">
                            <img class="center-block" alt="Naturvårdsverket" src="bilder/nv_logo.gif"/>
                            </a>
                        </div>
                    </div>


                    <div class="col vertical">
                        <a href="https://www.scanbird.com/">
                        <img class="center-block" alt="Scanbird logotype" src="bilder/scanbird_w.jpg"/>
                        </a>
                    </div>

                    <div class="col vertical">
                        <a href="https://www.skane.se/">
                            <img class="center-block" alt="Region Skåne logotype" src="bilder/reg_skane.jpg"/>
                        </a>
                    </div>

                </div>


                <div class="row horizontal align-items-center pt-4">


                    <div class="col vertical">
                        <a href="https://www.studieframjandet.se/">
                        <img class="center-block" alt="logga" src="bilder/sfrlogo110px.jpg"/>
                        </a>
                    </div>

                    <div class="col vertical justify-content-center text-center m-auto">
                        <div class="d-flex justify-content-center">
                            <a href="https://www.zeiss.com/consumer-products/int/nature-observation.html">
                                <img class="center-block ml-3" alt="SkOF logga" width="85" src="bilder/sponsorer/zeiss.png"/>
                            </a>
                        </div>

                    </div>

                    <div class="col vertical">
                        <a href="https://vellinge.se/">
                            <img class="center-block" alt="Vellinge kommun logga" src="bilder/vellinge110px.jpg"/>
                        </a>
                    </div>

                    <div class="col vertical">
                        <a href="https://www.wildlifegarden.se/">
                        <img class="center-block" alt="WildLife garden logga" src="bilder/wg-blackwebb.jpg"/>
                        </a>
                    </div>

                    <div class="col vertical">
                        <a href="https://www.swarovskioptik.com/se/en/birding/">
                            <img class="center-block" alt="Swarovski logga" src="bilder/so_logo.jpg"/>
                        </a>
                    </div>

                </div>
                <div class="text-center pt-4">
                    samt, inte minst <b>283</b> enskilda givare
                </div>
            </div>
        </div>

        <?php echo getFormattedPageFooter($introText, $updatedDate, $updatedBy ); ?>
    </div>

<?php echo getHTMLEndWithJS($pageMetaData->getJavaScriptSection());